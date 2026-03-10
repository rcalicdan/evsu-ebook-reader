<div>
    @if ($this->count > 0)
        <span x-show="!sidebarCollapsed"
            class="absolute -top-1 -right-1 bg-white text-university-red text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-md">
            {{ $this->count > 99 ? '99+' : $this->count }}
        </span>
    @endif
</div>
