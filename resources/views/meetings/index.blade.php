@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto mt-8 p-6 bg-gray-200 rounded-lg shadow">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-900">Meetings</h2>
        <a href="{{ route('meetings.create') }}" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">
            + New Meeting
        </a>
    </div>

    <form method="GET" action="{{ route('meetings.index') }}" class="bg-gray-100 border border-gray-300 p-4 rounded shadow-sm mb-6">
        <div class="text-sm font-semibold mb-2 text-gray-700">Filter Meetings</div>
        <div class="flex flex-wrap gap-6">

            <input type="text" name="title" value="{{ request('title') }}" placeholder="Title"
                class="border px-3 py-1 rounded text-sm w-40">

            <input type="date" name="start_date" value="{{ request('start_date') }}"
                class="border px-3 py-1 rounded text-sm w-40" placeholder="Start Date">

            <input type="date" name="end_date" value="{{ request('end_date') }}"
                class="border px-3 py-1 rounded text-sm w-40" placeholder="End Date">

            <input type="text" name="contact" value="{{ request('contact') }}" placeholder="Contact"
                class="border px-3 py-1 rounded text-sm w-40">

            <input type="text" name="host" value="{{ request('host') }}" placeholder="Host"
                class="border px-3 py-1 rounded text-sm w-40">

            <button type="submit" class="bg-gray-800 text-white text-sm px-4 py-1 rounded hover:bg-gray-700">
                Apply
            </button>

            <a href="{{ route('meetings.index') }}" class="bg-gray-800 text-white text-sm px-4 py-1 rounded hover:bg-gray-700">
                Reset
            </a>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table  class="w-full divide-y divide-gray-200 text-sm">
            <thead style="background-color:rgb(40, 39, 39)" class=" text-white">
                <tr>
                    <th class="px-4 py-2 text-left">Title</th>
                    <th class="px-4 py-2 text-left">From</th>
                    <th class="px-4 py-2 text-left">To</th>
                    <th class="px-4 py-2 text-left">Related To</th>
                    <th class="px-4 py-2 text-left">Contact</th>
                    <th class="px-4 py-2 text-left">Host</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white cursor-pointer divide-y divide-gray-100">
                @forelse ($meetings as $meeting)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2">{{ $meeting->title }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($meeting->start_time)->format('d M Y, h:i A') }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($meeting->end_time)->format('d M Y, h:i A') }}</td>
                        <td class="px-4 py-2">{{ $meeting->related_to_type ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $meeting->contact->first_name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $meeting->host->name ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('meetings.show', $meeting) }}" class="text-blue-600 hover:underline mr-2">View</a>
                            <a href="{{ route('meetings.edit', $meeting) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>
                            <form action="{{ route('meetings.destroy', $meeting) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this meeting?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">No meetings found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
