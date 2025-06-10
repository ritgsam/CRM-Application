@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-8 p-6 shadow rounded-lg" style="background-color:rgb(234, 218, 221)">
    <h2 class="text-xl font-semibold text-black px-4 py-2 rounded-t-md mb-6">Edit Lead</h2>

    @if ($errors->any())
        <div class="bg-red-200 p-4 rounded text-red-800 mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('leads.update', $lead->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Lead Image</label>
            <input type="file" name="lead_image" class="mt-1">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

            <x-input label="Title" name="title" :value="$lead->title" />
            <x-input label="First Name" name="first_name" :value="$lead->first_name" />
            <x-input label="Second Name" name="second_name" :value="$lead->second_name" />
            <x-input label="Annual Revenue" name="annual_revenue" type="number" :value="$lead->annual_revenue" />
            <x-input label="Website" name="website" :value="$lead->website" />
            <x-input label="No of Employees" name="employees" type="number" :value="$lead->employees" />

            <div>
                <label class="block text-sm font-medium text-gray-700">Rating</label>
                <select name="rating" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                    <option value="">Select Rating</option>
                    @foreach(['Acquired', 'Active', 'Market Failed', 'Project Cancelled', 'Shutdown'] as $rating)
                        <option value="{{ $rating }}" {{ $lead->rating == $rating ? 'selected' : '' }}>{{ $rating }}</option>
                    @endforeach
                </select>
            </div>

            <x-input label="Secondary Email" name="secondary_email" type="email" :value="$lead->secondary_email" />
            <x-input label="Street" name="street" :value="$lead->street" />
            <x-input label="City" name="city" :value="$lead->city" />
            <x-input label="State" name="state" :value="$lead->state" />
            <x-input label="Country" name="country" :value="$lead->country" />
            <x-input label="Zip Code" name="zip_code" :value="$lead->zip_code" />

            <div>
                <label class="block text-sm font-medium text-gray-700">Related To</label>
                <select name="account_id" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                    <option value="">-- Select Account --</option>
                    @foreach($accounts as $account)
                        <option value="{{ $account->id }}" {{ $lead->account_id == $account->id ? 'selected' : '' }}>
                            {{ $account->account_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <x-input label="Company" name="company" :value="$lead->company" />
            <x-input label="Email" name="email" type="email" :value="$lead->email" />
            <x-input label="Phone" name="phone" :value="$lead->phone" />

            <div>
                <label class="block text-sm font-medium text-gray-700">Source</label>
                <select name="source" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                    <option value="">Select Source</option>
                    @foreach ($leadSources as $source)
                        <option value="{{ $source }}" {{ $lead->source == $source ? 'selected' : '' }}>{{ $source }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Lead Owner</label>
                <select name="lead_owner" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                    <option value="">Select Owner</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $lead->lead_owner == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                    <option value="">Select Status</option>
                    @foreach ($leadStatuses as $status)
                        <option value="{{ $status }}" {{ $lead->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-full">
                <label class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea name="notes" rows="3" class="w-full border-gray-300 rounded-md shadow-sm mt-1">{{ $lead->notes }}</textarea>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <a href="{{ route('leads.index') }}" style="background-color: red" class="mr-4 px-4 py-1 rounded text-white hover:underline ">Cancel</a>
            <button type="submit" style="background-color: rgb(0, 200, 255)" class="bg-[#444] text-white px-4 py-1 rounded hover:bg-[#333] ml-4 ">Update Lead</button>
        </div>
    </form>
</div>
@endsection
