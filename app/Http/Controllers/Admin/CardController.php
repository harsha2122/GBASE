<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        return view('admin.cards.index', ['cards' => Card::all()]);
    }

    public function create()
    {
        return view('admin.cards.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'icon' => 'nullable',
            'image' => 'nullable|image',
            'page' => 'required',
            'order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cards', 'public');
        }

        Card::create($validated);
        return redirect()->route('cards.index')->with('success', 'Card created');
    }

    public function edit(Card $card)
    {
        return view('admin.cards.edit', ['card' => $card]);
    }

    public function update(Request $request, Card $card)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'icon' => 'nullable',
            'image' => 'nullable|image',
            'page' => 'required',
            'order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cards', 'public');
        }

        $card->update($validated);
        return redirect()->route('cards.index')->with('success', 'Card updated');
    }

    public function destroy(Card $card)
    {
        $card->delete();
        return redirect()->route('cards.index')->with('success', 'Card deleted');
    }
}
