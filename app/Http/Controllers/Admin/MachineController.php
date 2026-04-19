<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index()
    {
        return view('admin.machines.index', ['machines' => Machine::all()]);
    }

    public function create()
    {
        return view('admin.machines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'category' => 'required',
            'slug' => 'required|unique:machines',
            'description' => 'nullable',
            'image' => 'nullable|image',
            'page' => 'nullable',
            'order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('machines', 'public');
        }

        Machine::create($validated);
        return redirect()->route('machines.index')->with('success', 'Machine created');
    }

    public function edit(Machine $machine)
    {
        return view('admin.machines.edit', ['machine' => $machine]);
    }

    public function update(Request $request, Machine $machine)
    {
        $validated = $request->validate([
            'name' => 'required',
            'category' => 'required',
            'slug' => 'required|unique:machines,slug,' . $machine->id,
            'description' => 'nullable',
            'image' => 'nullable|image',
            'page' => 'nullable',
            'order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('machines', 'public');
        }

        $machine->update($validated);
        return redirect()->route('machines.index')->with('success', 'Machine updated');
    }

    public function destroy(Machine $machine)
    {
        $machine->delete();
        return redirect()->route('machines.index')->with('success', 'Machine deleted');
    }
}
