<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deck;
use App\Models\StudySession;

class DeckController extends Controller
{

    public function index()
    {
        $decks = Deck::where('user_id', session('user_id'))
                     ->withCount('cards')
                     ->orderByDesc('created_at')
                     ->paginate(9);

        return view('decks.index', compact('decks'));
    }


    public function create()
    {
        return view('decks.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'color'       => 'nullable|in:blue,green,purple,orange,red,teal',
        ], [
            'title.required' => 'Deck title is required.',
            'title.max'      => 'Title cannot exceed 100 characters.',
        ]);

        Deck::create([
            'user_id'     => session('user_id'),
            'title'       => trim($request->title),
            'description' => trim($request->description ?? ''),
            'color'       => $request->color ?? 'blue',
        ]);

        return redirect()->route('decks.index')->with('success', 'Deck created successfully!');
    }


    public function show(Deck $deck)
    {
        $this->authorizeOwner($deck);

        $cards = $deck->cards()->orderBy('created_at')->get();

        return view('decks.show', compact('deck', 'cards'));
    }


    public function edit(Deck $deck)
    {
        $this->authorizeOwner($deck);

        return view('decks.edit', compact('deck'));
    }


    public function update(Request $request, Deck $deck)
    {
        $this->authorizeOwner($deck);

        $request->validate([
            'title'       => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'color'       => 'nullable|in:blue,green,purple,orange,red,teal',
        ]);

        $deck->update([
            'title'       => trim($request->title),
            'description' => trim($request->description ?? ''),
            'color'       => $request->color ?? 'blue',
        ]);

        return redirect()->route('decks.show', $deck)->with('success', 'Deck updated successfully!');
    }


    public function destroy(Deck $deck)
    {
        $isOwner = $deck->user_id == session('user_id');
        $isAdmin = session('user_role') === 'admin';

        if (!$isOwner && !$isAdmin) {
            abort(403, 'You do not have permission to delete this deck.');
        }

        $deck->cards()->delete();
        $deck->delete();

        return redirect()->route('decks.index')->with('success', 'Deck deleted.');
    }


    public function study(Deck $deck)
    {
        $this->authorizeOwner($deck);

        $cards = $deck->cards()->get()->shuffle();

        if ($cards->isEmpty()) {
            return redirect()->route('decks.show', $deck)
                             ->with('error', 'Add some cards before studying!');
        }

        StudySession::create([
            'user_id'       => session('user_id'),
            'deck_id'       => $deck->id,
            'cards_reviewed'=> $cards->count(),
            'score'         => 0,
        ]);

        return view('decks.study', compact('deck', 'cards'));
    }

    private function authorizeOwner(Deck $deck): void
    {
        if ($deck->user_id != session('user_id')) {
            abort(403, 'You do not have access to this deck.');
        }
    }
}
