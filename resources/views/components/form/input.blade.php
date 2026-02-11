@props([
    'type' => 'text',
    'name' => null,
    'placeholder' => '',
    'icon' => null,
    'error' => null,
])

<div class="w-full">
    <div class="relative">
        @if($icon)
            <div class="absolute left-3 top-3 text-gray-400">
                {!! $icon !!}
            </div>
        @endif
        
        <input 
            type="{{ $type }}" 
            @if($name) name="{{ $name }}" @endif
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge([
                'class' => 'w-full pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red transition-all outline-none ' . 
                          ($icon ? 'pl-10' : 'pl-4') . 
                          ($error ? ' border-red-300 focus:border-red-500 focus:ring-red-200' : '')
            ]) }}
        >
    </div>
    
    @if($error)
        <p class="text-red-500 text-xs mt-1.5">{{ $error }}</p>
    @endif
</div>