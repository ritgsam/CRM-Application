<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Role;
use App\Models\User;
use App\Models\Account;
use App\Models\LeadTimeline;
use Illuminate\Support\Facades\Mail;
use App\Models\Deal;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;


class LeadController extends Controller
{
public function index(Request $request)
{
    $perPage = $request->input('per_page', 10);

    if (!in_array($perPage, [5, 10, 25, 50, 100])) {
        $perPage = 10;
    }

    $query = Lead::query();

    if ($request->start_date) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->end_date) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    if ($request->source) {
        $query->where('source', $request->source);
    }

    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    $leads = $query->with('owner')
                   ->latest()
                   ->paginate($perPage)
                   ->appends($request->all());

    $users = User::all();

    return view('leads.index', compact('leads', 'perPage', 'users'));
}
public function create(Request $request)
{
    $accounts = Account::all();
    $users = User::all();
    $leadStatuses = ['new', 'contacted', 'qualified'];
    $leadSources = ['website', 'cold call', 'email'];

    $cloneLead = null;
    if ($request->has('clone_id')) {
        $cloneLead = Lead::find($request->clone_id);
    }

    return view('leads.create', compact('accounts', 'users', 'leadStatuses', 'leadSources', 'cloneLead'));
}


public function store(Request $request)
{
    $validated = $request->validate([
        'account_id'      => 'nullable|exists:accounts,id',
        'title'           => 'nullable|string|max:50',
        'first_name'      => 'required|string|max:100',
        'second_name'     => 'nullable|string|max:100',
        'company'         => 'nullable|string|max:255',
        'email'           => 'required|email|max:255',
        'secondary_email' => 'nullable|email|max:255',
        'phone'           => 'nullable|string|max:20',
        'source'          => 'nullable|string|max:255',
        'lead_owner'      => 'nullable|exists:users,id',
        'status'          => 'nullable|string|max:100',
        'notes'           => 'nullable|string',
        'annual_revenue'  => 'nullable|numeric',
        'website'         => 'nullable|url|max:255',
        'employees'       => 'nullable|integer',
        'rating'          => 'nullable|string|max:50',
        'street'          => 'nullable|string|max:255',
        'city'            => 'nullable|string|max:100',
        'state'           => 'nullable|string|max:100',
        'country'         => 'nullable|string|max:100',
        'zip_code'        => 'nullable|string|max:20',
        'lead_image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('lead_image')) {
        $file = $request->file('lead_image');
        $path = $file->store('leads', 'public');
        $validated['lead_image'] = $path;
    }
    $validated['name'] = $request->first_name . ' ' . $request->second_name;

    Lead::create($validated);

    return redirect()->route('leads.index')->with('success', 'Lead created successfully!');
}

public function massConvert(Request $request)
{
    $request->validate([
        'selected_leads' => 'required',
        'status' => 'required|string',
        'source' => 'nullable|string',
        'owner_id' => 'nullable|exists:users,id',
    ]);

    $leadIds = json_decode($request->selected_leads, true);

    Lead::whereIn('id', $leadIds)->update([
        'status' => $request->status,
        'source' => $request->source,
        'owner_id' => $request->owner_id,
        'updated_at' => now(),
    ]);

    return redirect()->route('leads.index')->with('success', 'Selected leads converted successfully!');
}

public function massEmail(Request $request)
{
    $request->validate([
        'selected_leads' => 'required',
        'subject' => 'required|string',
        'message' => 'required|string',
    ]);

    $leadIds = json_decode($request->selected_leads, true);
    $leads = Lead::whereIn('id', $leadIds)->whereNotNull('email')->get();

    foreach ($leads as $lead) {
        Mail::raw($request->message, function ($message) use ($lead, $request) {
            $message->to($lead->email)
                ->subject($request->subject);
        });
    }

    return redirect()->route('leads.index')->with('success', 'Emails sent successfully!');
}
public function printView(Request $request)
{
    $query = Lead::query();

    if ($request->start_date) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->end_date) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    if ($request->source) {
        $query->where('source', $request->source);
    }

    $leads = $query->with('owner')->latest()->get();

    return view('leads.print-view', compact('leads'));
}


