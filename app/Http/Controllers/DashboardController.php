<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Inertia\Inertia;
use Inertia\Responses;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Dashboard', [
            'clients' => Client::latest()->limit(10)->get(),
            'filters' => $request->only(['search']),
        ]);
    }
}
