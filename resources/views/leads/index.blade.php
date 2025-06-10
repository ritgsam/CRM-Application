@extends('layouts.app')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold text-white">Leads</h1>
            <a href="{{ route('leads.create') }}" style="background-color: rgb(0, 200, 255)" class="text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                + Add New Lead
            </a>
        </div>

        <div class="bg-gray-200 shadow rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('leads.index') }}" class="flex flex-wrap items-center gap-4">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="border px-3 py-1 rounded text-sm">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="border px-3 py-1 rounded text-sm">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="border px-3 py-1 rounded text-sm">
                <select name="status" class="border px-3 py-1 rounded text-sm">
                    <option value="">All Status</option>
                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                    <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                    <option value="qualified" {{ request('status') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                    <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>Converted</option>
                </select>
                <button type="submit" style="background-color: gray" class="text-white px-4 py-1 rounded">Apply</button>
                <a href="{{ route('leads.index') }}" style="background-color: gray" class="text-white px-4 py-1 rounded">Reset</a>
            </form>
        </div>

        <div class="mb-4 flex items-center gap-2">
            <form method="GET" action="{{ route('leads.index') }}" class="flex items-center gap-2">
                <label for="per_page" class="text-sm font-medium text-white">Records per page:</label>
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

        <form id="mass-action-form" method="POST" action="{{ route('leads.massAction') }}">
            @csrf

            <div class="flex items-center gap-4 mb-4">
                <select name="action" style="background-color: gray" class="border px-6 py-1 rounded text-white text-sm" required>
                    <option value="">-- Select Action --</option>
                    <option value="delete">Mass Delete</option>
                    <option value="update">Mass Update</option>
                    <option value="convert">Mass Convert</option>
                    <option value="email">Mass Email</option>
                    <option value="print">Print View</option>
                </select>
                <button type="submit" style="background-color: gray" class="text-white px-4 py-1 rounded hover:bg-indigo-700">Apply</button>
                <button type="button" onclick="openAssignTaskModal()" style="background-color: gray" class="text-white px-4 py-1 rounded hover:bg-indigo-700">
                    Assign Task
                </button>
            </div>

            <div class="bg-gray-200 shadow rounded-lg overflow-hidden">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                <input type="checkbox" class="rounded" id="select-all">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Lead Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Company</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Source</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Owner</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class=" cursor-pointer bg-white divide-y divide-gray-200 ">
                        @foreach($leads as $lead)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" name="selected_leads[]" value="{{ $lead->id }}">
                            </td>
                            <td class="px-6 py-4  whitespace-nowrap">{{ $lead->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $lead->company }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $lead->phone }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $lead->email ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $lead->source ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $lead->status ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $lead->owner->name ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('leads.show', $lead->id) }}" style="background-color: rgb(0, 200, 255)" class="rounded px-4 py-2 text-white">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-4">
                    {{ $leads->links() }}
                </div>
            </div>
        </form>
    </div>
</div>

<div id="massUpdateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-md p-6 rounded shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Mass Update Leads</h2>
        <form method="POST" action="{{ route('leads.massUpdate') }}">
            @csrf
            <input type="hidden" name="selected_leads" id="update_leads_input">

            <div class="mb-4">
                <label class="block font-medium mb-1">Update Status</label>
                <select name="status" class="w-full border px-3 py-2 rounded">
                    <option value="">Select Status</option>
                    <option value="new">New</option>
                    <option value="contacted">Contacted</option>
                    <option value="qualified">Qualified</option>

                </select>
            </div>
<div class="mb-4">
    <label class="block font-medium mb-1">Update Owner</label>
    <select name="owner_id" class="w-full border px-3 py-2 rounded">
        <option value="">Select Owner</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label class="block font-medium mb-1">Update Source</label>
    <input type="text" name="source" class="w-full border px-3 py-2 rounded" placeholder="Source (optional)">
</div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeMassUpdateModal()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-black rounded">Update</button>
            </div>
        </form>
    </div>
</div>

