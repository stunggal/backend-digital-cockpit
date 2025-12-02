<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Application User model used for authentication and API access.
 *
 * Notes:
 * - Uses Sanctum (`HasApiTokens`) to issue personal access tokens.
 * - The model keeps a small `$fillable` list to avoid accidental mass
 *   assignment of sensitive fields. Extend if you add new user attributes.
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable via `create()` or `fill()`.
     * Keep this list minimal for security (avoid exposing role/privilege fields
     * unless explicitly intended).
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Attributes hidden when the model is converted to arrays or JSON.
     * This prevents sensitive values from being accidentally leaked.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Return model attribute casts.
     *
     * Laravel commonly defines a protected `$casts` property. This project
     * uses a `casts()` method variant — keep it here for compatibility.
     *
     * - `email_verified_at` is cast to a DateTime instance.
     * - `password` uses Laravel's `hashed` cast to automatically hash on set.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Convenience helper that returns true when the user has an admin role.
     *
     * This checks a `role` attribute if present; it will safely return false
     * when `role` is not defined on the model instead of throwing an error.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return isset($this->role) && $this->role === 'admin';
    }

    /**
     * Human-friendly display name for the user. Falls back to email or a
     * generic label when `name` is not available.
     *
     * @return string
     */
    public function displayName(): string
    {
        if (!empty($this->name)) {
            return $this->name;
        }

        if (!empty($this->email)) {
            return $this->email;
        }

        return 'User';
    }
}
