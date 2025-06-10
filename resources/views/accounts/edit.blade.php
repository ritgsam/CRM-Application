@extends('layouts.app')

@section('content')
<div class="bg-[#e4d0d3] min-h-screen p-6">
    <div class="max-w-5xl mx-auto bg-gray-200 p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-6">Edit Account</h2>

        <form method="POST" action="{{ route('accounts.update', $account->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Account Owner</label>
                    <select name="owner_id" class="w-full mt-1 border-gray-300 rounded">
                        @foreach($owners as $owner)
                            <option value="{{ $owner->id }}" {{ $account->owner_id == $owner->id ? 'selected' : '' }}>{{ $owner->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Account Name</label>
                    <input type="text" name="account_name" value="{{ $account->account_name }}" class="w-full mt-1 border-gray-300 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Account Site</label>
                    <input type="text" name="account_site" value="{{ $account->account_site }}" class="w-full mt-1 border-gray-300 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Account Number</label>
                    <input type="text" name="account_number" value="{{ $account->account_number }}" class="w-full mt-1 border-gray-300 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Account Type</label>
                    <select name="account_type" class="w-full mt-1 border-gray-300 rounded">
                        <option value="">Select</option>
                        @foreach(['Customer','Distributor','Partner','Vendor','Other'] as $type)
                            <option value="{{ $type }}" {{ $account->account_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Annual Revenue</label>
                    <input type="number" step="0.01" name="annual_revenue" value="{{ $account->annual_revenue }}" class="w-full mt-1 border-gray-300 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" value="{{ $account->phone }}" class="w-full mt-1 border-gray-300 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Fax</label>
                    <input type="text" name="fax" value="{{ $account->fax }}" class="w-full mt-1 border-gray-300 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Website</label>
                    <input type="text" name="website" value="{{ $account->website }}" class="w-full mt-1 border-gray-300 rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Ownership</label>
                    <select name="ownership" class="w-full mt-1 border-gray-300 rounded">
                        @foreach(['Other','Private','Public','Partnership','Government'] as $own)
                            <option value="{{ $own }}" {{ $account->ownership == $own ? 'selected' : '' }}>{{ $own }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Employees</label>
                    <input type="number" name="employees" value="{{ $account->employees }}" class="w-full mt-1 border-gray-300 rounded">
                </div>
            </div>

            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-2">Billing Address</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="billing_street" placeholder="Street" value="{{ $account->billing_street }}" class="border-gray-300 rounded w-full">
                    <input type="text" name="billing_city" placeholder="City" value="{{ $account->billing_city }}" class="border-gray-300 rounded w-full">
                    <input type="text" name="billing_state" placeholder="State" value="{{ $account->billing_state }}" class="border-gray-300 rounded w-full">
                    <input type="text" name="billing_code" placeholder="Zip Code" value="{{ $account->billing_code }}" class="border-gray-300 rounded w-full">
                    <input type="text" name="billing_country" placeholder="Country" value="{{ $account->billing_country }}" class="border-gray-300 rounded w-full">
                </div>
            </div>

            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-2">Shipping Address</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="shipping_street" placeholder="Street" value="{{ $account->shipping_street }}" class="border-gray-300 rounded w-full">
                    <input type="text" name="shipping_city" placeholder="City" value="{{ $account->shipping_city }}" class="border-gray-300 rounded w-full">
                    <input type="text" name="shipping_state" placeholder="State" value="{{ $account->shipping_state }}" class="border-gray-300 rounded w-full">
                    <input type="text" name="shipping_code" placeholder="Zip Code" value="{{ $account->shipping_code }}" class="border-gray-300 rounded w-full">
                    <input type="text" name="shipping_country" placeholder="Country" value="{{ $account->shipping_country }}" class="border-gray-300 rounded w-full">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="3" class="w-full mt-1 border-gray-300 rounded">{{ $account->description }}</textarea>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('accounts.index') }}" style="background-color: red"  class="mr-4 px-4 py-1 rounded text-white hover:underline">Cancel</a>
                <button type="submit" style="background-color: red"  class="mr-4 px-4 py-1 rounded text-white hover:underline">Update Account</button>
            </div>
        </form>
    </div>
</div>
@endsection
