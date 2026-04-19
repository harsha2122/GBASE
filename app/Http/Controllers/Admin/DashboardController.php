<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Machine;
use App\Models\Card;
use App\Models\Submission;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'pages_count' => Page::count(),
            'machines_count' => Machine::count(),
            'cards_count' => Card::count(),
            'submissions_count' => Submission::count(),
            'new_submissions' => Submission::where('status', 'new')->count(),
            'recent_submissions' => Submission::latest()->limit(5)->get(),
        ]);
    }
}
