<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deck;
use App\Models\Card;
use App\Models\StudySession;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        $userId = session('user_id');

        $totalDecks    = Deck::where('user_id', $userId)->count();
        $totalCards    = Card::whereHas('deck', fn($q) => $q->where('user_id', $userId))->count();
        $totalSessions = StudySession::where('user_id', $userId)->count();

        $recentDecks = Deck::where('user_id', $userId)
                           ->withCount('cards')
                           ->orderByDesc('updated_at')
                           ->take(4)
                           ->get();

        return view('dashboard', compact(
            'totalDecks', 'totalCards', 'totalSessions', 'recentDecks'
        ));
    }
}
