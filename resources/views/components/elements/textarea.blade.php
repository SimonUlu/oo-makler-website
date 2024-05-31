<label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
<div class="mt-1">
    <textarea id="{{ $name }}" name="{{ $name }}" wire:model.live='form.{{ $name }}' rows="3"
        class="py-2 px-3 w-full rounded-md border border-gray-200 shadow-sm focus:border-primary-600 focus:ring-primary-600">{{ $slot }}</textarea>
</div>
@error('form.' . $name)
    <p class="error-message">{{ $message }}
    </p>
@enderror
