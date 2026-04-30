<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    protected $table = 'decks';

    protected $fillable = [
        'user_id', 'title', 'description', 'color',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function cardCount(): int
    {
        return $this->cards()->count();
    }
}
