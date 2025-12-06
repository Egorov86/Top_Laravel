<?php
// app/Models/User.php

namespace App\Models;

// Все необходимые импорты
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

/**
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $avatar
 * @property int $role_id
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role_id',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Убедимся что Post модель доступна
    public function posts()
    {
        return $this->hasMany(\App\Models\Post::class);
    }

    public function getAvatarUrl()
    {
        if ($this->avatar) {
            $filePath = 'public/avatars/' . $this->avatar;

            if (Storage::exists($filePath)) {
                // Используем прямой роут вместо симлинка
                return route('avatar.direct', ['filename' => $this->avatar]);
            }
        }

        return asset('images/default-avatar.png');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin(): bool
    {
        return $this->role->name === 'admin';
    }
}
