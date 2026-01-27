
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Traits\SecureValidationTrait;
use App\Services\AuditTrailService;

class ParticipantController extends Controller
{
    use SecureValidationTrait;

    public function store(Request $request)
    {
        // Enhanced validation with security measures using trait
        $validator = $this->validateParticipantData($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        // Ensure user can only add participants to their own region
        if ($user->region_id != $request->region_id && !$user->isAdmin()) {
            $this->logSecurityEvent('unauthorized_participant_creation', [
                'attempted_region_id' => $request->region_id
            ]);
            abort(403);
        }

        try {
            $participant = Participant::create([
                'name' => trim($request->name),
                'region_id' => $request->region_id,
                'category_id' => $request->category_id,
            ]);

            // Log audit trail
            AuditTrailService::logCreation(
                Participant::class,
                $participant->id,
                $participant->toArray(),
                "Created participant: {$participant->name}"
            );

            Log::info('Participant created successfully', [
                'participant_id' => $participant->id,
                'created_by' => $user->id,
                'ip_address' => $request->ip()
            ]);

            // Clear the regional dashboard cache to show the new participant immediately
            \Illuminate\Support\Facades\Cache::forget('daerah_dashboard_' . $user->region_id);

            return redirect()->route('dashboard.daerah')->with('success', 'Peserta berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Failed to create participant', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
                'input_data' => $request->except(['_token']),
                'ip_address' => $request->ip()
            ]);
            
            return redirect()->back()->with('error', 'Gagal menambahkan peserta. Silakan coba lagi.')->withInput();
        }
    }

    public function show($id)
    {
        try {
            $participant = Participant::with(['region', 'category', 'payments'])->findOrFail($id);

            // Check authorization using trait method
            if (!$this->authorizeAccess($participant, 'participant')) {
                abort(403);
            }

            // Calculate payment-related data
            $categoryPrice = $participant->category ? $participant->category->price ?? 0 : 0;
            $totalPaid = $participant->payments->sum('amount');
            $remainingBalance = max(0, $categoryPrice - $totalPaid);
            $isFullyPaid = $remainingBalance <= 0;
            
            // Calculate payment progress percentage
            $paymentProgress = $categoryPrice > 0 ? round(($totalPaid / $categoryPrice) * 100, 2) : 100;

            // Log audit trail for viewing
            AuditTrailService::log(
                'VIEW',
                Participant::class,
                $participant->id,
                null,
                null,
                "Viewed participant: {$participant->name}",
                'info'
            );

            return view('detail-peserta', compact(
                'participant',
                'paymentProgress',
                'categoryPrice',
                'totalPaid',
                'remainingBalance',
                'isFullyPaid'
            ));
        } catch (\Exception $e) {
            Log::error('Error accessing participant', [
                'participant_id' => $id,
                'error' => $e->getMessage(),
                'ip_address' => request()->ip()
            ]);
            
            return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
        }
    }

    public function edit($id)
    {
        try {
            $participant = Participant::with(['region', 'category', 'payments'])->findOrFail($id);

            // Check authorization using trait method
            if (!$this->authorizeAccess($participant, 'participant')) {
                abort(403);
            }

            // Log audit trail for editing
            AuditTrailService::log(
                'VIEW',
                Participant::class,
                $participant->id,
                null,
                null,
                "Opened participant for editing: {$participant->name}",
                'info'
            );

            // Calculate payment-related data
            $categoryPrice = $participant->category ? $participant->category->price ?? 0 : 0;
            $totalPaid = $participant->payments->sum('amount');
            $remainingBalance = max(0, $categoryPrice - $totalPaid);
            $isFullyPaid = $remainingBalance <= 0;
            
            // Calculate payment progress percentage
            $paymentProgress = $categoryPrice > 0 ? round(($totalPaid / $categoryPrice) * 100, 2) : 100;

            return view('detail-peserta', compact(
                'participant',
                'paymentProgress',
                'categoryPrice',
                'totalPaid',
                'remainingBalance',
                'isFullyPaid'
            ));
        } catch (\Exception $e) {
            Log::error('Error accessing participant for edit', [
                'participant_id' => $id,
                'error' => $e->getMessage(),
                'ip_address' => request()->ip()
            ]);
            
            return redirect()->back()->with('error', 'Data peserta tidak ditemukan.');
        }
    }

