<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubmissionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'subject' => 'nullable',
            'message' => 'required',
        ]);

        $submission = Submission::create($validated);

        try {
            Mail::send('emails.submission-confirmation', ['submission' => $submission], function($m) use ($validated) {
                $m->to($validated['email'])->subject('We received your message');
            });
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Thank you! We will get back to you soon.');
    }
}
