@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-4">Meeting Details</h2>

    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <dt class="font-semibold">Title:</dt>
            <dd>{{ $meeting->title }}</dd>
        </div>

        <div>
            <dt class="font-semibold">Venue:</dt>
            <dd>{{ $meeting->venue }}</dd>
        </div>

        <div>
            <dt class="font-semibold">Location:</dt>
            <dd>{{ $meeting->location }}</dd>
        </div>

        <div>
            <dt class="font-semibold">All Day:</dt>
            <dd>{{ $meeting->all_day ? 'Yes' : 'No' }}</dd>
        </div>

        <div>
            <dt class="font-semibold">Start Time:</dt>
            <dd>{{ $meeting->start_time }}</dd>
        </div>

        <div>
            <dt class="font-semibold">End Time:</dt>
            <dd>{{ $meeting->end_time }}</dd>
        </div>

        <div>
            <dt class="font-semibold">Related To:</dt>
            <dd>{{ $meeting->related_to_type }}</dd>
        </div>

        <div>
            <dt class="font-semibold">Contact:</dt>
            <dd>{{ $meeting->contact->first_name ?? '-' }}</dd>
        </div>

        <div>
            <dt class="font-semibold">Host:</dt>
            <dd>{{ $meeting->host->name ?? '-' }}</dd>
        </div>

        <div class="md:col-span-2">
            <dt class="font-semibold">Description:</dt>
            <dd>{{ $meeting->description }}</dd>
        </div>
    </dl>
</div>
@endsection
