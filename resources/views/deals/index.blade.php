
@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">Deals</h2>
        <a href="{{ route('deals.create') }}" style="background-color: rgb(0, 200, 255)" class="text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Add New Deal
        </a>
    </div>

    <div class="bg-gray-200 shadow-md rounded-md p-4 mb-6">
        <form method="GET" action="{{ route('deals.index') }}" class="bg-gray-100 border p-4 rounded shadow-sm mb-4">
            <div class="text-sm font-semibold mb-2 text-gray-700">Filter</div>
            <div class="flex flex-wrap gap-6">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="border px-3 py-1 rounded text-sm w-40">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="border px-3 py-1 rounded text-sm w-40">
                <select name="status" class="border px-3 py-1 rounded text-sm w-40">
                    <option value="">All Status</option>
                    <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                    <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                    <option value="Won" {{ request('status') == 'Won' ? 'selected' : '' }}>Won</option>
                    <option value="Lost" {{ request('status') == 'Lost' ? 'selected' : '' }}>Lost</option>
                </select>
                <button type="submit" style="background-color: gray" class="text-white px-4 py-1 rounded">Apply</button>
                <a href="{{ route('deals.index') }}" style="background-color: gray" class="text-white px-4 py-1 rounded">Reset</a>
            </div>
        </form>
    </div>

<div class="mb-4 flex items-center gap-2">
    <form method="GET" action="{{ route('deals.index') }}" class="flex items-center gap-2">
        <label for="per_page" class="text-sm font-medium text-gray-800">Records per page:</label>
        @foreach(request()->except('per_page', 'page') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <select style="background-color: gray" name="per_page" id="per_page" onchange="this.form.submit()" class="border px-2 py-1 rounded text-white text-sm">
            @foreach([5, 10, 25, 50, 100] as $option)
                <option value="{{ $option }}" {{ (request('per_page', 10) == $option) ? 'selected' : '' }}>{{ $option }}</option>
            @endforeach
        </select>
    </form>
</div>

{{ $deals->appends(request()->except('page'))->links() }}

    <form  id="mass-action-form" method="POST" action="{{ route('deals.massAction') }}">
        @csrf
        <div  class="flex mb-4 gap-4 items-center">
            <select style="background-color: gray" name="action" class="border px-6 py-1 rounded text-white text-sm" required>
                <option value="">Select Action</option>
                <option value="delete">Mass Delete</option>
                <option value="update">Mass Update</option>
                <option value="assign_task">Assign Task</option>
            </select>
            <button type="submit" style="background-color: gray" class="text-white px-4 py-1 rounded">Apply</button>
        </div>

        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-2 text-center"><input type="checkbox" id="select-all"></th>
                        <th class="px-4 py-2">Deal Name</th>
                        <th class="px-4 py-2">Owner</th>
                        <th class="px-4 py-2">Account</th>
                        <th class="px-4 py-2">Amount</th>
                        <th class="px-4 py-2">Lead Source</th>
                        <th class="px-4 py-2">Contact</th>
                        <th class="px-4 py-2">Closing Date</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($deals as $deal)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 text-center">
                                <input type="checkbox" name="selected_deals[]" value="{{ $deal->id }}">
                            </td>
                            <td class="px-4 py-2 font-medium text-gray-800">{{ $deal->deal_name }}</td>
                            <td class="px-4 py-2">{{ $deal->owner->name ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $deal->account_name }}</td>
                            <td class="px-4 py-2">₹{{ number_format($deal->amount, 2) }}</td>
                            <td class="px-4 py-2">{{ $deal->lead_source }}</td>
                            <td class="px-4 py-2">{{ $deal->contact_name }}</td>
                            <td class="px-4 py-2">{{ $deal->closing_date ? date('d M Y', strtotime($deal->closing_date)) : '—' }}</td>
                            <td class="px-4 py-2">{{ $deal->status }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <a href="{{ route('deals.show', $deal->id) }}" style="background-color: rgb(0, 200, 255)" class="rounded px-4 py-2 text-white">View</a>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-gray-500 py-4">No deals found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    <div class="mt-4">{{ $deals->links() }}</div>
</div>


<div id="massUpdateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-md p-6 rounded shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Mass Update Deals</h2>
        <form method="POST" action="{{ route('deals.massUpdate') }}">
            @csrf
            <input type="hidden" name="selected_deals" id="update_deals_input">

            <div class="mb-4">
                <label class="block font-medium mb-1">Status</label>
                <select name="status" class="w-full border px-3 py-2 rounded" required>
                    <option value="">Select Status</option>
                    <option value="open">Open</option>
                    <option value="won">Won</option>
                    <option value="lost">Lost</option>
                    <option value="closed">Closed</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Source</label>
                <input type="text" name="source" class="w-full border px-3 py-2 rounded" placeholder="Source">
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" onclick="closeMassUpdateModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>

<div id="assignTaskModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-md p-6 rounded shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Assign Task to Deals</h2>
<form method="POST" action="{{ route('deals.assignTask' ) }}">
            @csrf
            <input type="hidden" name="selected_deals" id="assign_task_deals_input">

            <div class="mb-4">
                <label class="block font-medium mb-1">Task</label>
                <input type="text" name="task" class="w-full border px-3 py-2 rounded" placeholder="Task Description" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Due Date</label>
                <input type="date" name="due_date" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Assign To</label>
                <select name="assigned_to" class="w-full border px-3 py-2 rounded" required>
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" onclick="closeAssignTaskModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Assign</button>
            </div>
        </form>
    </div>
</div>


<script>

     document.getElementById('select-all').addEventListener('change', function (e) {
        document.querySelectorAll('input[name="selected_deals[]"]').forEach(cb => cb.checked = e.target.checked);
    });

    document.getElementById('mass-action-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const action = this.querySelector('select[name="action"]').value;
        const selected = [...document.querySelectorAll('input[name="selected_deals[]"]:checked')].map(cb => cb.value);
        if (selected.length === 0) return alert('Please select at least one deal.');
        if (action === 'update') {
            document.getElementById('update_deals_input').value = selected.join(',');
            document.getElementById('massUpdateModal').classList.remove('hidden');
        } else if (action === 'assign_task') {
            document.getElementById('assign_task_deals_input').value = selected.join(',');
            document.getElementById('assignTaskModal').classList.remove('hidden');
        } else {
            this.submit();
        }
    });
</script>
@endsection
