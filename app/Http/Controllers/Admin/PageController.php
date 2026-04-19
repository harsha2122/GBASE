<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('admin.pages.index', ['pages' => Page::all()]);
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|unique:pages',
            'title' => 'required',
            'meta_description' => 'nullable',
            'content' => 'nullable',
            'hero_image' => 'nullable|image',
            'breadcrumb' => 'nullable',
        ]);

        if ($request->hasFile('hero_image')) {
            $validated['hero_image'] = $request->file('hero_image')->store('pages', 'public');
        }

        Page::create($validated);
        return redirect()->route('pages.index')->with('success', 'Page created successfully');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', ['page' => $page]);
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'slug' => 'required|unique:pages,slug,' . $page->id,
            'title' => 'required',
            'meta_description' => 'nullable',
            'content' => 'nullable',
            'hero_image' => 'nullable|image',
            'breadcrumb' => 'nullable',
        ]);

        if ($request->hasFile('hero_image')) {
            $validated['hero_image'] = $request->file('hero_image')->store('pages', 'public');
        }

        $page->update($validated);
        return redirect()->route('pages.index')->with('success', 'Page updated successfully');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index')->with('success', 'Page deleted successfully');
    }
}
