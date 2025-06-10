@extends('layouts.app')

@section('content')
<div style="background-color:rgb(158, 156, 156)" min-height: 100vh; padding-top: 2rem;>
    <br>
    <div class="max-w-7xl mx-auto bg-gray-200 border border-gray-300 rounded shadow p-2">
        <div class="bg-black text-black px-4 py-4 rounded-t">
            <h2 class="text-lg font-semibold">Add New Deal</h2>
        </div>

        <form method="POST" action="{{ route('deals.store') }}" class="pt-4">
            @csrf
            <div class="space-y-4">
                <div class="flex flex-wrap gap-6">
                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Deal Owner:</label>
                        <select name="deal_owner" class="w-full border px-3 py-2 rounded">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ (old('deal_owner') == $user->id || (isset($lead) && $lead->owner_id == $user->id)) ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Deal Name:</label>
                        <input type="text" name="deal_name" class="w-full border px-3 py-2 rounded"
                               value="{{ old('deal_name', $lead->deal_name ?? '') }}" required>
                    </div>
                </div>

                <div class="flex flex-wrap gap-6">
                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Account Name:</label>
                        <input type="text" name="account_name" class="w-full border px-3 py-2 rounded"
                               value="{{ old('account_name', $lead->company ?? '') }}">
                    </div>

                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Amount:</label>
                        <input type="number" step="0.01" name="amount" class="w-full border px-3 py-2 rounded"
                               value="{{ old('amount', $lead->amount ?? '') }}">
                    </div>
                </div>

<div class="w-full md:w-5/12 mt-4">
    <label class="block text-sm font-medium mb-1">Status:</label>
    <select name="status" class="w-full border px-3 py-2 rounded" required>
        <option value="">Select Status</option>
        <option value="Open" {{ old('status') == 'Open' ? 'selected' : '' }}>Open</option>
        <option value="Won" {{ old('status') == 'Won' ? 'selected' : '' }}>Won</option>
        <option value="Lost" {{ old('status') == 'Lost' ? 'selected' : '' }}>Lost</option>
        <option value="Closed" {{ old('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
    </select>
</div>


                <div class="flex flex-wrap gap-6">
                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Lead Source:</label>
                        <select name="lead_source" class="w-full border px-3 py-2 rounded">
                            @php
                                $sources = ['Web', 'Phone', 'Email', 'Referral'];
                            @endphp
                            @foreach($sources as $source)
                                <option value="{{ $source }}"
                                    {{ (old('lead_source') == $source || (isset($lead) && $lead->source == $source)) ? 'selected' : '' }}>
                                    {{ $source }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-5/12">
                        <label class="block text-sm font-medium mb-1">Contact Name:</label>
                        <input type="text" name="contact_name" class="w-full border px-3 py-2 rounded"
                               value="{{ old('contact_name', $lead->contact_name ?? '') }}">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Description:</label>
                    <textarea name="description" class="w-full border px-3 py-2 rounded" rows="3">{{ old('description', $lead->description ?? '') }}</textarea>
                </div>

                <div class="w-full md:w-5/12">
                    <label class="block text-sm font-medium mb-1">Closing Date:</label>
                    <input type="date" name="closing_date" class="w-full border px-3 py-2 rounded"
                        value="{{ old('closing_date', isset($lead->closing_date) ? \Carbon\Carbon::parse($lead->closing_date)->format('Y-m-d') : '') }}">
                </div>
            </div>

            <div class="mt-6 text-right">
                <button type="submit" style="background-color: #555;" class="text-white px-6 py-2 rounded hover:bg-gray-700">
                    Save Deal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
