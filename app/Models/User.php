<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements AuthenticatableContract
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $incrementing = false; // Karena ID berupa string (U0001)
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_user',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
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

    // --- Helper Role ---
    public function isAdmin()
    {
        // Logika: Admin adalah U0001 atau email tertentu
        return $this->id_user === 'U0001' || $this->email === 'admin@gdss.com';
    }

    public function isKadep(){
        return $this->id_user === 'U0002' || $this->email === 'kadep@gdss.com';
    }

    // --- Relasi ---
    public function penilaians()
    {
        return $this->hasMany(penilaian::class, 'id_user', 'id_user');
    }

    public function preferensiWp()
    {
        return $this->hasMany(preferensi::class, 'id_user', 'id_user');
    }

    public function getAuthPassword()
{
    return $this->password;
}
}
