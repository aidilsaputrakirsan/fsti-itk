<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department',
        'degree',
        'slug',
        'description',
        'vision',
        'mission',
        'goals',
        'graduate_profiles',
        'accreditation_certificate_image',
        'accreditation_pdf_link',
        'accreditation_text',
        'website_link'
    ];

    protected $casts = [
        'mission' => 'array',
        'graduate_profiles' => 'array',
    ];

    public function getAccreditationCertificateImageAttribute($value): ?string
    {
        if (!$value) {
            return null;
        }

        if (str_starts_with($value, '/storage/')) {
            return $value;
        }

        return '/storage/' . $value;
    }

    protected static function booted()
    {
        static::updated(function ($studyProgram) {
            if ($studyProgram->wasChanged('name')) {
                $oldName = $studyProgram->getOriginal('name');
                $newName = $studyProgram->name;

                \App\Models\Achievement::where('study_program', $oldName)
                    ->update(['study_program' => $newName]);

                \App\Models\Staff::where('type', 'Dosen')
                    ->where(function ($query) use ($oldName) {
                        $query->where('structural_position', 'LIKE', '%' . $oldName . '%')
                            ->orWhere('functional_position', 'LIKE', '%' . $oldName . '%');
                    })
                    ->get()
                    ->each(function ($staff) use ($oldName, $newName) {
                        $updateData = [];

                        if (!empty($staff->structural_position) && stripos($staff->structural_position, $oldName) !== false) {
                            $updateData['structural_position'] = str_ireplace($oldName, $newName, $staff->structural_position);
                        }

                        if (!empty($staff->functional_position) && stripos($staff->functional_position, $oldName) !== false) {
                            $updateData['functional_position'] = str_ireplace($oldName, $newName, $staff->functional_position);
                        }

                        if (!empty($updateData)) {
                            $staff->update($updateData);
                        }
                    });

                \App\Models\Alumni::where('study_program', $oldName)
                    ->update(['study_program' => $newName]);
            }
        });
    }
}
