<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AccountController extends Controller
{
    public function index(Request $request)
    {
        $query = Account::with('owner');

        if ($request->has('owner_id') && $request->owner_id != '') {
            $query->where('owner_id', $request->owner_id);
        }

        $accounts = $query->paginate(10);
        $owners = User::all();
        return view('accounts.index', compact('accounts', 'owners'));
    }

public function edit(Account $account)
{
    $owners = User::all();
    return view('accounts.edit', compact('account', 'owners'));
}

    public function create()
    {
        $owners = User::all();
        return view('accounts.create', compact('owners'));
    }

    public function store(Request $request)
    {
// dd($request->all());
        $validated = $request->validate([
            'owner_id' => 'required|exists:users,id',
            'account_name' => 'required|string|max:255',
            'account_site' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'account_type' => 'nullable|in:Customer,Distributor,Partner,Vendor,Other',
            'annual_revenue' => 'nullable|numeric',
            'phone' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'ownership' => 'nullable|in:Other,Private,Public,Partnership,Government',
            'employees' => 'nullable|integer',
            'billing_street' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:100',
            'billing_state' => 'nullable|string|max:100',
            'billing_code' => 'nullable|string|max:20',
            'billing_country' => 'nullable|string|max:100',
            'shipping_street' => 'nullable|string|max:255',
            'shipping_city' => 'nullable|string|max:100',
            'shipping_state' => 'nullable|string|max:100',
            'shipping_code' => 'nullable|string|max:20',
            'shipping_country' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        Account::create($validated);
// dd($request->all());

        return redirect()->route('accounts.index')->with('success', 'Account created successfully.');
    }

    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        $validated = $request->validate([
            'owner_id' => 'required|exists:users,id',
            'account_name' => 'required|string|max:255',
            'account_site' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'account_type' => 'nullable|in:Customer,Distributor,Partner,Vendor,Other',
            'annual_revenue' => 'nullable|numeric',
            'phone' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'ownership' => 'nullable|in:Other,Private,Public,Partnership,Government',
            'employees' => 'nullable|integer',
            'billing_street' => 'nullable|string|max:255',
            'billing_city' => 'nullable|string|max:100',
            'billing_state' => 'nullable|string|max:100',
            'billing_code' => 'nullable|string|max:20',
            'billing_country' => 'nullable|string|max:100',
            'shipping_street' => 'nullable|string|max:255',
            'shipping_city' => 'nullable|string|max:100',
            'shipping_state' => 'nullable|string|max:100',
            'shipping_code' => 'nullable|string|max:20',
            'shipping_country' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $account->update($validated);
        return redirect()->route('accounts.index')->with('success', 'Account updated successfully.');
    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'Account deleted successfully.');
    }
}
