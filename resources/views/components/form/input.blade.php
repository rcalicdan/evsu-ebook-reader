@props([
    'type' => 'text',
    'name' => null,
    'placeholder' => '',
    'icon' => null,
    'toggleIcon' => null,
    'error' => null,
])

<div class="w-full" {{ $attributes->only('x-data') }}>
    <div class="relative">
        @if ($icon)
            <div class="absolute left-3 top-3 text-gray-400">
                {!! $icon !!}
            </div>
        @endif

        <input :type="show ? 'text' : '{{ $type }}'" @if ($name) name="{{ $name }}" @endif
            placeholder="{{ $placeholder }}"
            {{ $attributes->except(['x-data'])->merge([
                'class' =>
                    'w-full py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red transition-all outline-none ' .
                    ($icon ? 'pl-10' : 'pl-4') .
                    ($toggleIcon ? ' pr-10' : 'pr-4') .
                    ($error ? ' border-red-300 focus:border-red-500 focus:ring-red-200' : ''),
            ]) }}>

        @if ($toggleIcon)
            <div class="absolute right-3 top-3">
                {!! $toggleIcon !!}
            </div>
        @endif
    </div>

    @if ($error)
        <p class="text-red-500 text-xs mt-1.5">{{ $error }}</p>
    @endif
</div>