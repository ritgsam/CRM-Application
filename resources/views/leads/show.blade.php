@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen py-6 px-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6 mb-6 flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-1">{{ $lead->name }}</h2>
                <p class="text-sm text-gray-500">Lead ID: #{{ $lead->id }} • Created {{ $lead->created_at->diffForHumans() }}</p>
            </div>

            <div class="flex flex-wrap gap-2 text-sm">
                <a href="{{ route('leads.edit', $lead->id) }}"
                    class="bg-gray-500 text-white px-4 py-2 h-8 rounded hover:bg-gray-600">Edit</a>


                <a href="{{ route('deals.createFromLead', $lead->id) }}"
                    class="bg-gray-500 text-white px-4 py-2 h-8 rounded hover:bg-gray-600">Convert to Deal</a>

                <a href="{{ route('leads.clone', $lead->id) }}"
                    class="bg-gray-500 text-white px-4 py-2 h-8 rounded hover:bg-gray-600">Clone</a>

                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $lead->email }}&su=Regarding%20Your%20Lead&body=Hi%20{{ urlencode($lead->name) }},%0D%0A%0D%0A"
                    target="_blank"
                    class="bg-gray-500 text-white px-4 py-2 h-8 rounded hover:bg-gray-600">Send Email</a>

                <a href="#" onclick="window.print()"
                  style="background-color: rgb(0, 200, 255)"  class="bg-gray-500 text-white px-4 py-2 h-8 rounded hover:bg-gray-600">Print</a>

                <form action="{{ route('leads.destroy', $lead->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this lead?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 text-white px-4 py-1.5 rounded hover:bg-red-700">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white rounded shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Lead Overview</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                        <div><span class="font-semibold">Lead Owner:</span> {{ $lead->owner->name ?? 'N/A' }}</div>
                        <div><span class="font-semibold">Status:</span> {{ ucfirst($lead->status) }}</div>
                        <div><span class="font-semibold">Company:</span> {{ $lead->company }}</div>
                        <div><span class="font-semibold">Email:</span> {{ $lead->email ?? 'N/A' }}</div>
                        <div><span class="font-semibold">Phone:</span> {{ $lead->phone }}</div>
                        <div><span class="font-semibold">Rating:</span> {{ $lead->rating }}</div>
                        <div><span class="font-semibold">Source:</span> {{ $lead->source }}</div>
                        <div><span class="font-semibold">Website:</span> {{ $lead->website ?? '—' }}</div>
                        <div class="col-span-2">
                            <span class="font-semibold">Description:</span><br>
                            {{ $lead->description ?? '—' }}
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Address Information</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                        <div>
                            <p><strong>Street:</strong> {{ $lead->street ?? '—' }}</p>
                            <p><strong>City:</strong> {{ $lead->city ?? '—' }}</p>
                            <p><strong>State:</strong> {{ $lead->state ?? '—' }}</p>
                        </div>
                        <div>
                            <p><strong>Postal Code:</strong> {{ $lead->postal_code ?? '—' }}</p>
                            <p><strong>Country:</strong> {{ $lead->country ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Activity Timeline</h3>
                <ul class="text-sm text-gray-700 space-y-3">
                    <li><strong>Created:</strong> {{ $lead->created_at->format('d M Y, h:i A') }}</li>
                    <li><strong>Last Updated:</strong> {{ $lead->updated_at->format('d M Y, h:i A') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
