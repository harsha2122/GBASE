<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactDetail;
use Illuminate\Http\Request;

class ContactDetailController extends Controller
{
    public function index()
    {
        return view('admin.contact-details.index', ['contacts' => ContactDetail::orderBy('order')->get()]);
    }

    public function create()
    {
        return view('admin.contact-details.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
            'value' => 'required',
            'icon' => 'nullable',
            'order' => 'integer',
        ]);

        ContactDetail::create($validated);
        return redirect()->route('contact-details.index')->with('success', 'Contact detail added');
    }

    public function edit(ContactDetail $contactDetail)
    {
        return view('admin.contact-details.edit', ['contact' => $contactDetail]);
    }

    public function update(Request $request, ContactDetail $contactDetail)
    {
        $validated = $request->validate([
            'type' => 'required',
            'value' => 'required',
            'icon' => 'nullable',
            'order' => 'integer',
        ]);

        $contactDetail->update($validated);
        return redirect()->route('contact-details.index')->with('success', 'Contact detail updated');
    }

    public function destroy(ContactDetail $contactDetail)
    {
        $contactDetail->delete();
        return redirect()->route('contact-details.index')->with('success', 'Contact detail deleted');
    }
}
