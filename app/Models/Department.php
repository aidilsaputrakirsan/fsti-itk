<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function studyPrograms()
    {
        return $this->hasMany(StudyProgram::class, 'department', 'name');
    }

    protected static function booted()
    {
        static::updated(function ($department) {
            if ($department->wasChanged('name')) {
                $oldName = $department->getOriginal('name');
                $newName = $department->name;

                \App\Models\StudyProgram::where('department', $oldName)
                    ->update(['department' => $newName]);

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
            }
        });
    }
}
