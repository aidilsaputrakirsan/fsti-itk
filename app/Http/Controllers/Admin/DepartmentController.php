<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('studyPrograms')->orderBy('name')->get();
        return Inertia::render('Admin/Departments/Index', [
            'departments' => $departments
        ]);
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nama jurusan wajib diisi.',
            'name.string' => 'Nama jurusan harus berupa teks.',
            'name.max' => 'Nama jurusan tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Jurusan dengan nama ini sudah terdaftar.',
        ];

        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
        ], $messages);

        Department::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->back()->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function update(Request $request, Department $department)
    {
        $messages = [
            'name.required' => 'Nama jurusan wajib diisi.',
            'name.string' => 'Nama jurusan harus berupa teks.',
            'name.max' => 'Nama jurusan tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Jurusan dengan nama ini sudah terdaftar.',
        ];

        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
        ], $messages);

        $department->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->back()->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Department $department)
    {
        if ($department->studyPrograms()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus jurusan karena masih memiliki program studi yang terikat.');
        }

        $department->delete();
        return redirect()->back()->with('success', 'Jurusan berhasil dihapus.');
    }
}