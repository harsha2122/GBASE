<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\SubmissionReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Submission::query();

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $submissions = $query->latest()->paginate(15);
        return view('admin.submissions.index', ['submissions' => $submissions]);
    }

    public function show(Submission $submission)
    {
        return view('admin.submissions.show', ['submission' => $submission]);
    }

    public function destroy(Submission $submission)
    {
        $submission->delete();
        return redirect()->route('submissions.index')->with('success', 'Submission deleted');
    }

    public function reply(Request $request, Submission $submission)
    {
        $validated = $request->validate(['message' => 'required']);

        $reply = SubmissionReply::create([
            'submission_id' => $submission->id,
            'message' => $validated['message'],
            'sent_email' => false
        ]);

        $sendEmail = $request->has('send_email');

        if ($sendEmail) {
            try {
                Mail::send('emails.submission-reply', ['submission' => $submission, 'reply' => $reply], function($m) use ($submission) {
                    $m->to($submission->email)->subject('Re: ' . ($submission->subject ?? 'Your Inquiry'));
                });
                $reply->update(['sent_email' => true]);
            } catch (\Exception $e) {
                return back()->with('error', 'Reply saved but email failed: ' . $e->getMessage());
            }
        }

        $submission->update(['status' => 'replied']);
        return redirect()->route('submissions.show', $submission)->with('success', 'Reply saved' . ($sendEmail ? ' and email sent' : ''));
    }
}
