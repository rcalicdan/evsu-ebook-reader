@props([
    'type' => 'text',
    'name' => null,
    'placeholder' => '',
    'icon' => null,
])

@php
    $wireModel = $attributes->whereStartsWith('wire:model')->first();
    $fieldName = $wireModel ? str_replace(['wire:model=', 'wire:model.defer=', 'wire:model.live=', '"', "'"], '', $wireModel) : null;
@endphp

<div class="w-full">
    <div class="relative">
        @if ($icon)
            <div class="absolute left-3 top-3 text-gray-400">
                {!! $icon !!}
            </div>
        @endif

        <input type="{{ $type }}" 
            @if ($name) name="{{ $name }}" @endif
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge([
                'class' =>
                    'w-full pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red transition-all outline-none ' .
                    ($icon ? 'pl-10' : 'pl-4'),
            ]) }}
            @if($fieldName) @class(['border-red-300 focus:border-red-500 focus:ring-red-200' => $errors->has($fieldName)]) @endif>
    </div>

    @if($fieldName)
        @error($fieldName)
            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
        @enderror
    @endif
</div>