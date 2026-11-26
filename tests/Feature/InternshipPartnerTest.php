<?php

namespace Tests\Feature;

use App\Models\InternshipPartner;
use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class InternshipPartnerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    private function prodi(string $name): StudyProgram
    {
        return StudyProgram::create([
            'name' => $name,
            'department' => 'Teknik Elektro, Informatika, dan Bisnis',
            'degree' => 'S1',
            'slug' => str($name)->slug(),
        ]);
    }

    private function partner(array $attrs = []): InternshipPartner
    {
        return InternshipPartner::create(array_merge([
            'name' => 'PT Contoh',
            'business_field' => 'Teknologi Informasi',
            'location' => 'Balikpapan',
            'type' => 'kp_magang',
            'study_program_ids' => [],
            'is_active' => true,
        ], $attrs));
    }

    public function test_public_page_lists_only_active_partners(): void
    {
        $this->partner(['name' => 'PT Tampil']);
        $this->partner(['name' => 'PT Tersembunyi', 'is_active' => false]);

        $this->get('/mitra-kp-magang')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Public/InternshipPartners/Index')
                ->has('partners.data', 1)
                ->where('partners.data.0.name', 'PT Tampil')
                ->where('stats.total', 1));
    }

    public function test_public_page_filters_by_type_prodi_and_field(): void
    {
        $si = $this->prodi('Sistem Informasi');
        $mat = $this->prodi('Matematika');

        $this->partner(['name' => 'PT KP Saja', 'type' => 'kp', 'study_program_ids' => [$si->id]]);
        $this->partner(['name' => 'PT Magang Saja', 'type' => 'magang', 'study_program_ids' => [$mat->id]]);
        $this->partner(['name' => 'PT Keduanya', 'type' => 'kp_magang', 'business_field' => 'Perbankan', 'study_program_ids' => [$si->id, $mat->id]]);

        $names = fn (string $query) => collect(
            $this->get('/mitra-kp-magang?' . $query)->viewData('page')['props']['partners']['data']
        )->pluck('name')->sort()->values()->all();

        // "KP & Magang" ikut muncul di filter KP maupun Magang
        $this->assertSame(['PT KP Saja', 'PT Keduanya'], $names('type=kp'));
        $this->assertSame(['PT Keduanya', 'PT Magang Saja'], $names('type=magang'));
        $this->assertSame(['PT KP Saja', 'PT Keduanya'], $names('prodi=' . $si->id));
        $this->assertSame(['PT Keduanya'], $names('bidang=Perbankan'));
        $this->assertSame(['PT Magang Saja'], $names('search=Magang Saja'));
    }

    public function test_guest_cannot_access_admin_pages(): void
    {
        $this->get('/admin/mitra-kp-magang')->assertRedirect('/login');
        $this->post('/admin/mitra-kp-magang', ['name' => 'X'])->assertRedirect('/login');
    }

    public function test_admin_can_create_update_and_delete_partner(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();
        $si = $this->prodi('Sistem Informasi');

        $this->actingAs($admin)->post('/admin/mitra-kp-magang', [
            'name' => 'PT Pertamina',
            'business_field' => 'Minyak & Gas',
            'location' => 'Balikpapan, Kalimantan Timur',
            'type' => 'kp',
            'study_program_ids' => [(string) $si->id],
            'website' => 'https://pertamina.com',
            'is_active' => '1',
            'logo' => UploadedFile::fake()->image('logo.png'),
        ])->assertRedirect(route('admin.internship-partners.index'));

        $partner = InternshipPartner::firstOrFail();
        $this->assertSame([$si->id], $partner->study_program_ids);
        Storage::disk('public')->assertExists($partner->logo);
        $oldLogo = $partner->logo;

        // Update: hapus logo, sembunyikan, kosongkan prodi
        $this->actingAs($admin)->put("/admin/mitra-kp-magang/{$partner->id}", [
            'name' => 'PT Pertamina Hulu',
            'business_field' => 'Minyak & Gas',
            'location' => 'Balikpapan',
            'type' => 'kp_magang',
            'is_active' => '0',
            'remove_logo' => '1',
        ])->assertRedirect(route('admin.internship-partners.index'));

        $partner->refresh();
        $this->assertSame('PT Pertamina Hulu', $partner->name);
        $this->assertFalse($partner->is_active);
        $this->assertSame([], $partner->study_program_ids);
        $this->assertNull($partner->logo);
        Storage::disk('public')->assertMissing($oldLogo);

        $this->actingAs($admin)->delete("/admin/mitra-kp-magang/{$partner->id}")
            ->assertRedirect(route('admin.internship-partners.index'));
        $this->assertDatabaseCount('internship_partners', 0);
    }

    public function test_store_validates_required_fields_and_type(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post('/admin/mitra-kp-magang', [
            'type' => 'lowongan',
            'website' => 'bukan-url',
            'study_program_ids' => [999],
        ])->assertSessionHasErrors(['name', 'business_field', 'location', 'type', 'website', 'study_program_ids.0']);

        $this->assertDatabaseCount('internship_partners', 0);
    }
}
