<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        // Only admins can access settings
        if (!$this->hasPermission('manage_settings')) {
            abort(403);
        }

        $greetingText = Setting::where('key', 'greeting_text')->first();
        $titleText = Setting::where('key', 'title_text')->first();
        $subtitleText = Setting::where('key', 'subtitle_text')->first();
        $whatsappNumber = Setting::where('key', 'whatsapp_number')->first();

        $waHeader = Setting::where('key', 'wa_header')->first();
        $waSchedule = Setting::where('key', 'wa_schedule')->first();
        $waDeparture = Setting::where('key', 'wa_departure')->first();
        $waFees = Setting::where('key', 'wa_fees')->first();
        $waHimbauan = Setting::where('key', 'wa_himbauan')->first();
        $waBankInfo = Setting::where('key', 'wa_bank_info')->first();
        $waContacts = Setting::where('key', 'wa_contacts')->first();

        return view('pengaturan', compact(
            'greetingText', 'titleText', 'subtitleText', 'whatsappNumber',
            'waHeader', 'waSchedule',
            'waDeparture', 'waFees', 'waHimbauan', 'waBankInfo', 'waContacts'
        ));
    }

    public function update(Request $request)
    {
        // Only admins can update settings
        if (!Auth::user() || Auth::user()->role !== 'induk') {
            abort(403);
        }

        if ($request->has('restore_default')) {
            Setting::whereIn('key', [
                'greeting_text', 'title_text', 'subtitle_text', 'whatsapp_number',
                'wa_header', 'wa_schedule',
                'wa_departure', 'wa_fees', 'wa_himbauan', 'wa_bank_info', 'wa_contacts'
            ])->delete();
            return redirect()->route('pengaturan')->with('success', 'Pengaturan telah dikembalikan ke default');
        }

        $request->validate([
            'greeting_text' => 'nullable|string',
            'title_text' => 'nullable|string',
            'subtitle_text' => 'nullable|string',
            'whatsapp_number' => 'nullable|string',
            'wa_header' => 'nullable|string',
            'wa_schedule' => 'nullable|string',
            'wa_departure' => 'nullable|string',
            'wa_fees' => 'nullable|string',
            'wa_himbauan' => 'nullable|string',
            'wa_bank_info' => 'nullable|string',
            'wa_contacts' => 'nullable|string',
        ]);

        // Save settings
        $settings = [
            'greeting_text' => $request->greeting_text,
            'title_text' => $request->title_text,
            'subtitle_text' => $request->subtitle_text,
            'whatsapp_number' => $request->whatsapp_number,
            'wa_header' => $request->wa_header,
            'wa_schedule' => $request->wa_schedule,
            'wa_departure' => $request->wa_departure,
            'wa_fees' => $request->wa_fees,
            'wa_himbauan' => $request->wa_himbauan,
            'wa_bank_info' => $request->wa_bank_info,
            'wa_contacts' => $request->wa_contacts,
        ];

        foreach ($settings as $key => $value) {
            if ($value !== null) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
        }

        return redirect()->route('pengaturan')->with('success', 'Pengaturan berhasil disimpan');
    }
}