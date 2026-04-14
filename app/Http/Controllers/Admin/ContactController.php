<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function edit()
    {
        $contact = Contact::first() ?? new Contact();

        return Inertia::render('Admin/Contacts/Edit', [
            'contact' => $contact
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string',
            'operating_hours' => 'required|string',
            'google_maps_iframe' => 'nullable|string',
            'email' => 'required|email',
            'academic_wa_number' => 'required|string|min:5|max:50',
            'academic_wa_link' => 'required|url',
            'finance_wa_number' => 'required|string|min:5|max:50',
            'finance_wa_link' => 'required|url',
            'instagram_username' => 'required|string|max:100',
            'instagram_link' => 'required|url',
            'tiktok_username' => 'required|string|max:100',
            'tiktok_link' => 'required|url',
        ]);

        Contact::updateOrCreate(
            ['id' => 1],
            $validated
        );

        $message = 'Informasi kontak berhasil diperbarui.';
        if ($request->active_tab === 'lokasi') {
            $message = 'Lokasi & Jam Operasional berhasil diperbarui!';
        } elseif ($request->active_tab === 'komunikasi') {
            $message = 'Layanan Komunikasi berhasil diperbarui!';
        } elseif ($request->active_tab === 'sosmed') {
            $message = 'Tautan Media Sosial berhasil diperbarui!';
        }

        return redirect()->back()->with('success', $message);
    }
}