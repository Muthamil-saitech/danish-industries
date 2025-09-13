<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PartnerIOController extends Controller
{
    public function index() {
        $title = __('index.partner_io');
        return view('pages.partner_io.index', compact('title'));
    }
    public function create() {
        $title = __('index.add_partner');
        return view('pages.partner_io.addEditPartner', compact('title'));
    }
    public function show() {
        $title = __('index.view_partner_io');
        return view('pages.partner_io.view', compact('title'));
    }
}
