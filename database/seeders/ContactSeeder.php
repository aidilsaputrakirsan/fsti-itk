<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::updateOrCreate(
            ['id' => 1],
            [
                'address' => "Kampus ITK Gedung B, Lantai 1, Ruang B110\nJl. Soekarno Hatta KM 15, Karang Joang,\nBalikpapan Utara, Kalimantan Timur, 76127",
                'operating_hours' => "Senin - Kamis: 07.30 - 16.00 WITA\nJumat: 07.30 - 16.30 WITA",
                'google_maps_iframe' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.3100492018316!2d116.85893591475355!3d-1.1416668358823616!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df149b1a03bd6b3%3A0xc48c081e05d0d829!2sInstitut%20Teknologi%20Kalimantan!5e0!3m2!1sid!2sid!4v1689000000000!5m2!1sid!2sid',

                // Layanan Akademik
                'academic_wa_number' => '0851-7230-2157',
                'academic_wa_link' => 'https://wa.me/6285172302157',

                // Layanan Keuangan
                'finance_wa_number' => '0851-7231-2157',
                'finance_wa_link' => 'https://wa.me/6285172312157',

                // Email & Sosmed
                'email' => 'fsti@itk.ac.id',
                'instagram_username' => '@fsti.itk',
                'instagram_link' => 'https://www.instagram.com/fsti.itk',
                'tiktok_username' => '@fsti.itk',
                'tiktok_link' => 'https://www.tiktok.com/@fsti.itk',
            ]
        );
    }
}
