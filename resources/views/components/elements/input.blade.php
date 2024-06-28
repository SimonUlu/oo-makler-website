<label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
<div class="mt-1">
    <input type="{{ $type ?? 'text' }}" name="{{ $name }}" id="{{ $name }}"
        placeholder="{{ $placeholder ?? '' }}" wire:model.defer='form.{{ $name }}'
        @if (isset($required)) required @endif
        class="block py-2 px-3 w-full border border-gray-200 shadow-sm focus:border-primary-600 focus:ring-primary-600">
</div>
@error('form.' . $name)
    <p class="text-red-600">{{ $message }}
    </p>
@enderror
