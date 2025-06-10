@extends('layouts.app')

@section('content')
<div class="max-w-7xl bg-gray-200 mx-auto mt-8 p-6 shadow rounded-lg" >
    <h2 class="text-xl font-semibold text-black px-4 py-2 rounded-t-md mb-6">Add New Lead</h2>

    @if ($errors->any())
        <div class="bg-red-200 p-4 rounded text-red-800 mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('leads.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="flex justify-center mb-8">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lead Image</label>
                <input type="file" name="lead_image" class="border border-gray-300 rounded-md p-2">
            </div>
        </div>

        <div class="space-y-6 mb-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                </div>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Second Name</label>
                    <input type="text" name="second_name" value="{{ old('second_name') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                </div>
            </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Website</label>
                    <input type="text" name="website" value="{{ old('website') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Annual Revenue</label>
                    <input type="number" name="annual_revenue" value="{{ old('annual_revenue') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Rating</label>
                    <select name="rating" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                        <option value="">Select Rating</option>
                        @foreach(['Acquired', 'Active', 'Market Failed', 'Project Cancelled', 'Shutdown'] as $rating)
                            <option value="{{ $rating }}" {{ old('rating') == $rating ? 'selected' : '' }}>{{ $rating }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">No of Employees</label>
                    <input type="number" name="employees" value="{{ old('employees') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Company</label>
                    <input type="text" name="company" value="{{ old('company') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Secondary Email</label>
                    <input type="email" name="secondary_email" value="{{ old('secondary_email') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Related To</label>
                    <select name="account_id" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                        <option value="">-- Select Account --</option>
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>{{ $account->account_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Source</label>
                    <select name="source" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                        <option value="">Select Source</option>
                        @foreach ($leadSources as $source)
                            <option value="{{ $source }}" {{ old('source') == $source ? 'selected' : '' }}>{{ $source }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Lead Owner</label>
                    <select name="lead_owner" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                        <option value="">Select Owner</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('lead_owner') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                        <option value="">Select Status</option>
                        @foreach ($leadStatuses as $status)
                            <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <br>
        <div class="bg-white p-6 rounded shadow mb-10">
            <h3 class="text-lg font-semibold mb-4">Address Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Street</label>
                    <input type="text" name="street" value="{{ old('street') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" name="city" value="{{ old('city') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">State</label>
                    <input type="text" name="state" value="{{ old('state') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Country</label>
                    <input type="text" name="country" value="{{ old('country') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Zip Code</label>
                    <input type="text" name="zip_code" value="{{ old('zip_code') }}" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                </div>
            </div>
        </div>
        <br>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
            <textarea name="notes" rows="4" class="w-full border-gray-300 rounded-md shadow-sm p-3">{{ old('notes') }}</textarea>
        </div>

        <div class="flex justify-end mt-6">
            <a href="{{ route('leads.index') }}" style="background-color: red" class="mr-4 px-4 py-1 rounded text-white hover:underline ">Cancel</a>

            <button type="submit" style="background-color: rgb(0, 200, 255)" class="bg-[#444] text-white px-4 py-1 rounded hover:bg-[#333] ml-4 ">Save Lead</button>
        </div>
    </form>
</div>
@endsection
