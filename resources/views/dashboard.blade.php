{{-- @extends('layouts.app')

@section('content')
@php
    $hour = now()->format('H');
    if ($hour < 12) {
        $greeting = 'Good Morning';
    } elseif ($hour < 17) {
        $greeting = 'Good Afternoon';
    } else {
        $greeting = 'Good Evening';
    }
@endphp

<div class="bg-[#fbeee2] min-h-screen py-10 px-4">
    <div class="max-w-screen-xl mx-auto">
        <br>
        <div class="text-center mb-10">
            <h1 class="text-3xl font-extrabold text-gray-800">{{ $greeting }}, {{ Auth::user()->name }}!</h1>
            <p class="text-lg text-gray-600 mt-1"><b>Welcome to your CRM Dashboard</b></p>
        </div>
        <br>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-10">
            <div class="bg-white rounded-lg shadow p-4 text-center border-l-4 border-blue-600">
                <p class="text-blue-600 font-semibold text-sm">Total Leads</p>
                <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $totalLeads }}</h2>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center border-l-4 border-green-600">
                <p class="text-green-600 font-semibold text-sm">Total Deals</p>
                <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $totalDeals }}</h2>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center border-l-4 border-yellow-500">
                <p class="text-yellow-500 font-semibold text-sm">Revenue (Won Deals)</p>
                <h2 class="text-xl font-bold text-gray-900 mt-1">₹{{ number_format($wonRevenue, 2) }}</h2>
            </div>
        </div>
        <br>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl  font-semibold text-gray-800 mb-4">Deals by Status</h3>
                <ul class="space-y-6 text-gray-700 text-base">
                    @forelse($dealsByStatus as $status => $count)
                        <li class="flex justify-between">
                            <span class="capitalize">{{ $status }}</span>
                            <span class="font-bold">{{ $count }}</span>
                        </li>
                    @empty
                        <li>No deals available.</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-10">Recent Deals</h3>
                <ul class="space-y-6 text-gray-700 text-base">
                    @forelse($recentDeals as $deal)
                        <li class="flex justify-between">
                            <span class="capitalize">{{ $deal->status }}</span>
                            <span class="font-bold">₹{{ number_format($deal->amount, 2) }}</span>
                        </li>
                    @empty
                        <li>No recent deals available.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <br>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-3">Upcoming Meetings</h3>
            @if($meetings->count())
                <ul class="space-y-3 text-gray-700 text-base">
                    @foreach($meetings as $meeting)
                        <li class="flex justify-between">
                            <span>{{ $meeting->title }}</span>
                            <span>{{ \Carbon\Carbon::parse($meeting->scheduled_at)->format('d M, Y h:i A') }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-green-600 text-sm">No upcoming meetings!</p>
            @endif
        </div>

    </div>
</div>
@endsection --}}

@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRM Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card-title {
      font-size: 14px;
      font-weight: 500;
      color: #6c757d;
    }
    .card-value {
      font-size: 26px;
      font-weight: bold;
    }
  </style>
</head>
<body class="bg-light">

  <div class="container">
    <div class="mb-4">
        <br>
      <h3 class="fw-bold text-gray-100">Good Afternoon, <span id="userName">User</span>!</h3>
      <p class="text-muted">Welcome to your CRM Dashboard</p>
    </div>

    <div class="row g-3 mb-4">
      <div class="col-md-4">
<div class="bg-white rounded-lg shadow p-4 text-center border-l-4 border-blue-600">
                <p class="text-blue-600 font-semibold text-sm">Total Leads</p>
                <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $totalLeads }}</h2>
            </div>
      </div>
      <div class="col-md-4">
<div class="bg-white rounded-lg shadow p-4 text-center border-l-4 border-green-600">
                <p class="text-green-600 font-semibold text-sm">Total Deals</p>
                <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $totalDeals }}</h2>
            </div>

      </div>
      <div class="col-md-4">
<div class="bg-white rounded-lg shadow p-4 text-center border-l-4 border-yellow-500">
                <p class="text-yellow-500 font-semibold text-sm">Revenue (Won Deals)</p>
                <h2 class="text-xl font-bold text-gray-900 mt-1">₹{{ number_format($wonRevenue, 2) }}</h2>
            </div>

      </div>
    </div>

    <div class="row g-3 mb-4">
      <div class="col-md-6">
        <div class="bg-white p-6 rounded-lg shadow col-span-1 md:col-span-2">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Deals by Status (Bar Chart)</h3>
            <canvas id="dealsChart" height="100"></canvas>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card p-3">
          <h5 class="card-title mb-3">Recent Deals</h5>
          <ul class="space-y-6 text-gray-700 text-base">
           @forelse($recentDeals as $deal)
                        <li class="flex justify-between">
                            <span class="capitalize">{{ $deal->status }}</span>
                            <span class="font-bold">₹{{ number_format($deal->amount, 2) }}</span>
                        </li>
                     @empty
                        <li>No recent deals available.</li>
                    @endforelse
                </ul>
                </div>
            </div>
            </div>

        <div class="row g-3 mb-4">
        <div class="col-md-12">
            <div class="card p-3">
            <h5 class="card-title mb-3">Upcoming Meetings</h5>
            @if($meetings->count())
                    <ul class="space-y-3 text-gray-700 text-base">
                        @foreach($meetings as $meeting)
                            <li class="flex justify-between">
                                <span>{{ $meeting->title }}</span>
                                <span>{{ \Carbon\Carbon::parse($meeting->scheduled_at)->format('d M, Y h:i A') }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-green-600 text-sm">No upcoming meetings!</p>
                @endif
            </div>
        </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('dealsChart').getContext('2d');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Lead', 'Won', 'Lost'],
      datasets: [{
        label: 'Deals Count',
        data: [
          {{ $dealsByStatus['lead'] ?? 0 }},
        //   {{ $dealsByStatus['proposal'] ?? 0 }},
        //   {{ $dealsByStatus['negotiation'] ?? 0 }},
          {{ $dealsByStatus['won'] ?? 0 }},
          {{ $dealsByStatus['lost'] ?? 0 }}
        ],
        backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#20c997', '#dc3545']
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
</script>
</body>
</html>
@endsection
