@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Create Task</h2>

    <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label>Task Owner</label>
            <select name="task_owner_id" class="w-full border rounded px-3 py-2">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Subject</label>
            <input name="subject" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label>Due Date</label>
            <input type="date" name="due_date" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label>Contact</label>
            <select name="contact_id" class="w-full border rounded px-3 py-2">
                <option value="">-- None --</option>
                @foreach($contacts as $contact)
                    <option value="{{ $contact->id }}">{{ $contact->first_name }} {{ $contact->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option>Not Started</option>
                <option>In Process</option>
                <option>Completed</option>
            </select>
        </div>

        <div>
            <label>Priority</label>
            <select name="priority" class="w-full border rounded px-3 py-2">
                <option>Normal</option>
                <option>High</option>
                <option>Low</option>
            </select>
        </div>

        <div>
            <label>Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <div>
            <button class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection
