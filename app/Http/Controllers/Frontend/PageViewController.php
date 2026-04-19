<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Card;
use App\Models\Machine;
use App\Models\ContactDetail;
use App\Models\SocialLink;

class PageViewController extends Controller
{
    public function home()
    {
        return view('frontend.home', [
            'page' => Page::where('slug', 'home')->first(),
            'cards' => Card::where('page', 'home')->orderBy('order')->get(),
            'machines' => Machine::where('page', 'equipments')->orderBy('order')->get(),
            'contacts' => ContactDetail::orderBy('order')->get(),
            'socials' => SocialLink::orderBy('order')->get(),
        ]);
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('frontend.page', [
            'page' => $page,
            'cards' => Card::where('page', $slug)->orderBy('order')->get(),
            'machines' => Machine::where('page', $slug)->orderBy('order')->get(),
            'contacts' => ContactDetail::orderBy('order')->get(),
            'socials' => SocialLink::orderBy('order')->get(),
        ]);
    }
}
