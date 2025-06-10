@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen py-6 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6 mb-6 flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-1">{{ $deal->deal_name }}</h2>
                <p class="text-sm text-gray-500">Deal ID: #{{ $deal->id }} • Created {{ $deal->created_at->diffForHumans() }}</p>
            </div>

            <div class="flex flex-wrap gap-2 text-sm">
                <a href="{{ route('deals.edit', $deal->id) }}" class="bg-gray-500 text-white px-4 py-2 h-8 rounded hover:bg-gray-600">Edit</a>

                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $deal->contact_email }}&su=Regarding%20Your%20Deal&body=Hi%20{{ urlencode($deal->contact_name) }},"
                   target="_blank" class="bg-gray-500 text-white px-4 py-2 h-8 rounded hover:bg-gray-600">Send Email</a>

                <a href="#" onclick="window.print()" style="background-color: rgb(0, 200, 255)" class="bg-gray-500 text-white px-4 py-2 h-8 rounded hover:bg-gray-600">Print</a>

                <form action="{{ route('deals.destroy', $deal->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this deal?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-1.5 rounded hover:bg-red-700">Delete</button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white rounded shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Deal Overview</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                        <div><strong>Owner:</strong> {{ $deal->owner->name ?? '—' }}</div>
                        <div><strong>Amount:</strong> ₹{{ number_format($deal->amount, 2) }}</div>
                        <div><strong>Account:</strong> {{ $deal->account_name ?? '—' }}</div>
                        <div><strong>Lead Source:</strong> {{ $deal->lead_source }}</div>
                        <div><strong>Contact:</strong> {{ $deal->contact_name ?? '—' }}</div>
                        <div><strong>Closing Date:</strong> {{ $deal->closing_date ? \Carbon\Carbon::parse($deal->closing_date)->format('d M Y') : '—' }}</div>
                        <div><strong>Status:</strong> {{ $deal->status }}</div>
                        <div class="col-span-2"><strong>Description:</strong><br>{{ $deal->description ?? '—' }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Activity</h3>
                <ul class="text-sm text-gray-700 space-y-3">
                    <li><strong>Created:</strong> {{ $deal->created_at->format('d M Y, h:i A') }}</li>
                    <li><strong>Last Updated:</strong> {{ $deal->updated_at->format('d M Y, h:i A') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
