<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Trait for secure validation and authorization
 * Provides enhanced security measures for form validation and access control
 */
trait SecureValidationTrait
{
    /**
     * Validate participant data with enhanced security
     *
     * @param array $data The input data to validate
     * @param bool $isUpdate Whether this is an update operation
     * @return \Illuminate\Validation\Validator
     */
    protected function validateParticipantData(array $data, bool $isUpdate = false)
    {
        $rules = [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\']+$/',
            'region_id' => 'required|exists:regions,id',
            'category_id' => 'required|exists:categories,id',
        ];

        $messages = [
            'name.regex' => 'Nama hanya boleh mengandung huruf, spasi, tanda hubung, dan apostrof.',
            'name.required' => 'Nama peserta wajib diisi.',
            'name.max' => 'Nama terlalu panjang (maksimal 255 karakter).',
            'region_id.required' => 'Wilayah wajib dipilih.',
            'region_id.exists' => 'Wilayah tidak valid.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
        ];

        if ($isUpdate) {
            // For updates, fields are optional but if provided they must be valid
            $rules['name'] = 'nullable|string|max:255|regex:/^[a-zA-Z\s\-\'\s]+$/';
        }

        $validator = Validator::make($data, $rules, $messages);
        
        if ($validator->fails()) {
            /** @var \Illuminate\Contracts\Auth\Authenticatable|null $user */
            $user = auth()->user();
            $userId = $user ? $user->getAuthIdentifier() : 'guest';
            
            Log::warning('Participant validation failed', [
                'errors' => $validator->errors()->toArray(),
                'input_data' => array_diff_key($data, array_flip(['_token'])),
                'user_id' => $userId,
                'ip_address' => request()->ip()
            ]);
        }

        return $validator;
    }

    /**
     * Validate payment data with enhanced security
     *
     * @param array $data The input data to validate
     * @return \Illuminate\Validation\Validator
     */
    protected function validatePaymentData(array $data)
    {
        $rules = [
            'amount' => 'required|numeric|min:0|max:999999999',
            'payment_date' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string|max:500|regex:/^[a-zA-Z0-9\\s\\-\\.,!?;:()]+$/',
        ];

        $messages = [
            'amount.required' => 'Jumlah pembayaran wajib diisi.',
            'amount.numeric' => 'Jumlah pembayaran harus berupa angka.',
            'amount.min' => 'Jumlah pembayaran tidak boleh negatif.',
            'amount.max' => 'Jumlah pembayaran terlalu besar.',
            'payment_date.required' => 'Tanggal pembayaran wajib diisi.',
            'payment_date.date' => 'Format tanggal tidak valid.',
            'payment_date.before_or_equal' => 'Tanggal pembayaran tidak boleh di masa depan.',
            'notes.max' => 'Catatan terlalu panjang (maksimal 500 karakter).',
        ];

        $validator = Validator::make($data, $rules, $messages);
        
        if ($validator->fails()) {
            /** @var \Illuminate\Contracts\Auth\Authenticatable|null $user */
            $user = auth()->user();
            $userId = $user ? $user->getAuthIdentifier() : 'guest';
            
            Log::warning('Payment validation failed', [
                'errors' => $validator->errors()->toArray(),
                'input_data' => array_diff_key($data, array_flip(['_token'])),
                'user_id' => $userId,
                'ip_address' => request()->ip()
            ]);
        }

        return $validator;
    }

    /**
     * Sanitize input data
     *
     * @param array $data The data to sanitize
     * @return array The sanitized data
     */
    protected function sanitizeInput(array $data)
    {
        $sanitized = [];
        
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                // Trim whitespace
                $value = trim($value);
                
                // Remove potentially dangerous characters
                $value = strip_tags($value);
                
                // Convert special characters to HTML entities
                $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
            
            $sanitized[$key] = $value;
        }
        
        return $sanitized;
    }

    /**
     * Log security events
     *
     * @param string $eventType The type of security event
     * @param array $details Additional details about the event
     * @return void
     */
    protected function logSecurityEvent(string $eventType, array $details = [])
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable|null $user */
        $user = auth()->user();
        $userId = $user ? $user->getAuthIdentifier() : 'guest';
        
        $logData = array_merge([
            'event_type' => $eventType,
            'user_id' => $userId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now(),
        ], $details);

        Log::channel('security')->info("Security Event: {$eventType}", $logData);
    }

    /**
     * Check if user has permission to access resource
     *
     * @param mixed $resource The resource to check access for
     * @param string $resourceType The type of resource
     * @return bool Whether the user is authorized
     */
    protected function authorizeAccess($resource, string $resourceType = 'participant')
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable|null $user */
        $user = auth()->user();

        // If no user (guest/visitor), allow read-only access for participants
        if (!$user) {
            // For visitors, allow viewing participants but not modifying
            if ($resourceType === 'participant') {
                return true; // Allow viewing
            }
            return false; // Deny other operations
        }

        // Admin can access everything
        if ($user instanceof \App\Models\User && $user->isAdmin()) {
            return true;
        }

        // Check if user's region matches resource region
        $userRegion = $user->region_id ?? null;
        $resourceRegion = null;

        switch ($resourceType) {
            case 'participant':
                $resourceRegion = $resource->region_id ?? null;
                break;
            case 'payment':
                $resourceRegion = $resource->participant->region_id ?? null;
                break;
        }

        $authorized = ($userRegion === $resourceRegion);

        if (!$authorized) {
            $this->logSecurityEvent('unauthorized_resource_access', [
                'resource_type' => $resourceType,
                'resource_id' => $resource->id ?? 'unknown',
                'user_region' => $userRegion,
                'resource_region' => $resourceRegion
            ]);
        }

        return $authorized;
    }
}