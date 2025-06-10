@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-gray-200 text-black p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Contact Details</h2>

    <div class="grid grid-cols-2 gap-4">
        <div><strong>First Name:</strong> {{ $contact->first_name }}</div>
        <div><strong>Last Name:</strong> {{ $contact->last_name }}</div>
        <div><strong>Email:</strong> {{ $contact->email }}</div>
        <div><strong>Phone:</strong> {{ $contact->phone }}</div>
        <div><strong>Account Name:</strong> {{ $contact->account_name }}</div>
        <div><strong>Lead Source:</strong> {{ $contact->lead_source }}</div>
        <div><strong>DOB:</strong> {{ $contact->dob }}</div>
        <div><strong>Address:</strong> {{ $contact->address }}</div>
        <div><strong>State:</strong> {{ $contact->state }}</div>
        <div><strong>Country:</strong> {{ $contact->country }}</div>
        <div class="col-span-2"><strong>Description:</strong><br>{{ $contact->description }}</div>
    </div>

    <div class="mt-6">
        <a href="{{ route('contacts.index') }}" class="text-blue-500 hover:underline">← Back to Contacts</a>
    </div>
</div>
@endsection
