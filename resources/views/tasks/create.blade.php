@extends('layouts.app')

@section('content')
<div  class=" bg-gray-200 max-w-7xl mx-auto mt-8 p-6 shadow rounded-lg">

    <h2 class="text-xl font-semibold bg-[#2e2e2e] text-black px-4 py-2 rounded-t-md mb-6">Add New Task</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

            <div>
                <label for="deal_id" class="block text-sm font-medium text-gray-700">Deal</label>
                <select name="deal_id" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                    <option value="">-- Select Deal --</option>
                    @foreach($deals as $deal)
                        <option value="{{ $deal->id }}">{{ $deal->title }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                <input type="text" name="subject" id="subject" class="w-full border-gray-300 rounded-md shadow-sm mt-1" required>
            </div>

            <div>
                <label for="task_owner_id" class="block text-sm font-medium text-gray-700">Assign To</label>
                <select name="task_owner_id" id="task_owner_id" required class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm mt-1">
                    <option value="Not Started">Not Started</option>
                    <option value="In Process">In Process</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                <select name="priority" id="priority" class="w-full border-gray-300 rounded-md shadow-sm mt-1" required>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </div>

            <div>
                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                <input type="date" name="due_date" id="due_date" class="w-full border-gray-300 rounded-md shadow-sm mt-1" required>
            </div>

            <div class="col-span-full">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm mt-1"></textarea>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <a href="{{ route('tasks.index') }}" style="background-color: red" class="mr-4 px-4 py-1 rounded text-white hover:underline ">Cancel</a>
            <button type="submit" style="background-color: rgb(0, 200, 255)" class="bg-[#444] text-white px-4 py-1 rounded hover:bg-[#333] ml-4 ">Save Task</button>
        </div>
    </form>
</div>
@endsection
