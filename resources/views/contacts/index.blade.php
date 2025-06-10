
@extends('layouts.app')

@section('content')
<div style="background-color:rgb(158, 156, 156); min-height: 100vh; padding-top: 2rem;">
    <div class="max-w-7xl rounded-xl mx-auto p-6">

        <form method="GET" action="{{ route('contacts.index') }}" class="bg-gray-100 border border-gray-300 p-4 rounded shadow-sm mb-4">
            <div class="text-sm font-semibold mb-2 text-gray-700">Filter</div>
            <div class="flex flex-wrap gap-6">
                <input type="text" name="name" value="{{ request('name') }}"
                       class="border px-3 py-1 rounded text-sm w-40" placeholder="Name">

                <input type="text" name="email" value="{{ request('email') }}"
                       class="border px-3 py-1 rounded text-sm w-40" placeholder="Email">

                <input type="text" name="phone" value="{{ request('phone') }}"
                       class="border px-3 py-1 rounded text-sm w-40" placeholder="Phone">

                <button type="submit" style="background-color: gray" class="text-white text-sm px-4 py-1 rounded hover:bg-blue-700">
                    Apply
                </button>

                <a href="{{ route('contacts.index') }}"
                   style="background-color: gray" class="text-white text-sm px-4 py-1 rounded hover:bg-gray-500">
                    Reset
                </a>
            </div>
        </form>

        <div class="bg-[#f3e3d2] border border-gray-300 rounded-lg shadow">
            <div style="background-color:rgb(40, 39, 39)" class=" text-white px-4 py-2 flex justify-between items-center">
                <h2 class="text-sm font-semibold">Contacts</h2>
                <a href="{{ route('contacts.create') }}" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm">+ Add Contact</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm divide-y divide-gray-200">
                    <thead style="background-color:rgb(40, 39, 39)" class="bg-gray-100 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Phone</th>
                            <th class="px-4 py-2 text-left">Owner</th>
                            <th class="px-4 py-2 text-left">Address</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white cursor-pointer divide-y divide-gray-100">
                        @forelse ($contacts as $contact)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $contact->first_name }} {{ $contact->last_name }}</td>
                                <td class="px-4 py-2">{{ $contact->email }}</td>
                                <td class="px-4 py-2">{{ $contact->phone }}</td>
                                <td class="px-4 py-2">{{ $contact->owner->name ?? '—' }}</td>
                                <td class="px-4 py-2">{{ $contact->address }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('contacts.show', $contact) }}" class="text-blue-600 hover:underline mr-2">View</a>
                                    <a href="{{ route('contacts.edit', $contact) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>
                                    <form action="{{ route('contacts.destroy', $contact) }}" method="POST" class="inline-block">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this contact?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-4 text-center text-gray-500">No contacts found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
