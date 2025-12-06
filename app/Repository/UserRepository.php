<?php

namespace App\Repository;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserRepository
{
    public function all()
    {
        return User::all();
    }
    public function find(int $id)
    {
        return User::findOrFail($id);
    }
    public function deleteAvatar(int $userId)
    {
        $user = $this->find($userId);
        if ($user->avatar) {
            Storage::delete('public/avatars/' . $user->avatar);
            $user->update(['avatar' => null]);
        }
    }
    public function store(
        string $username,
        string $email,
        string $password
    ): User
    {
        $user = User::query()->create([
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
            'status' => 'user',
            'role_id' => Role::query()
                ->whereRaw('LOWER(name) = ?', [strtolower('uSeR')])
                ->first()?->id
        ]);

        Auth::login($user);
        return $user;
    }

    public function update(array $data, int $userId)
    {
        $user = $this->find($userId);
        $user->update($data);
    }

    public function delete($request)
    {

    }


}
