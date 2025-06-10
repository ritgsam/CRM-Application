@extends('layouts.app')

@section('content')
<div style="background-color:rgb(158, 156, 156); min-height: 100vh; padding-top: 2rem;">
    <div class="w-4xl mx-auto bg-gray-200 border border-gray-300 rounded shadow p-6">
        <div class="bg-black text-black px-4 py-2 rounded-t">
            <h2 class="text-lg font-semibold">Edit Contact</h2>
        </div>

        <form method="POST" action="{{ route('contacts.update', $contact->id) }}" class="pt-4">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div class="flex flex-wrap gap-6">
                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">First Name:</label>
                        <input type="text" name="first_name" class="w-full border px-3 py-2 rounded" value="{{ $contact->first_name }}" required>
                    </div>

                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Last Name:</label>
                        <input type="text" name="last_name" class="w-full border px-3 py-2 rounded" value="{{ $contact->last_name }}">
                    </div>
                </div>

                <div class="flex flex-wrap gap-6">
                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Email:</label>
                        <input type="email" name="email" class="w-full border px-3 py-2 rounded" value="{{ $contact->email }}">
                    </div>

                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Phone:</label>
                        <input type="text" name="phone" class="w-full border px-3 py-2 rounded" value="{{ $contact->phone }}">
                    </div>
                </div>

                <div class="flex flex-wrap gap-6">
                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Company:</label>
                        <input type="text" name="company" class="w-full border px-3 py-2 rounded" value="{{ $contact->company }}">
                    </div>

                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Position:</label>
                        <input type="text" name="position" class="w-full border px-3 py-2 rounded" value="{{ $contact->position }}">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Address:</label>
                    <textarea name="address" class="w-full border px-3 py-2 rounded" rows="3">{{ $contact->address }}</textarea>
                </div>
            </div>

            <div class="mt-6 text-right">
                <a href="{{ route('contacts.index') }}" class="text-black hover:underline mr-4">Cancel</a>
                <button type="submit" style="background-color: #555;" class="text-white px-6 py-2 rounded hover:bg-gray-700">
                    Update Contact
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
