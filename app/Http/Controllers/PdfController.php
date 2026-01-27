<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\Region;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    public function downloadAllParticipants()
    {
        $user = Auth::user();
        
        // Admin can see all participants, regional user can only see their own region
        if ($user->isAdmin()) {
            $participants = Participant::with(['region', 'category', 'latestPayment'])->get();
        } else {
            $participants = Participant::with(['region', 'category', 'latestPayment'])
                ->where('region_id', $user->region_id)
                ->get();
        }

        $pdf = Pdf::loadView('pdf.participants-all', compact('participants'));
        return $pdf->download('laporan-semua-peserta.pdf');
    }

    public function downloadCategoryReport($id)
    {
        $category = Category::with(['participants.region', 'participants.latestPayment'])->findOrFail($id);
        $participants = $category->participants;

        $pdf = Pdf::loadView('pdf.category-report', compact('category', 'participants'));
        return $pdf->download('laporan-kategori-' . $category->name . '.pdf');
    }

    public function downloadRegionReport($id)
    {
        $region = Region::with(['participants.category', 'participants.latestPayment'])->findOrFail($id);
        $participants = $region->participants;

        $pdf = Pdf::loadView('pdf.region-report', compact('region', 'participants'));
        return $pdf->download('laporan-daerah-' . $region->name . '.pdf');
    }

    public function downloadAdminReport(Request $request)
    {
        $user = Auth::user();
        $sortBy = $request->query('sortBy', 'category'); // 'category' or 'region'
        
        // Admin can see all participants, regional user can only see their own region
        if ($user->isAdmin()) {
            $totalParticipants = Participant::count();
            $participants = Participant::with(['region', 'category', 'latestPayment'])->get();
            $participantsByRegion = Region::with(['participants'])->get();
        } else {
            $totalParticipants = Participant::where('region_id', $user->region_id)->count();
            $participants = Participant::with(['region', 'category', 'latestPayment'])
                ->where('region_id', $user->region_id)
                ->get();
            $participantsByRegion = Region::with(['participants'])->where('id', $user->region_id)->get();
        }
        
        $paidParticipants = \App\Models\Payment::where('status', 'lunas')->distinct('participant_id')->count();
        $unpaidParticipants = $totalParticipants - $paidParticipants;

        // Sort participants based on selection
        if ($sortBy === 'region') {
            $participants = $participants->sortBy('region.name');
        } else {
            $participants = $participants->sortBy('category.name');
        }
        
        $participantsByCategory = Category::with(['participants'])->get();

        $paidPercentage = $totalParticipants > 0 ? round(($paidParticipants / $totalParticipants) * 100, 2) : 0;
        $unpaidPercentage = 100 - $paidPercentage;

        $pdf = Pdf::loadView('pdf.admin-report', compact(
            'totalParticipants',
            'paidParticipants',
            'unpaidParticipants',
            'participantsByRegion',
            'participantsByCategory',
            'participants',
            'sortBy',
            'paidPercentage',
            'unpaidPercentage'
        ));
        return $pdf->download('laporan-admin-ppmha.pdf');
    }
}