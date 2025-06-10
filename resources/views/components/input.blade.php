@props(['label', 'name', 'type' => 'text', 'value' => ''])

<div>
    <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}"
           class="w-full border-gray-300 rounded-md shadow-sm mt-1">
</div>
