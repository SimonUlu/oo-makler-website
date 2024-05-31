<div class="relative flex items-start">
    <div class="flex grid content-center h-6">
        <label for="{{ $name }}">
            <input id="{{ $name }}" aria-describedby="{{ $name }}-description" name="{{ $name }}"
                type="checkbox" wire:model='form.{{ $name }}'
                class="w-4 h-4 border-gray-300 text-primary-600 focus:ring-primary-600">
        </label>
    </div>
    <div class="flex-1 min-w-0 ml-3">
        <label for="{{ $name }}">
            <p id="{{ $name }}-description" class="text-sm text-gray-500">{{ $slot }}</p>
        </label>
    </div>
</div>
@error('form.' . $name)
    <p class="text-red-600">{{ $message }}
    </p>
@enderror
