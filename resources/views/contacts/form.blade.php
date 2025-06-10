@php $contact = $contact ?? null; @endphp

<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" value="{{ old('name', $contact->name ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email', $contact->email ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Phone</label>
    <input type="text" name="phone" value="{{ old('phone', $contact->phone ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Company</label>
    <input type="text" name="company" value="{{ old('company', $contact->company ?? '') }}" class="form-control">
</div>
<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        @foreach(['New', 'Active', 'Inactive', 'Lost'] as $status)
            <option value="{{ $status }}" @selected(old('status', $contact->status ?? '') == $status)>
                {{ $status }}
            </option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label>Assign To</label>
    <select name="assigned_to" class="form-control">
        <option value="">-- Unassigned --</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" @selected(old('assigned_to', $contact->assigned_to ?? '') == $user->id)>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>
