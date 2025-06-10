@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Meeting</h2>
    </div>

    <form action="{{ route('meetings.update', $meeting->id) }}" method="POST" class="bg-white p-6 rounded shadow space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="title" class="block font-medium text-gray-700">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $meeting->title) }}" required
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500">
            </div>

            <div>
                <label for="venue" class="block font-medium text-gray-700">Meeting Venue</label>
                <select name="venue" id="venue" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
                    <option value="In Office" {{ $meeting->venue == 'In Office' ? 'selected' : '' }}>In Office</option>
                    <option value="Online" {{ $meeting->venue == 'Online' ? 'selected' : '' }}>Online</option>
                    <option value="Client Office" {{ $meeting->venue == 'Client Office' ? 'selected' : '' }}>Client Office</option>
                </select>
            </div>

            <div>
                <label for="location" class="block font-medium text-gray-700">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location', $meeting->location) }}"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div class="flex items-center mt-6">
                <input type="checkbox" name="all_day" id="all_day" value="1"
                    {{ $meeting->all_day ? 'checked' : '' }} class="mr-2">
                <label for="all_day" class="text-gray-700">All Day</label>
            </div>

            <div>
                <label for="start_time" class="block font-medium text-gray-700">From</label>
                <input type="datetime-local" name="start_time" id="start_time"
                    value="{{ old('start_time', \Carbon\Carbon::parse($meeting->start_time)->format('Y-m-d\TH:i')) }}"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label for="end_time" class="block font-medium text-gray-700">To</label>
                <input type="datetime-local" name="end_time" id="end_time"
                    value="{{ old('end_time', \Carbon\Carbon::parse($meeting->end_time)->format('Y-m-d\TH:i')) }}"
                    class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label for="host_id" class="block font-medium text-gray-700">Host Name</label>
                <select name="host_id" id="host_id" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $meeting->host_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="related_to_type" class="block font-medium text-gray-700">Related To</label>
                <select name="related_to_type" id="related_to_type" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
                    <option value="None" {{ $meeting->related_to_type == 'None' ? 'selected' : '' }}>None</option>
                    <option value="Lead" {{ $meeting->related_to_type == 'Lead' ? 'selected' : '' }}>Lead</option>
                    <option value="Contact" {{ $meeting->related_to_type == 'Contact' ? 'selected' : '' }}>Contact</option>
                    <option value="Other" {{ $meeting->related_to_type == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div>
                <label for="contact_id" class="block font-medium text-gray-700">Contact</label>
                <select name="contact_id" id="contact_id" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">Select Contact</option>
                    @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}" {{ $meeting->contact_id == $contact->id ? 'selected' : '' }}>
                            {{ $contact->first_name }} {{ $contact->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label for="description" class="block font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">{{ old('description', $meeting->description) }}</textarea>
        </div>

        <div class="pt-4">
            <button type="submit"
               style="background-color: rgb(0, 200, 255)" class="bg-[#444] text-white px-4 py-1 rounded hover:bg-[#333] ml-4">Update Meeting</button>
            <a href="{{ route('meetings.index') }}"
                style="background-color: red"  class="mr-4 px-4 py-1 rounded text-white hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection
