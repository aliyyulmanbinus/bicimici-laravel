<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Panel;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;


    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'occupation',
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

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function getActiveSubscription()
    {
        return $this->transactions()
            ->where('is_paid', true)
            ->where('ended_at', '>=', now())
            ->first(); // return the active subscription if exists
    }

    public function hasActiveSubscription()
    {
        return $this->transactions()
            ->where('is_paid', true)
            ->where('ended_at', '>=', now()) // ensure the subs is still active
            ->exists();
    }
}
