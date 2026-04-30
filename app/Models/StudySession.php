<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudySession extends Model
{
    protected $table = 'study_sessions';

    protected $fillable = [
        'user_id', 'deck_id', 'cards_reviewed', 'score',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }
}
