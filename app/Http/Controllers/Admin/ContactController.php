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
            'address' => 'nullable|string',
            'operating_hours' => 'nullable|string',
            'google_maps_iframe' => 'nullable|string',
            'academic_wa_number' => 'nullable|string|max:50',
            'academic_wa_link' => 'nullable|string',
            'finance_wa_number' => 'nullable|string|max:50',
            'finance_wa_link' => 'nullable|string',
            'email' => 'nullable|string',
            'instagram_username' => 'nullable|string|max:100',
            'instagram_link' => 'nullable|string',
            'tiktok_username' => 'nullable|string|max:100',
            'tiktok_link' => 'nullable|string',
        ]);

        Contact::updateOrCreate(
            ['id' => 1],
            $validated
        );

        $pesan = 'Informasi kontak berhasil diperbarui.';
        if ($request->active_tab === 'lokasi') {
            $pesan = 'Lokasi & Jam Operasional berhasil diperbarui!';
        } elseif ($request->active_tab === 'komunikasi') {
            $pesan = 'Layanan Komunikasi berhasil diperbarui!';
        } elseif ($request->active_tab === 'sosmed') {
            $pesan = 'Tautan Media Sosial berhasil diperbarui!';
        }

        return redirect()->back()->with('success', $pesan);
    }
}
