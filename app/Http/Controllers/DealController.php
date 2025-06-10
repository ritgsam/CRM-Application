<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{
public function index(Request $request)
{
    $query = Deal::query();

    if ($request->start_date) {
        $query->whereDate('closing_date', '>=', $request->start_date);
    }

    if ($request->end_date) {
        $query->whereDate('closing_date', '<=', $request->end_date);
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $perPage = $request->input('per_page', 10);
    $deals = $query->latest()->paginate($perPage)->appends($request->except('page'));

    $users = User::all();

    return view('deals.index', compact('deals', 'users'));
}

public function create()
{
    $users = User::all();
    return view('deals.create', compact('users'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'deal_owner' => 'required|exists:users,id',
            'deal_name' => 'required|string|max:255',
            'account_name' => 'nullable|string|max:255',
            'amount' => 'nullable|numeric',
            'lead_source' => 'nullable|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'closing_date' => 'nullable|date',
            'status' => 'required|in:Open,Closed,Won,Lost',

        ]);

        $deal = new Deal();
        $deal->deal_owner = $validated['deal_owner'];
        $deal->deal_name = $validated['deal_name'];
        $deal->account_name = $validated['account_name'] ?? null;
        $deal->amount = $validated['amount'] ?? null;
        $deal->status = $validated['status'];
        $deal->lead_source = $validated['lead_source'] ?? null;
        $deal->contact_name = $validated['contact_name'] ?? null;
        $deal->description = $validated['description'] ?? null;
        $deal->closing_date = $validated['closing_date'] ?? null;
        $deal->save();

        return redirect()->route('deals.index', $deal->id)->with('success', 'Deal created successfully!');
    }

public function show(Deal $deal)
{
    return view('deals.show', compact('deal'));
}

public function createFromLead($leadId)
{
    $lead = Lead::findOrFail($leadId);
    $users = User::all();

    return view('deals.create', compact('lead', 'users'));
}

public function edit($id)
{
    $deal = Deal::findOrFail($id);
    $users = User::all();
    return view('deals.edit', compact('deal', 'users'));
}

public function bulkAction(Request $request)
{
    $action = $request->input('action');
    $dealIds = $request->input('selected_deals', []);

    if (empty($dealIds)) {
        return back()->with('error', 'No deals selected.');
    }

    switch ($action) {
        case 'assign_task':
            return redirect()->route('tasks.create', ['deals' => implode(',', $dealIds)]);

        case 'mass_delete':
            Deal::destroy($dealIds);
            return back()->with('success', 'Deals deleted successfully.');

        case 'mass_update':
            return redirect()->route('deals.mass.update.form')->with('dealIds', implode(',', $dealIds));

        case 'mass_email':
            return redirect()->route('deals.mass.email.form')->with('dealIds', implode(',', $dealIds));

        default:
            return back()->with('error', 'Invalid action selected.');
    }
}

public function massAction(Request $request)
{
    $action = $request->input('action');
    $dealIds = $request->input('selected_deals');

    if (!$dealIds || !is_array($dealIds)) {
        return back()->with('error', 'No deals selected.');
    }

    switch ($action) {
        case 'delete':
            Deal::whereIn('id', $dealIds)->delete();
            return back()->with('success', 'Selected deals deleted successfully.');

        case 'update':
            Deal::whereIn('id', $dealIds)->update(['status' => 'negotiation']);
            return back()->with('success', 'Selected deals updated successfully.');

        case 'convert':
            Deal::whereIn('id', $dealIds)->update(['status' => 'won']);
            return back()->with('success', 'Selected deals converted successfully.');

        case 'email':
            return back()->with('success', 'Mass email action initiated (not implemented).');

        case 'print':
            return back()->with('success', 'Mass print action triggered (not implemented).');

        default:
            return back()->with('error', 'Invalid action selected.');
    }
}
public function assignTask(Request $request)
{
    $request->validate([
        'selected_deals' => 'required|string',
        'task' => 'required|string',
        'due_date' => 'required|date',
        'assigned_to' => 'required|exists:users,id',
    ]);

    $dealIds = explode(',', $request->selected_deals);
    $task = $request->task;
    $dueDate = $request->due_date;
    $assignedTo = $request->assigned_to;

    foreach ($dealIds as $dealId) {
        \App\Models\Task::create([
            'deal_id' => $dealId,
            'subject' => $task,
            'due_date' => $dueDate,
            'task_owner_id' => $assignedTo,
            'created_by' => Auth::id(),
        ]);
    }

    return redirect()->route('tasks.index')->with('success', 'Tasks assigned successfully.');
}

  public function massUpdateForm()
    {
        $deals = Deal::all();
        return view('deals.mass_update_form', compact('deals'));
    }

    public function massUpdate(Request $request)
    {
        $dealIds = explode(',', $request->input('deal_ids', ''));
        $status = $request->input('status');

        Deal::whereIn('id', $dealIds)->update(['status' => $status]);

return redirect()->route('deals.index')->with('success', 'Deals updated successfully.');
    }

public function massEmail(Request $request)
{
    $dealIds = explode(',', $request->input('deal_ids'));
    $subject = $request->input('subject');
    $message = $request->input('message');

    $deals = Deal::whereIn('id', $dealIds)->get();

    foreach ($deals as $deal) {
        if ($deal->contact_email) {
            Mail::raw($message, function ($mail) use ($deal, $subject) {
                $mail->to($deal->contact_email)->subject($subject);
            });
        }
    }

    return redirect()->route('deals.index')->with('success', 'Emails sent successfully.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'deal_owner' => 'required|exists:users,id',
        'deal_name' => 'required|string|max:255',
        'account_name' => 'nullable|string|max:255',
        'amount' => 'nullable|numeric',
        'lead_source' => 'nullable|string',
        'contact_name' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'closing_date' => 'nullable|date',
    ]);

    $deal = Deal::findOrFail($id);
    $deal->update($request->all());

    return redirect()->route('deals.index')->with('success', 'Deal updated successfully!');
}

public function destroy(Deal $deal)
{
    $deal->delete();
    return redirect()->route('deals.index')->with('success', 'Deal deleted.');
}
}
