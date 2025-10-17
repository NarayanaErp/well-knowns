<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class SystemLogController extends Controller
{
    // Only authenticated users can access
    public function __construct()
    {
        $this->middleware('auth'); // <-- just use this, no parent::__construct()
    }

    // List all logs
    public function index()
    {
        $logs = Log::with('user')->latest()->paginate(20);
        return view('logs.index', compact('logs'));
    }
}   