public function massAction(Request $request)
{
    $action = $request->input('action');
    $leadIds = $request->input('selected_leads');

    if (!$leadIds || !is_array($leadIds)) {
        return back()->with('error', 'No leads selected.');
    }

    switch ($action) {
        case 'delete':
            Lead::whereIn('id', $leadIds)->delete();
            return back()->with('success', 'Selected leads deleted successfully.');

        case 'update':
            Lead::whereIn('id', $leadIds)->update(['status' => 'contacted']);
            return back()->with('success', 'Selected leads updated successfully.');

        case 'convert':
            Lead::whereIn('id', $leadIds)->update(['status' => 'converted']);
            return back()->with('success', 'Selected leads converted successfully.');


        case 'email':
            return back()->with('success', 'Mass email action initiated (not implemented).');

case 'print':
    $leadIds = $request->input('selected_leads');
    $leads = Lead::whereIn('id', $leadIds)->get();

    require_once base_path('vendor/setasign/fpdf/fpdf.php');

    $pdf = new \FPDF();
    $pdf->AddPage();

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Leads Report', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(230, 230, 230);
    $pdf->Cell(40, 10, 'Name', 1, 0, 'C', true);
    $pdf->Cell(35, 10, 'Company', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Phone', 1, 0, 'C', true);
    $pdf->Cell(45, 10, 'Email', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Status', 1, 1, 'C', true);

    $pdf->SetFont('Arial', '', 11);
    foreach ($leads as $lead) {
        $pdf->Cell(40, 10, $lead->name, 1);
        $pdf->Cell(35, 10, $lead->company, 1);
        $pdf->Cell(30, 10, $lead->phone, 1);
        $pdf->Cell(45, 10, $lead->email ?? 'N/A', 1);
        $pdf->Cell(30, 10, ucfirst($lead->status), 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'leads_report.pdf');
    exit;


        default:
            return back()->with('error', 'Invalid action selected.');
    }
}

public function massUpdate(Request $request)
{
    $leadIds = json_decode($request->input('selected_leads'), true);
    $status = $request->input('status');
    $ownerId = $request->input('owner_id');
    $source = $request->input('source');

    if (!$leadIds || count($leadIds) === 0) {
        return redirect()->back()->with('error', 'Please select at least one lead.');
    }

    $updateData = [];

    if ($status) {
        $updateData['status'] = $status;
    }
    if ($ownerId) {
        $updateData['owner_id'] = $ownerId;
    }
    if ($source) {
        $updateData['source'] = $source;
    }

    if (!empty($updateData)) {
        Lead::whereIn('id', $leadIds)->update($updateData);
        return redirect()->route('leads.index')->with('success', 'Leads updated successfully.');
    }

    return redirect()->back()->with('error', 'No update fields selected.');
}

public function show(Lead $lead)
{
    $timeline = $lead->timeline()->orderBy('created_at', 'desc')->get();

    return view('leads.show', compact('lead', 'timeline'));
}

public function edit($id)
{
    $lead = Lead::findOrFail($id);

    $accounts = Account::all();
    $users = User::all();
    $leadSources = ['Web', 'Phone Inquiry', 'Partner', 'Public Relations', 'Direct Mail', 'Conference'];
    $leadStatuses = ['New', 'Contacted', 'Qualified', 'Lost', 'Converted'];

    return view('leads.edit', compact('lead', 'accounts', 'users', 'leadSources', 'leadStatuses'));
}

public function convert($id)
{
    $lead = Lead::findOrFail($id);

    $deal = new Deal();
    $deal->title = $lead->first_name . ' ' . $lead->second_name;
    $deal->email = $lead->email;
    $deal->phone = $lead->phone;
    $deal->company = $lead->company;
    $deal->status = 'Open';
    $deal->amount = $lead->annual_revenue ?? 0;
    $deal->source = $lead->source;
    $deal->lead_id = $lead->id;
    $deal->save();

    $lead->status = 'Converted';
    $lead->save();

    return redirect()->route('deals.show', $deal->id)->with('success', 'Lead converted to deal successfully.');
}


public function update(Request $request, Lead $lead)
{
    $request->validate([
        // 'name' => 'required',
    ]);

    $lead->update($request->all());

    return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
}

public function clone($id)
{
    $lead = Lead::findOrFail($id);
    $newLead = $lead->  replicate();
    $newLead->name = $lead->name . ' (Clone)';
    $newLead->created_at = now();
    $newLead->updated_at = now();
    $newLead->save();

    return redirect()->route('leads.edit', $newLead->id)
        ->with('success', 'Lead cloned successfully. You can now edit the details.');
}

public function sendEmail(Request $request, $id)
{
    $lead = Lead::findOrFail($id);

    Mail::to($lead->email)->send(new \App\Mail\LeadNotification($lead));

    return redirect()->route('leads.show', $lead->id)
        ->with('success', 'Email sent successfully to the lead.');
}

public function destroy(Lead $lead)
{
    $lead->delete();
    return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
}
}
