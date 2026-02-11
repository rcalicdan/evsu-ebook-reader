@props([
    'name' => null,
    'placeholder' => '',
    'rows' => 4,
    'error' => null,
])

<div class="w-full">
    <textarea @if ($name) name="{{ $name }}" @endif rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' =>
                'w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red transition-all outline-none resize-none ' .
                ($error ? 'border-red-300 focus:border-red-500 focus:ring-red-200' : ''),
        ]) }}>{{ $slot }}</textarea>

    @if ($error)
        <p class="text-red-500 text-xs mt-1.5">{{ $error }}</p>
    @endif
</div>
