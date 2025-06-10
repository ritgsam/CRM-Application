<?php


namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class ContactController extends Controller
{

public function index(Request $request)
{
    $query = Contact::with('owner');

    if ($request->first_name) {
        $query->where('first_name', 'like', '%' . $request->first_name . '%');
    }

    if ($request->email) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }

    if ($request->phone) {
        $query->where('phone', 'like', '%' . $request->phone . '%');
    }

    if ($request->contact_owner_id) {
        $query->where('contact_owner_id', $request->contact_owner_id);
    }

    $contacts = $query->latest()->paginate(10);
    $users = User::all();

    return view('contacts.index', compact('contacts', 'users'));
}

public function create()
{
    $users = User::all();
    return view('contacts.create', compact('users'));
}

   public function store(Request $request)
{
    $validated = $request->validate([
        'contact_owner_id' => 'nullable|exists:users,id',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'account_name' => 'nullable|string|max:255',
        'email' => 'nullable|email',
        'phone' => 'nullable|string|max:20',
        'other_phone' => 'nullable|string|max:20',
        'lead_source' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'dob' => 'nullable|date',
        'address' => 'nullable|string',
        'state' => 'nullable|string',
        'country' => 'nullable|string',
    ]);

    Contact::create($validated);

    return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
}

public function show($id)
{
    $contact = Contact::findOrFail($id);
    return view('contacts.show', compact('contact'));
}


 public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.edit', compact('contact'));
    }

   public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update($request->all());

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully!');
    }

    // public function update(Request $request, Contact $contact)
    // {
    //     $request->validate([
    //         'name' => 'required|string',
    //         'email' => 'required|email',
    //         'phone' => 'nullable|string',
    //         'assigned_to' => 'required|exists:users,id',
    //     ]);

    //     $contact->update($request->all());

    //     return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    // }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted.');
    }
}
