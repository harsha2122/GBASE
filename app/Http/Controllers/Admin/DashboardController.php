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
            'total_pages' => Page::count(),
            'total_machines' => Machine::count(),
            'total_cards' => Card::count(),
            'total_submissions' => Submission::where('status', 'new')->count(),
            'recent_submissions' => Submission::latest()->limit(5)->get(),
        ]);
    }
}
