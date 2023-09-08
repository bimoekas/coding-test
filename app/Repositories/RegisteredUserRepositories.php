<?php

namespace App\Repositories;

use App\Models\User;
use App\Services\FileUploader;
use Illuminate\Support\Facades\Hash;

class RegisteredUserRepositories
{
    public function __construct(private FileUploader $fileUploader)
    {
    }

    public function create(array $payload): User
    {
        return User::create(array_merge($payload, [
            'photo' => $this->fileUploader->upload($payload['photo']),
            'password' => Hash::make($payload['password'])
        ]));
    }
}
