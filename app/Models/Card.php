<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';

    protected $fillable = [
        'deck_id', 'front', 'back', 'hint',
    ];

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }
}
