@extends('layouts.app')

@section('content')
<div style="background-color:gray; min-height: 100vh; padding-top: 2rem;">
    <div class="w-2xl mx-auto bg-gray-100 border border-gray-300 rounded shadow p-4">
        <div class="bg-black text-black px-4 py-2 rounded-t">
            <h2 class="text-lg font-semibold">Edit Deal</h2>
        </div>

        <form method="POST" action="{{ route('deals.update', $deal->id) }}" class="pt-4">
            @csrf
            @method('PUT')

            <div class=" space-y-4">
                <div class="flex flex-wrap gap-6">
                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Deal Owner:</label>
                        <select name="deal_owner" class="w-full border px-3 py-2 rounded" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $deal->deal_owner == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Deal Name:</label>
                        <input type="text" name="deal_name" class="w-full border px-3 py-2 rounded" value="{{ $deal->deal_name }}" required>
                    </div>
                </div>

                <div class="flex flex-wrap gap-6">
                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Account Name:</label>
                        <input type="text" name="account_name" class="w-full border px-3 py-2 rounded" value="{{ $deal->account_name }}">
                    </div>

                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Amount:</label>
                        <input type="number" step="0.01" name="amount" class="w-full border px-3 py-2 rounded" value="{{ $deal->amount }}">
                    </div>
                </div>

                <div class="flex flex-wrap gap-6">
                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Lead Source:</label>
                        <select name="lead_source" class="w-full border px-3 py-2 rounded">
                            <option value="Web" {{ $deal->lead_source == 'Web' ? 'selected' : '' }}>Web</option>
                            <option value="Phone" {{ $deal->lead_source == 'Phone' ? 'selected' : '' }}>Phone</option>
                            <option value="Email" {{ $deal->lead_source == 'Email' ? 'selected' : '' }}>Email</option>
                            <option value="Referral" {{ $deal->lead_source == 'Referral' ? 'selected' : '' }}>Referral</option>
                        </select>
                    </div>

                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Contact Name:</label>
                        <input type="text" name="contact_name" class="w-full border px-3 py-2 rounded" value="{{ $deal->contact_name }}">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Description:</label>
                    <textarea name="description" class="w-full border px-3 py-2 rounded" rows="3">{{ $deal->description }}</textarea>
                </div>

                <div class="w-full md:w-5/12">
                    <label class="block text-sm font-medium mb-1">Closing Date:</label>
                    <input type="date" name="closing_date" class="w-full border px-3 py-2 rounded" value="{{ $deal->closing_date }}">
                </div>
            </div>

            <div class="mt-6 text-right">
                <a href="{{ route('deals.index') }}" class="text-black hover:underline mr-4">Cancel</a>
                <button type="submit" style="background-color: #555;" class="text-white px-6 py-2 rounded hover:bg-gray-700">
                    Update Deal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
