<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GateDemoController extends Controller
{
    //
    public function dashboard()
    {
        if (Gate::allows("isaAdmin")) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login');
        }
    }
}
