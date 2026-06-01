<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Page;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $query = Card::query();

        if ($request->has('page_id') && $request->page_id) {
            $query->where('page_id', $request->page_id);
        }

        $cards = $query->paginate(12);
        $pages = Page::all();
        return view('admin.cards.index', ['cards' => $cards, 'pages' => $pages]);
    }

    public function create()
    {
        $pages = Page::all();
        return view('admin.cards.create', ['pages' => $pages]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'icon' => 'nullable',
            'image' => 'nullable|image',
            'page_id' => 'nullable|exists:pages,id',
            'page' => 'nullable',
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
        $pages = Page::all();
        return view('admin.cards.edit', ['card' => $card, 'pages' => $pages]);
    }

    public function update(Request $request, Card $card)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'icon' => 'nullable',
            'image' => 'nullable|image',
            'page_id' => 'nullable|exists:pages,id',
            'page' => 'nullable',
            'order' => 'integer',
        ]);

        if ($request->has('remove_image')) {
            $validated['image'] = null;
        } elseif ($request->hasFile('image')) {
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
