<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Deck;

class CardController extends Controller
{
    public function create(Deck $deck)
    {
        $this->authorizeOwner($deck);

        return view('cards.create', compact('deck'));
    }

    public function store(Request $request, Deck $deck)
    {
        $this->authorizeOwner($deck);

        $request->validate([
            'front' => 'required|string|max:500',
            'back'  => 'required|string|max:500',
            'hint'  => 'nullable|string|max:200',
        ], [
            'front.required' => 'The front side (question) is required.',
            'back.required'  => 'The back side (answer) is required.',
            'front.max'      => 'Front text cannot exceed 500 characters.',
            'back.max'       => 'Back text cannot exceed 500 characters.',
        ]);

        Card::create([
            'deck_id' => $deck->id,
            'front'   => trim($request->front),
            'back'    => trim($request->back),
            'hint'    => trim($request->hint ?? ''),
        ]);

        if ($request->has('add_another')) {
            return back()->with('success', 'Card added! Add another one.');
        }

        return redirect()->route('decks.show', $deck)->with('success', 'Card added successfully!');
    }

    public function edit(Deck $deck, Card $card)
    {
        $this->authorizeOwner($deck);
        $this->authorizeCard($deck, $card);

        return view('cards.edit', compact('deck', 'card'));
    }
    public function update(Request $request, Deck $deck, Card $card)
    {
        $this->authorizeOwner($deck);
        $this->authorizeCard($deck, $card);

        $request->validate([
            'front' => 'required|string|max:500',
            'back'  => 'required|string|max:500',
            'hint'  => 'nullable|string|max:200',
        ]);

        $card->update([
            'front' => trim($request->front),
            'back'  => trim($request->back),
            'hint'  => trim($request->hint ?? ''),
        ]);

        return redirect()->route('decks.show', $deck)->with('success', 'Card updated successfully!');
    }


    public function destroy(Deck $deck, Card $card)
    {
        $this->authorizeOwner($deck);
        $this->authorizeCard($deck, $card);

        $card->delete();

        return redirect()->route('decks.show', $deck)->with('success', 'Card deleted.');
    }


    private function authorizeOwner(Deck $deck): void
    {
        if ($deck->user_id != session('user_id')) {
            abort(403);
        }
    }

    private function authorizeCard(Deck $deck, Card $card): void
    {
        if ($card->deck_id !== $deck->id) {
            abort(404, 'Card not found in this deck.');
        }
    }
}
