@extends('layouts.app')

@section('content')
<div  class="bg-gray-200 max-w-7xl mx-auto mt-8 p-6 shadow rounded-lg">

    <h2 class="text-xl font-semibold bg-[#2e2e2e] text-black px-4 py-2 rounded-t-md mb-6">Add New Meeting</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('meetings.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" class="w-full border-gray-300 rounded-md shadow-sm mt-1" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Venue</label>
                <select name="venue" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                    <option value="In Office">In Office</option>
                    <option value="Online">Online</option>
                    <option value="Client Office">Client Office</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Location</label>
                <input type="text" name="location" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
            </div>

            <div class="flex items-center mt-7 space-x-2">
                <input type="checkbox" name="all_day" id="all_day" value="1">
                <label for="all_day" class="text-sm font-medium text-gray-700">All Day</label>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">From (Start Time)</label>
                <input type="datetime-local" name="start_time" class="w-full border-gray-300 rounded-md shadow-sm mt-1" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">To (End Time)</label>
                <input type="datetime-local" name="end_time" class="w-full border-gray-300 rounded-md shadow-sm mt-1" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Host</label>
                <select name="host_id" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Related To</label>
                <select name="related_to_type" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                    <option value="None">None</option>
                    <option value="Lead">Lead</option>
                    <option value="Contact">Contact</option>
                    <option value="Others">Others</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Contact</label>
                <select name="contact_id" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                    <option value="">Select Contact</option>
                    @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}">{{ $contact->first_name }} {{ $contact->last_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-full">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm mt-1"></textarea>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <a href="{{ route('meetings.index') }}" style="background-color: red"  class="mr-4 px-4 py-1 rounded text-white hover:underline">Cancel</a>
            <button type="submit" style="background-color: rgb(0, 200, 255)" class="bg-[#444] text-white px-4 py-1 rounded hover:bg-[#333] ml-4">Save Meeting</button>
        </div>
    </form>
</div>
@endsection