    public function updateDetails(Request $request, $id)
    {
        // Enhanced validation using trait
        $validator = $this->validateParticipantData($request->all(), true);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $participant = Participant::findOrFail($id);

            // Check authorization using trait method
            if (!$this->authorizeAccess($participant, 'participant')) {
                abort(403);
            }

            $oldValues = $participant->toArray();
            $participant->update([
                'name' => trim($request->name),
                'category_id' => $request->category_id,
            ]);

            // Log audit trail
            AuditTrailService::logUpdate(
                Participant::class,
                $participant->id,
                $oldValues,
                $participant->toArray(),
                "Updated participant: {$participant->name}"
            );

            Log::info('Participant updated successfully', [
                'participant_id' => $participant->id,
                'updated_by' => Auth::id(),
                'changes' => $request->only(['name', 'category_id']),
                'ip_address' => $request->ip()
            ]);

            // Clear dashboard caches to show the updated participant immediately
            $this->clearDashboardCaches($participant->region_id);

            return redirect()->route('detail.peserta', $participant->id)->with('success', 'Data peserta berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Failed to update participant', [
                'participant_id' => $id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => $request->ip()
            ]);
            
            return redirect()->back()->with('error', 'Gagal memperbarui data peserta.')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        // Enhanced validation using trait
        $rules = [];
        if ($request->has('name')) {
            $rules['name'] = 'sometimes|required|string|max:255|regex:/^[a-zA-Z\s\-\']+$/';
        }
        if ($request->has('category_id')) {
            $rules['category_id'] = 'sometimes|required|exists:categories,id';
        }

        $validator = Validator::make($request->all(), $rules, [
            'name.regex' => 'Nama hanya boleh mengandung huruf, spasi, tanda hubung, dan apostrof.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $participant = Participant::findOrFail($id);

            // Check authorization using trait method
            if (!$this->authorizeAccess($participant, 'participant')) {
                abort(403);
            }

            $oldValues = $participant->toArray();
            $updates = [];
            if ($request->has('name')) {
                $updates['name'] = trim($request->name);
            }
            if ($request->has('category_id')) {
                $updates['category_id'] = $request->category_id;
            }

            $participant->update($updates);

            // Log audit trail
            AuditTrailService::logUpdate(
                Participant::class,
                $participant->id,
                $oldValues,
                $participant->toArray(),
                "Partially updated participant: {$participant->name}"
            );

            Log::info('Participant partially updated', [
                'participant_id' => $participant->id,
                'updated_by' => Auth::id(),
                'changes' => $updates,
                'ip_address' => $request->ip()
            ]);

            return redirect()->route('detail.peserta', $participant->id)->with('success', 'Peserta berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Failed to partially update participant', [
                'participant_id' => $id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => $request->ip()
            ]);
            
            return redirect()->back()->with('error', 'Gagal memperbarui peserta.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $participant = Participant::with('payments')->findOrFail($id);

            // Check authorization using trait method
            if (!$this->authorizeAccess($participant, 'participant')) {
                abort(403);
            }

            $oldValues = $participant->toArray();

            // Log before deletion
            AuditTrailService::logDeletion(
                Participant::class,
                $participant->id,
                $oldValues,
                "Deleted participant: {$participant->name}"
            );

            Log::info('Participant deletion initiated', [
                'participant_id' => $participant->id,
                'deleted_by' => Auth::id(),
                'participant_name' => $participant->name,
                'region_id' => $participant->region_id,
                'ip_address' => request()->ip()
            ]);

            // Delete related payments first to maintain referential integrity
            $participant->payments()->delete();

            // Now delete the participant
            $participant->delete();

            Log::info('Participant deleted successfully', [
                'participant_id' => $id,
                'deleted_by' => Auth::id(),
                'ip_address' => request()->ip()
            ]);

            // Clear dashboard caches to show the deletion immediately
            $this->clearDashboardCaches($participant->region_id);

            return redirect()->route('dashboard.daerah')->with('success', 'Peserta berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Failed to delete participant', [
                'participant_id' => $id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip()
            ]);
            
            return redirect()->back()->with('error', 'Gagal menghapus peserta.');
        }
    }

    public function updatePayment(Request $request, $id)
    {
        try {
            $participant = Participant::with('category', 'payments')->findOrFail($id);
            
            // Check authorization using trait method
            if (!$this->authorizeAccess($participant, 'participant')) {
                abort(403);
            }

            // Enhanced validation using trait
            $validator = $this->validatePaymentData($request->all());

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Calculate totals based on existing payments
            $categoryPrice = $participant->category->price ?? 0;
            $totalPaid = $participant->payments->sum('amount');
            $remainingBalance = max(0, $categoryPrice - $totalPaid);

            $amount = (float) $request->amount;

            // Validate payment amount
            if ($amount <= 0) {
                return redirect()->back()->withErrors([
                    'amount' => 'Jumlah pembayaran harus lebih besar dari 0.'
                ])->withInput();
            }

            // Check if participant is already fully paid
            if ($participant->payment_status === 'lunas') {
                return redirect()->back()->withErrors([
                    'amount' => 'Peserta sudah melunasi semua pembayaran. Tidak dapat menambah pembayaran lagi.'
                ])->withInput();
            }

            // For categories with price, check for overpayment
            if ($categoryPrice > 0) {
                $newTotalPaid = $totalPaid + $amount;

                // Prevent overpayment beyond a reasonable limit (e.g., 10% over the remaining balance)
                $maxAllowedPayment = $remainingBalance * 1.1; // Allow 10% overpayment for flexibility

                if ($amount > $maxAllowedPayment) {
                    return redirect()->back()->withErrors([
                        'amount' => "Jumlah bayar terlalu besar. Maksimal pembayaran yang diizinkan: Rp " . number_format($maxAllowedPayment, 0, ',', '.') . "."
                    ])->withInput();
                }
            }

            // Create payment record (status will be determined by model accessor)
            $payment = Payment::create([
                'participant_id' => $participant->id,
                'amount' => $amount,
                'payment_date' => $request->payment_date,
                'notes' => $request->notes ?? null,
            ]);

            // Log audit trail for payment
            AuditTrailService::logCreation(
                Payment::class,
                $payment->id,
                $payment->toArray(),
                "Recorded payment of Rp " . number_format($amount, 0, ',', '.') . " for participant: {$participant->name}"
            );

            Log::info('Payment recorded successfully', [
                'payment_id' => $payment->id,
                'participant_id' => $participant->id,
                'amount' => $amount,
                'recorded_by' => Auth::id(),
                'ip_address' => $request->ip()
            ]);

            // Clear dashboard caches to show the payment update immediately
            $this->clearDashboardCaches($participant->region_id);

            // Check if payment completes the balance after recording
            $participant->refresh(); // Refresh to get updated payment status
            $message = $participant->payment_status === 'lunas'
                ? 'Pembayaran berhasil! Peserta telah melunasi semua pembayaran.'
                : 'Pembayaran berhasil! Masih ada sisa pembayaran.';

            return redirect()->route('detail.peserta', $participant->id)->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Failed to record payment', [
                'participant_id' => $id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'input_data' => $request->except(['_token']),
                'ip_address' => $request->ip()
            ]);
            
            return redirect()->back()->with('error', 'Gagal mencatat pembayaran. Silakan coba lagi.')->withInput();
        }
    }
    
    public function destroyPayment($id)
    {
        try {
            $payment = Payment::with('participant')->findOrFail($id);
            
            // Check authorization using trait method
            if (!$this->authorizeAccess($payment, 'payment')) {
                abort(403);
            }

            $oldValues = $payment->toArray();

            // Log before deletion
            AuditTrailService::logDeletion(
                Payment::class,
                $payment->id,
                $oldValues,
                "Deleted payment of Rp " . number_format($payment->amount, 0, ',', '.') . " for participant: {$payment->participant->name}"
            );

            Log::info('Payment deletion initiated', [
                'payment_id' => $payment->id,
                'participant_id' => $payment->participant_id,
                'amount' => $payment->amount,
                'deleted_by' => Auth::id(),
                'ip_address' => request()->ip()
            ]);

            $participant = $payment->participant;
            $payment->delete();

            Log::info('Payment deleted successfully', [
                'payment_id' => $id,
                'deleted_by' => Auth::id(),
                'ip_address' => request()->ip()
            ]);

            // Clear dashboard caches to show the payment deletion immediately
            $this->clearDashboardCaches($participant->region_id);

            return redirect()->back()->with('success', 'Pembayaran berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Failed to delete payment', [
                'payment_id' => $id,
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'ip_address' => request()->ip()
            ]);
            
            return redirect()->back()->with('error', 'Gagal menghapus pembayaran.');
        }
    }
}