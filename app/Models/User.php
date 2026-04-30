<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = ['password'];

    public function decks()
    {
        return $this->hasMany(Deck::class);
    }

    public static function findByEmail(string $email): ?self
    {
        return self::where('email', $email)->first();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
