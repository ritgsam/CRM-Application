@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">Tasks</h2>
        <a href="{{ route('tasks.create') }}" style="background-color: rgb(0, 200, 255)" class="text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Add New Task
        </a>
    </div>

    <div class="bg-gray-200 shadow-md rounded-md p-4 mb-6">
        <form method="GET" action="{{ route('tasks.index') }}" class="bg-gray-100 border p-4 rounded shadow-sm mb-4">
            <div class="text-sm font-semibold mb-2 text-gray-700">Filter</div>
            <div class="flex flex-wrap gap-6">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="border px-3 py-1 rounded text-sm w-40">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="border px-3 py-1 rounded text-sm w-40">
                <select name="status" class="border px-3 py-1 rounded text-sm w-40">
                    <option value="">All Status</option>
                    <option value="Not Started" {{ request('status') == 'Not Started' ? 'selected' : '' }}>Not Started</option>
                    <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
                <button type="submit" style="background-color: gray" class="text-white px-4 py-1 rounded">Apply</button>
                <a href="{{ route('tasks.index') }}" style="background-color: gray" class="text-white px-4 py-1 rounded">Reset</a>
            </div>
        </form>
    </div>


<div class="mb-4 flex items-center gap-2">
    <form method="GET" action="{{ route('tasks.index') }}" class="flex items-center gap-2">
        <label for="per_page" class="text-sm font-medium text-gray-800">Records per page:</label>
        @foreach(request()->except('per_page', 'page') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <select name="per_page" id="per_page" onchange="this.form.submit()" style="background-color: gray" class="border px-2 py-1 rounded text-sm  text-white">
            @foreach([5, 10, 25, 50, 100] as $option)
                <option value="{{ $option }}" {{ (request('per_page', 10) == $option) ? 'selected' : '' }}>{{ $option }}</option>
            @endforeach
        </select>
    </form>
</div>


    <form id="mass-action-form" method="POST" action="{{ route('tasks.massAction') }}">
        @csrf
<input type="hidden" name="selected_tasks" id="update_tasks_input">
        <div class="flex mb-4 gap-4 items-center">
            <select style="background-color: gray" name="action" class="border px-6 py-1 rounded text-white text-sm" required>
                <option value="">Select Action</option>
                <option value="status_Not Started">Mark as Not Started</option>
                <option value="status_In Progress">Mark as In Progress</option>
                <option value="status_Completed">Mark as Completed</option>
                <option value="delete">Delete Selected</option>
            </select>
            <button type="submit" style="background-color: gray" class="text-white px-4 py-1 rounded">Apply</button>
        </div>

        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-2 text-center"><input type="checkbox" id="select-all"></th>
                        <th class="px-4 py-2">Subject</th>
                        <th class="px-4 py-2">Owner</th>
                        <th class="px-4 py-2">Due Date</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Priority</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($tasks as $task)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 text-center">
                                <input type="checkbox" name="task_ids[]" value="{{ $task->id }}">
                            </td>
                            <td class="px-4 py-2 font-medium text-gray-800">{{ $task->subject }}</td>
                            <td class="px-4 py-2">{{ $task->owner->name ?? '—' }}</td>
                            <td class="px-4 py-2">{{ $task->due_date }}</td>
                            <td class="px-4 py-2">{{ $task->status }}</td>
                            <td class="px-4 py-2">{{ $task->priority }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <a href="{{ route('tasks.edit', $task->id) }}" class="text-yellow-600 hover:underline mr-2">Edit</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this task?')" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-4">No tasks found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    <div class="mt-4">{{ $tasks->appends(request()->except('page'))->links() }}</div>
</div>

<script>
    document.getElementById('select-all').addEventListener('change', function (e) {
        document.querySelectorAll('input[name="task_ids[]"]').forEach(cb => cb.checked = e.target.checked);
    });

    document.getElementById('mass-action-form').addEventListener('submit', function (e) {
        const action = this.querySelector('select[name="action"]').value;
        const selected = [...document.querySelectorAll('input[name="task_ids[]"]:checked')].map(cb => cb.value);

        if (selected.length === 0) {
            e.preventDefault();
            return alert('Please select at least one task.');
        }

        if (action.startsWith('status_')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('tasks.massUpdate') }}";

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = "{{ csrf_token() }}";
            form.appendChild(csrf);

            const ids = document.createElement('input');
            ids.type = 'hidden';
            ids.name = 'task_ids';
            ids.value = selected.join(',');
            form.appendChild(ids);

            const status = document.createElement('input');
            status.type = 'hidden';
            status.name = 'status';
            status.value = action.replace('status_', '');
            form.appendChild(status);

            document.body.appendChild(form);
            form.submit();
            e.preventDefault();
        } else if (action === 'delete') {
            if (!confirm('Are you sure you want to delete selected tasks?')) {
                e.preventDefault();
            }
        }
    });
</script>

@endsection
