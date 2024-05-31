<label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
<select id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}" required
    class="block w-full py-3 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md sm:text-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none">
    @foreach ($options as $key => $option)
        <option value="{{ $option }}">{{ $option }}</option>
    @endforeach
</select>
@error('{{ $name }}')
    <p class="error-message">{{ $message }}
    </p>
@enderror
