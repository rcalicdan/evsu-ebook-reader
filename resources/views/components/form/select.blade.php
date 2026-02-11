@props([
    'name' => null,
    'placeholder' => 'Select an option',
    'options' => [],
    'error' => null,
])

<div class="w-full">
    <select @if ($name) name="{{ $name }}" @endif
        {{ $attributes->merge([
            'class' =>
                'w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all ' .
                ($error ? 'border-red-300 focus:border-red-500 focus:ring-red-200' : ''),
        ]) }}>
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        {{ $slot }}
    </select>

    @if ($error)
        <p class="text-red-500 text-xs mt-1.5">{{ $error }}</p>
    @endif
</div>
