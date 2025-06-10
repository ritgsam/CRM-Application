
@extends('layouts.app')

@section('content')
<div class="bg-[#e4d0d3] min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Account List</h2>
            <a href="{{ route('accounts.create') }}" style="background-color: rgb(0, 200, 255)" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add Account</a>
        </div>

        <div class="bg-gray-200 p-4 rounded-lg shadow mb-6">
            <form method="GET" class="flex flex-wrap items-center gap-4">
                <div>
                    <select name="owner_id" onchange="this.form.submit()" class="border border-gray-600 rounded-lg px-6 py-2">
                        <option value="">All Owners</option>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->id }}" {{ request('owner_id') == $owner->id ? 'selected' : '' }}>
                                {{ $owner->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </form>
        </div>

        <div style="background-color:rgb(40, 39, 39)" class=" rounded shadow overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-900 text-white uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Account Name</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Website</th>
                        <th class="px-4 py-3">Owner</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y cursor-pointer divide-gray-200 bg-white">
                    @forelse($accounts as $account)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2">{{ $account->account_name }}</td>
                            <td class="px-4 py-2">{{ $account->phone }}</td>
                            <td class="px-4 py-2">{{ $account->website }}</td>
                            <td class="px-4 py-2">{{ $account->owner->name ?? '—' }}</td>
                            <td class="px-4 py-2 text-blue-600">
                                <a href="{{ route('accounts.edit', $account->id) }}" class="hover:underline">Edit</a>
                                <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">No accounts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
