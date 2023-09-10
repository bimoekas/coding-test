<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Repositories\StudentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function __construct(private StudentRepository $repo)
    {
    }

    public function index()
    {
        $student = $this->repo->all();

        return new StudentResource(status: true, message: 'List data siswa', resource: $student);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'numeric', 'not_in:0', 'unique:students,student_id'],
            'name' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'address' => ['nullable', 'string'],
            'entry_year' => ['required', 'numeric'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,gif'],
        ]);

        $student = $this->repo->create($validated);

        return new StudentResource(status: true, message: 'Data siswa berhasil ditambahkan', resource: $student);
    }

    public function show(Student $student)
    {
        $student->load('subject');

        return new StudentResource(status: true, message: 'Detail data siswa', resource: $student);
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'numeric', 'not_in:0', Rule::unique('students', 'student_id')->ignore($student->id)],
            'name' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'address' => ['nullable', 'string'],
            'entry_year' => ['required', 'numeric'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,gif'],
        ]);


        $student = $this->repo->update($student, $validated);

        return new StudentResource(status: true, message: 'Data siswa berhasil diupdate', resource: $student);
    }

    public function destroy(Student $student)
    {
        Storage::delete('storage/uploads' . $student->photo);

        $student->subject()->delete();

        $student->delete();

        return new StudentResource(status: true, message: 'Data siswa berhasil dihapus', resource: $student);
    }
}
