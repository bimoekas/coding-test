<?php

namespace App\Repositories;

use App\Models\Student;
use App\Services\FileUploader;

class StudentRepository
{
    public function __construct(private FileUploader $fileUploader)
    {
    }

    public function all()
    {
        return Student::all();
    }

    public function create(array $payload)
    {
        $photoUrl = isset($payload['photo'])
            ? $this->fileUploader->upload($payload['photo'])
            : config('constants.placeholder_image');

        return Student::create(array_merge($payload, [
            'photo' => $photoUrl
        ]));
    }

    public function update(Student $student, array $payload): Student
    {
        if (isset($payload['photo']) && !is_null($payload['photo'])) {
            $student->update(array_merge($payload, [
                'photo' => $this->fileUploader->upload($payload['photo'])
            ]));
        } else {
            $student->update($payload);
        }

        return $student;
    }
}
