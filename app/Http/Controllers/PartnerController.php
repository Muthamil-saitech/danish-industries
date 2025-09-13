<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
     public function index() {
        $title = __('index.partners');
        return view('pages.partners.index', compact('title'));
    }
    public function create() {
        $title = __('index.add_partner');
        return view('pages.partners.addEditPartner', compact('title'));
    }
    public function show() {
        $title = __('index.view_partner');
        return view('pages.partners.view', compact('title'));
    }
}
