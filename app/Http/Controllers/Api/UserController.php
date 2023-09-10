<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\RegisteredUserRepository;
use App\Services\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function __construct(private RegisteredUserRepository $repo)
    {
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', Rule::unique('users')->ignore(auth()->user()->id)],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,gif'],
            'password' => ['nullable', 'string', 'min:8', Rules\Password::defaults()],
            'newPassword' => ['nullable', 'string', 'min:8']
        ]);

        $user = $this->repo->update($user, $validated);

        return new UserResource(status: true, message: 'Data berhasil diupdate', resource: $user);
    }
}
