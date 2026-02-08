<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\Payment;
use App\Models\Region;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function admin()
    {
        try {
            // Cache dashboard data for 5 minutes to improve performance
            $cacheKey = 'admin_dashboard_' . Auth::id();
            
            $data = Cache::remember($cacheKey, 300, function () {
                $user = Auth::user();
                
                // Use eager loading to prevent N+1 queries - include payments relationship for accurate payment status
                $participants = Participant::with(['region', 'category', 'payments'])->get();
                
                $totalParticipants = $participants->count();
                $paidParticipants = $participants->filter(fn($p) => $p->is_paid)->count();
                $unpaidParticipants = $totalParticipants - $paidParticipants;
                
                // Get regions with participant counts including payment status
                $participantsByRegion = Region::with(['participants' => function($query) {
                    $query->with(['payments']);
                }])->get()->map(function ($region) {
                    $region->participants_count = $region->participants->count();
                    $region->paid_count = $region->participants->filter(fn($p) => $p->is_paid)->count();
                    return $region;
                });
                
                $participantsByCategory = Category::withCount('participants')->get();
                
                $paidPercentage = $totalParticipants > 0 ? round(($paidParticipants / $totalParticipants) * 100, 2) : 0;
                $unpaidPercentage = 100 - $paidPercentage;
                
                // Total revenue (sum of all payments made)
                $totalRevenue = Payment::sum('amount');
                
                // Human factor: Get latest activity with eager loading
                $latestParticipants = Participant::with(['region', 'category', 'payments'])
                    ->latest()
                    ->take(5)
                    ->get();
                
                return [
                    'totalParticipants' => $totalParticipants,
                    'paidParticipants' => $paidParticipants,
                    'unpaidParticipants' => $unpaidParticipants,
                    'participantsByRegion' => $participantsByRegion,
                    'participantsByCategory' => $participantsByCategory,
                    'paidPercentage' => $paidPercentage,
                    'unpaidPercentage' => $unpaidPercentage,
                    'totalRevenue' => $totalRevenue,
                    'latestParticipants' => $latestParticipants
                ];
            });

            Log::info('Admin dashboard accessed', [
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
                'total_participants' => $data['totalParticipants']
            ]);

            return view('dashboard-admin', $data);
            
        } catch (\Exception $e) {
            Log::error('Error loading admin dashboard', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip()
            ]);
            
            return redirect()->back()->with('error', 'Gagal memuat dashboard. Silakan coba lagi.');
        }
    }

    public function daerah()
    {
        try {
            $user = Auth::user();

            // Ambil data langsung (tanpa cache) supaya daftar selalu up-to-date
            $participants = Participant::with(['region', 'category', 'payments'])
                ->where('region_id', $user->region_id)
                ->get();
            
            $totalParticipants = $participants->count();
            $paidParticipants = $participants->filter(fn($p) => $p->is_paid)->count();
            $unpaidParticipants = $totalParticipants - $paidParticipants;
            
            // Get categories dengan hitungan untuk region ini
            $participantsByCategory = Category::with(['participants' => function($query) use ($user) {
                $query->where('region_id', $user->region_id)->with(['payments']);
            }])->get()->map(function ($category) {
                $category->participants_count = $category->participants->count();
                $category->paid_count = $category->participants->filter(fn($p) => $p->is_paid)->count();
                return $category;
            });
            
            $paidPercentage = $totalParticipants > 0 ? round(($paidParticipants / $totalParticipants) * 100, 2) : 0;
            $unpaidPercentage = 100 - $paidPercentage;
            
            // Revenue untuk region ini saja
            $regionParticipantIds = $participants->pluck('id');
            $totalRevenue = Payment::whereIn('participant_id', $regionParticipantIds)->sum('amount');
            
            // Peserta terbaru region ini
            $latestParticipants = Participant::with(['region', 'category', 'payments'])
                ->where('region_id', $user->region_id)
                ->latest()
                ->take(5)
                ->get();

            $data = [
                'regionParticipants' => $participants,
                'latestActivity' => $latestParticipants,
                'categories' => Category::all(),
                'totalParticipants' => $totalParticipants,
                'paidParticipants' => $paidParticipants,
                'unpaidParticipants' => $unpaidParticipants,
                'participantsByCategory' => $participantsByCategory,
                'paidPercentage' => $paidPercentage,
                'unpaidPercentage' => $unpaidPercentage,
                'totalRevenue' => $totalRevenue
            ];

            Log::info('Regional dashboard accessed', [
                'user_id' => $user->id,
                'region_id' => $user->region_id,
                'ip_address' => request()->ip(),
                'total_participants' => $data['totalParticipants']
            ]);

            return view('dashboard-daerah', $data);
            
        } catch (\Exception $e) {
            Log::error('Error loading regional dashboard', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'region_id' => Auth::user()->region_id ?? 'unknown',
                'ip_address' => request()->ip()
            ]);
            
            return redirect()->back()->with('error', 'Gagal memuat dashboard wilayah. Silakan coba lagi.');
        }
    }

    public function visitor()
    {
        try {
            // Cache visitor data for better performance
            $cacheKey = 'visitor_dashboard';
            
            $data = Cache::remember($cacheKey, 600, function () {
                // Use eager loading for better performance - include payments for accurate payment status
                $participants = Participant::with(['region', 'category', 'payments'])->get();
                
                return [
                    'participants' => $participants
                ];
            });

            Log::info('Visitor dashboard accessed', [
                'ip_address' => request()->ip(),
                'total_participants' => $data['participants']->count()
            ]);

            return view('dashboard-pengunjung', $data);
            
        } catch (\Exception $e) {
            Log::error('Error loading visitor dashboard', [
                'error' => $e->getMessage(),
                'ip_address' => request()->ip()
            ]);
            
            return redirect()->back()->with('error', 'Gagal memuat dashboard pengunjung.');
        }
    }

    public function keseluruhan()
    {
        try {
            // Show all participants regardless of user role (like visitor view)
            // But without edit capabilities - read-only access
            
            // Cache the data for better performance
            $cacheKey = 'keseluruhan_participants';
            
            $participants = Cache::remember($cacheKey, 300, function () {
                return Participant::with(['region', 'category', 'payments'])
                    ->get();
            });

            Log::info('Keseluruhan participants view accessed', [
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
                'total_participants' => $participants->count()
            ]);

            return view('keseluruhan-peserta', compact('participants'));
            
        } catch (\Exception $e) {
            Log::error('Error loading keseluruhan participants', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip()
            ]);
            
            return redirect()->back()->with('error', 'Gagal memuat data peserta keseluruhan.');
        }
    }

    public function shareToWhatsApp()
    {
        try {
            $user = Auth::user();
            
            // Fetch all settings
            $settings = \App\Models\Setting::pluck('value', 'key');

            // Admin can see all participants, regional user can only see their own region
            if ($user->isAdmin()) {
                // Fetch all participants with their region and payment status
                $participants = Participant::with(['region', 'payments'])->get();
            } else {
                // Fetch only participants from user's region
                $participants = Participant::with(['region', 'payments'])
                    ->where('region_id', $user->region_id)
                    ->get();
            }

            // Group participants by region
            $participantsByRegion = [];
            foreach ($participants as $participant) {
                $regionName = $participant->region->name ?? 'Unknown Region';
                if (!isset($participantsByRegion[$regionName])) {
                    $participantsByRegion[$regionName] = [];
                }
                $participantsByRegion[$regionName][] = $participant;
            }

            // 1. Build Header
            $message = "✨ *" . ($settings['wa_header'] ?? "LAPORAN ROMBONGAN PPMHA") . "* ✨\n\n";
            $message .= "Halo Bapak/Ibu, berikut kami lampirkan update data peserta:\n\n";

            // 2. Schedule Section
            $message .= "🗓️ *JADWAL KEBERANGKATAN*\n";
            $message .= "------------------------------------\n";
            $message .= ($settings['wa_schedule'] ?? "_Segera Diupdate_") . "\n\n";

            // 3. Departure Info
            $message .= "📍 *TITIK KUMPUL*\n";
            $message .= ($settings['wa_departure'] ?? "_Menunggu Informasi_") . "\n";
            $message .= "------------------------------------\n\n";

            // 4. Fees and Himbauan
            if(!empty($settings['wa_fees'])) {
                $message .= "💰 *RINCIAN BIAYA*\n";
                $message .= $settings['wa_fees'] . "\n\n";
            }

            if(!empty($settings['wa_himbauan'])) {
                $message .= "💡 *CATATAN PENTING*\n";
                $message .= $settings['wa_himbauan'] . "\n\n";
            }

            // 5. Participant List
            $message .= "👥 *DAFTAR PESERTA PER WILAYAH*\n";
            $message .= "====================================\n\n";
            
            foreach ($participantsByRegion as $regionName => $regionParticipants) {
                $message .= "📍 *" . strtoupper($regionName) . "*\n";
                foreach ($regionParticipants as $index => $participant) {
                    $statusSymbol = $participant->is_paid ? " ✅" : " ⏳";
                    $message .= "   " . ($index + 1) . ". " . $participant->name . $statusSymbol . "\n";
                }
                $message .= "\n";
            }

            $message .= "📊 *RINGKASAN TOTAL*\n";
            $message .= "• Total Peserta: " . $participants->count() . "\n";
            $message .= "• Sudah Lunas: " . $participants->filter(fn($p) => $p->is_paid)->count() . "\n";
            $message .= "• Belum Lunas: " . $participants->filter(fn($p) => !$p->is_paid)->count() . "\n\n";

            // 6. Bank and Contacts
            if(!empty($settings['wa_bank_info'])) {
                $message .= "💳 *INFO PEMBAYARAN*\n";
                $message .= $settings['wa_bank_info'] . "\n\n";
            }

            if(!empty($settings['wa_contacts'])) {
                $message .= "📞 *KONTAK KONFIRMASI*\n";
                $message .= $settings['wa_contacts'] . "\n\n";
            }

            $message .= "------------------------------------\n";
            $message .= "_Pesan ini dibuat otomatis oleh Sistem " . ($settings['title_text'] ?? 'PPMHA') . "_";

            // Encode message for WhatsApp URL
            // Use rawurlencode to better handle multi-byte characters like emojis
            $encodedMessage = rawurlencode($message);

            Log::info('WhatsApp share initiated', [
                'user_id' => $user->id,
                'participant_count' => $participants->count(),
                'ip_address' => request()->ip()
            ]);

            return response()->json(['url' => "https://api.whatsapp.com/send?text={$encodedMessage}"]);
            
        } catch (\Exception $e) {
            Log::error('Error generating WhatsApp share', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip()
            ]);
            
            return response()->json(['error' => 'Gagal membuat pesan WhatsApp'], 500);
        }
    }
}
