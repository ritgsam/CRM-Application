<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Deal;
use Illuminate\Support\Str;

class TaskController extends Controller
{
public function index(Request $request)
{
    $query = Task::query()->with(['owner', 'contact']);

    if ($request->filled('owner_id')) {
        $query->where('owner_id', $request->owner_id);
    }
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    if ($request->filled('priority')) {
        $query->where('priority', $request->priority);
    }
    if ($request->filled('contact_name')) {
        $query->whereHas('contact', function ($q) use ($request) {
            $q->where('first_name', 'like', '%' . $request->contact_name . '%');
        });
    }

    $perPage = $request->get('per_page', 10);
    $tasks = $query->latest()->paginate($perPage);

    $users = User::select('id', 'name')->get();

    return view('tasks.index', compact('tasks', 'users', 'perPage'));
}


public function create()
{
    $deals = Deal::all();
    $users = User::all();

    return view('tasks.create', compact('deals', 'users'));
}

public function store(Request $request)
{
    $request->validate([
        'subject' => 'required|string|max:255',
        'due_date' => 'required|date',
        'task_owner_id' => 'required|exists:users,id',
        'status' => 'required|string',
        'priority' => 'required|string',
        'deal_id' => 'nullable|exists:deals,id',
        'description' => 'nullable|string',
    ]);

    Task::create($request->all());

    return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
}

public function edit($id)
{
    $task = Task::findOrFail($id);
    $users = User::all();
    $deals = Deal::all();
 $contacts = Contact::all();
    return view('tasks.edit', compact('task', 'users', 'deals', 'contacts'));
}

public function massUpdate(Request $request)
{
    $request->validate([
        'task_ids' => 'required|string',
        'status' => 'required|string',
    ]);

    $ids = explode(',', $request->task_ids);
    Task::whereIn('id', $ids)->update(['status' => $request->status]);

    return redirect()->route('tasks.index')->with('success', 'Selected tasks updated.');
}

public function massAction(Request $request)
{
    $request->validate([
        'task_ids' => 'required|array',
        'action' => 'required|string',
    ]);

    if ($request->action === 'delete') {
        Task::whereIn('id', $request->task_ids)->delete();
        return redirect()->route('tasks.index')->with('success', 'Selected tasks deleted.');
    }

    return redirect()->route('tasks.index')->with('error', 'Invalid action selected.');
}

public function massDelete(Request $request)
{
    $request->validate([
        'task_ids' => 'required|array',
    ]);

    Task::whereIn('id', $request->task_ids)->delete();

    return redirect()->route('tasks.index')->with('success', 'Tasks deleted successfully.');
}

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'task_owner_id' => 'required',
            'subject' => 'required',
            'due_date' => 'required|date',
            'status' => 'required',
            'priority' => 'required',
        ]);

        $task->update($request->all());
        return redirect()->route('tasks.index')->with('success', 'Task updated!');
    }

public function assignToLeads(Request $request)
{
    $request->validate([
        'lead_ids' => 'required|array',
        'title' => 'required|string|max:255',
        'due_date' => 'required|date',
    ]);

    foreach ($request->lead_ids as $leadId) {
        \App\Models\Task::create([
            'lead_id' => $leadId,
            'title' => $request->title,
            'description' => $request->description ?? '',
            'due_date' => $request->due_date,
            'status' => 'pending',
            'assigned_by' => auth()->id,
        ]);
    }

    return redirect()->route('leads.index')->with('success', 'Tasks assigned to selected leads successfully.');
}

    public function destroy(Task $task)
    {
        $task->delete();
        return back()->with('success', 'Task deleted!');
    }
}
