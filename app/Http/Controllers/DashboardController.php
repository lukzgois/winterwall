<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        return 'ok';
    }
}
