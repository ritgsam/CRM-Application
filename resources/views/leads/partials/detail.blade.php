<div class="space-y-4">

    <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $lead->name }}</h2>

    <div>
        <p><strong>Company:</strong> {{ $lead->company }}</p>
        <p><strong>Phone:</strong> {{ $lead->phone }}</p>
        <p><strong>Email:</strong> {{ $lead->email ?? 'N/A' }}</p>
        <p><strong>Source:</strong> {{ $lead->source ?? 'N/A' }}</p>
        <p><strong>Status:</strong> {{ $lead->status ?? 'N/A' }}</p>
        <p><strong>Owner:</strong> {{ $lead->owner->name ?? '—' }}</p>
    </div>

    <div>
        <h3 class="font-semibold">Timeline</h3>
        <ul class="list-disc ml-6 text-gray-600 text-sm">
            <li>Created at: {{ $lead->created_at->format('d M Y, H:i') }}</li>
            <li>Last updated: {{ $lead->updated_at->format('d M Y, H:i') }}</li>
        </ul>
    </div>

    <div class="flex gap-3 flex-wrap">
        <a href="{{ route('leads.edit', $lead) }}"
            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Edit</a>

        <form action="{{ route('leads.destroy', $lead) }}" method="POST"
            onsubmit="return confirm('Are you sure to delete this lead?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete</button>
        </form>

        <button id="print-lead-btn" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-800">
            Print
        </button>

        <button id="clone-lead-btn" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Clone
        </button>

        <button id="send-mail-btn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Send Email
        </button>
    </div>
</div>
