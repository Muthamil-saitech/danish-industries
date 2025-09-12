<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerIoController extends Controller
{
    public function index() {
        $title = __('index.customer_io');
        return view('pages.customer_io.index', compact('title'));
    }
    public function create() {
        $title = __('index.add_customer');
        return view('pages.customer_io.addEditCustomerIO', compact('title'));
    }
    public function store(){
        
    }
    public function show() {
        $title = __('index.view_customer');
        return view('pages.customer_io.view', compact('title'));
    }
}
