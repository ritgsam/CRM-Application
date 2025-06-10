@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-8 p-6 bg-gray-200 shadow rounded-lg">
    <h2 class="text-2xl font-semibold mb-6">Create New Account</h2>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('accounts.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-medium">Account Owner</label>
                <select name="owner_id" class="w-full border-gray-300 rounded mt-1">
                    @foreach($owners as $owner)
                        <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium">Account Name</label>
                <input type="text" name="account_name" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <div>
                <label class="block font-medium">Account Site</label>
                <input type="text" name="account_site" class="w-full border-gray-300 rounded mt-1">
            </div>

            <div>
                <label class="block font-medium">Account Number</label>
                <input type="text" name="account_number" class="w-full border-gray-300 rounded mt-1">
            </div>

            <div>
                <label class="block font-medium">Account Type</label>
                <select name="account_type" class="w-full border-gray-300 rounded mt-1">
                    <option value="Customer">Customer</option>
                    <option value="Distributor">Distributor</option>
                    <option value="Partner">Partner</option>
                    <option value="Vendor">Vendor</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Annual Revenue</label>
                <input type="text" name="annual_revenue" class="w-full border-gray-300 rounded mt-1">
            </div>

            <div>
                <label class="block font-medium">Phone</label>
                <input type="text" name="phone" class="w-full border-gray-300 rounded mt-1">
            </div>

            <div>
                <label class="block font-medium">Fax</label>
                <input type="text" name="fax" class="w-full border-gray-300 rounded mt-1">
            </div>

            <div>
                <label class="block font-medium">Website</label>
                <input type="text" name="website" class="w-full border-gray-300 rounded mt-1">
            </div>

            <div>
                <label class="block font-medium">Ownership</label>
                <select name="ownership" class="w-full border-gray-300 rounded mt-1">
                    <option value="Other">Other</option>
                    <option value="Private">Private</option>
                    <option value="Public">Public</option>
                    <option value="Partnership">Partnership</option>
                    <option value="Government">Government</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Employees</label>
                <input type="number" name="employees" class="w-full border-gray-300 rounded mt-1">
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-2">Billing Address</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="billing_street" placeholder="Street" class="w-full border-gray-300 rounded">
                <input type="text" name="billing_city" placeholder="City" class="w-full border-gray-300 rounded">
                <input type="text" name="billing_state" placeholder="State" class="w-full border-gray-300 rounded">
                <input type="text" name="billing_code" placeholder="Zip/Postal Code" class="w-full border-gray-300 rounded">
                <input type="text" name="billing_country" placeholder="Country" class="w-full border-gray-300 rounded">
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-2">Shipping Address</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="shipping_street" placeholder="Street" class="w-full border-gray-300 rounded">
                <input type="text" name="shipping_city" placeholder="City" class="w-full border-gray-300 rounded">
                <input type="text" name="shipping_state" placeholder="State" class="w-full border-gray-300 rounded">
                <input type="text" name="shipping_code" placeholder="Zip/Postal Code" class="w-full border-gray-300 rounded">
                <input type="text" name="shipping_country" placeholder="Country" class="w-full border-gray-300 rounded">
            </div>
        </div>

        <div class="mt-8">
            <label class="block font-medium">Description</label>
            <textarea name="description" rows="4" class="w-full border-gray-300 rounded mt-1"></textarea>
        </div>

        <div class="flex justify-end mt-6">
            <a href="{{ route('accounts.index') }}" style="background-color: red" class="mr-4 px-4 py-1 rounded text-white hover:underline ">Cancel</a>
            <button type="submit" style="background-color: rgb(0, 200, 255)" class="bg-[#444] text-white px-4 py-1 rounded hover:bg-[#333] ml-4 ">Save Account</button>
        </div>
    </form>
</div>
@endsection
