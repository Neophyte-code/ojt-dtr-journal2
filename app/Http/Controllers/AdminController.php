<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    // Example method to show the dashboard or home page
    public function index()
    {
        return redirect('/admin');
    }
}