<div id="massConvertModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-md p-6 rounded shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Mass Convert Leads</h2>
        <form method="POST" action="{{ route('leads.massConvert') }}">
            @csrf
            <input type="hidden" name="selected_leads" id="convert_leads_input">

            <div class="mb-4">
                <label class="block font-medium mb-1">New Status</label>
                <select name="status" class="w-full border px-3 py-2 rounded" required>
                    <option value="converted">Converted</option>
                    <option value="qualified">Qualified</option>
                    <option value="contacted">Contacted</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">New Source</label>
                <input type="text" name="source" class="w-full border px-3 py-2 rounded" placeholder="Optional">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">New Owner</label>
                <select name="owner_id" class="w-full border px-3 py-2 rounded">
                    <option value="">Select Owner</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeMassConvertModal()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-black rounded">Convert</button>
            </div>
        </form>
    </div>
</div>
<div id="massEmailModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-md p-6 rounded shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Send Mass Email</h2>
        <form method="POST" action="{{ route('leads.massEmail') }}">
            @csrf
            <input type="hidden" name="selected_leads" id="email_leads_input">

            <div class="mb-4">
                <label class="block font-medium mb-1">Subject</label>
                <input type="text" name="subject" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Message</label>
                <textarea name="message" rows="4" class="w-full border px-3 py-2 rounded" required></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeMassEmailModal()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-black rounded">Send</button>
            </div>
        </form>
    </div>
</div>


<div id="assignTaskModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Assign Task to Leads</h2>
        <form method="POST" action="{{ route('tasks.assignToLeads') }}">
            @csrf
            <input type="hidden" name="lead_ids[]" id="selectedLeadIds">

            <div class="mb-3">
                <label class="block font-medium">Task Title</label>
                <input type="text" name="title" required class="w-full border px-3 py-2 rounded">
            </div>
            <div class="mb-3">
                <label class="block font-medium">Description</label>
                <textarea name="description" class="w-full border px-3 py-2 rounded"></textarea>
            </div>
            <div class="mb-3">
                <label class="block font-medium">Due Date</label>
                <input type="date" name="due_date" required class="w-full border px-3 py-2 rounded">
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeAssignTaskModal()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Assign</button>
            </div>
        </form>
    </div>
</div>


<script>
document.getElementById('mass-action-form').addEventListener('submit', function (e) {
    const selectedLeads = Array.from(document.querySelectorAll('input[name="selected_leads[]"]:checked')).map(cb => cb.value);
    const selectedAction = document.querySelector('select[name="action"]').value;

    if (selectedLeads.length === 0) {
        e.preventDefault();
        alert("Please select at least one lead.");
        return;
    }

    switch (selectedAction) {
        case 'update':
            e.preventDefault();
            document.getElementById('update_leads_input').value = JSON.stringify(selectedLeads);
            document.getElementById('massUpdateModal').classList.remove('hidden');
            break;

        case 'convert':
            e.preventDefault();
            document.getElementById('convert_leads_input').value = JSON.stringify(selectedLeads);
            document.getElementById('massConvertModal').classList.remove('hidden');
            break;

        case 'email':
            e.preventDefault();
            document.getElementById('email_leads_input').value = JSON.stringify(selectedLeads);
            document.getElementById('massEmailModal').classList.remove('hidden');
            break;

        case 'print':
            e.preventDefault();
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('leads.printView') }}";
            form.target = '_blank';

            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = '{{ csrf_token() }}';

            const leadsInput = document.createElement('input');
            leadsInput.type = 'hidden';
            leadsInput.name = 'selected_leads';
            leadsInput.value = JSON.stringify(selectedLeads);

            form.appendChild(token);
            form.appendChild(leadsInput);

            document.body.appendChild(form);
            form.submit();
            break;

        default:
            break;
    }
});

 function openAssignTaskModal() {
        const selected = [...document.querySelectorAll('input[name="selected_leads[]"]:checked')]
                        .map(cb => cb.value);
        if (!selected.length) {
            alert('Please select at least one lead.');
            return;
        }
        document.getElementById('selectedLeadIds').value = selected;
        document.getElementById('assignTaskModal').classList.remove('hidden');
    }

    function closeAssignTaskModal() {
        document.getElementById('assignTaskModal').classList.add('hidden');
    }

document.getElementById('select-all').addEventListener('change', function () {
    const checked = this.checked;
    document.querySelectorAll('input[name="selected_leads[]"]').forEach(cb => cb.checked = checked);
});

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}
window.closeMassUpdateModal = () => closeModal('massUpdateModal');
window.closeMassConvertModal = () => closeModal('massConvertModal');
window.closeMassEmailModal = () => closeModal('massEmailModal');
</script>
@endsection
