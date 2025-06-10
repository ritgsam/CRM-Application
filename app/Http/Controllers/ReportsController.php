<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Deal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $salesByMonth = Deal::where('status', 'Won')
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"), DB::raw('SUM(amount) as total'))
            ->groupBy('month')
            ->orderByRaw("MIN(created_at)")
            ->pluck('total', 'month');

        $leadCount = Lead::count();
        $dealCount = Deal::count();

        $topUsers = User::withCount(['deals as won_deals_count' => function ($query) {
            $query->where('status', 'Won');
        }])
        ->orderByDesc('won_deals_count')
        ->take(5)
        ->get();

        return view('reports.index', compact('salesByMonth', 'leadCount', 'dealCount', 'topUsers'));
    }
}
