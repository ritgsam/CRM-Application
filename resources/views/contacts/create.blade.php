@extends('layouts.app')

@section('content')

<div  class=" bg-gray-200 max-w-7xl mx-auto mt-8 p-6 shadow rounded-lg">
    <h2 class="text-xl font-semibold bg-[#2e2e2e] text-black px-4 py-2 rounded-t-md mb-6">Add New Contact</h2>

    <form action="{{ route('contacts.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Contact Owner</label>
                <select name="contact_owner_id" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                    <option value="">-- Select Owner --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" name="first_name" class="w-full border-gray-300 rounded-md shadow-sm mt-1" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" name="last_name" class="w-full border-gray-300 rounded-md shadow-sm mt-1" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Account Name</label>
                <input type="text" name="account_name" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Other Phone</label>
                <input type="text" name="other_phone" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Lead Source</label>
                <input type="text" name="lead_source" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">DOB</label>
                <input type="date" name="dob" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">State</label>
                <input type="text" name="state" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Country</label>
                <input type="text" name="country" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
            </div>

            <div class="col-span-full">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm mt-1"></textarea>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <a href="{{ route('contacts.index') }}" style="background-color: red" class="mr-4 px-4 py-1 rounded text-white hover:underline">Cancel</a>
            <button type="submit" style="background-color: rgb(0, 200, 255)" class="text-white px-4 py-1 rounded hover:bg-[#333] ml-4">Save Contact</button>
        </div>
    </form>
</div>

@endsection
