@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <br>
    <h2 class="text-xl font-bold text-gray-800 mb-8">CRM Report</h2>
    <br>
    <div class=" grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-gray-200 hover:bg-white cursor-pointer p-6 rounded-lg shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Leads</p>
                    <h3 class="text-2xl font-bold text-indigo-600">{{ $leadCount }}</h3>
                </div>
                <div class="text-indigo-600">
                </div>
            </div>
        </div>

        <div class="bg-gray-200 cursor-pointer p-6 rounded-lg shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Deals</p>
                    <h3 class="text-2xl font-bold text-green-600">{{ $dealCount }}</h3>
                </div>
                <div class="text-green-600">
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="bg-gray-200 cursor-pointer p-6 rounded-lg shadow mb-10">
        <h4 class="text-xl font-semibold text-gray-700 mb-6">Sales - Last 6 Months</h4>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($salesByMonth as $month => $amount)
                <div class="bg-gray-100 hover:bg-gray-200 p-4 rounded text-center transition">
                    <p class="text-sm text-gray-500">{{ $month }}</p>
                    <p class="text-xl font-semibold text-green-600">₹{{ number_format($amount, 2) }}</p>
                </div>
            @empty
                <p class="text-gray-500">No sales data available.</p>
            @endforelse
        </div>
    </div>
    <br>
    <div class="bg-gray-200 cursor-pointer p-6 rounded-lg shadow">
        <h4 class="text-xl font-semibold text-gray-700 mb-6"> Top Performing Users (Won Deals)</h4>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4">User</th>
                        <th class="py-3 px-4">Deals Won</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topUsers as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">{{ $user->name }}</td>
                            <td class="py-2 px-4 font-semibold text-green-700">{{ $user->won_deals_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
