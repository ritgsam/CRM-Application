<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Meetings;


class DashboardController extends Controller
{

public function index()
{
    $totalLeads = Lead::count();
    $totalDeals = Deal::count();
    $wonRevenue = Deal::where('status', 'won')->sum('amount');
    $dealsByStatus = Deal::select('status', DB::raw('count(*) as total'))
                         ->groupBy('status')
                         ->pluck('total', 'status');

    $recentDeals = Deal::latest()->take(5)->get();

    $meetings = Meetings::orderBy('scheduled_at', 'asc')->take(5)->get();

    return view('dashboard', compact(
        'totalLeads',
        'totalDeals',
        'wonRevenue',
        'dealsByStatus',
        'recentDeals',
        'meetings'
    ));
}
}
