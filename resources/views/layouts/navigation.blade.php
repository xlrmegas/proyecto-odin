<nav class="bg-black/80 border-b border-[#c5a059]/30 backdrop-blur-md relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-3">
                <div class="text-[#c5a059]">
                    <svg style="width: 32px; height: 32px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </div>
                <span style="font-family: 'Cinzel', serif; color: #c5a059; letter-spacing: 2px; font-size: 14px; font-weight: bold;">
                    EYE OF ODIN
                </span>
            </div>

            <div class="flex items-center gap-4">
                <span style="font-size: 10px; color: #888; text-transform: uppercase; letter-spacing: 1px;">
                    Vigía: {{ Auth::user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="color: #c5a059; font-size: 10px; font-weight: bold; border: 1px solid #c5a05944; padding: 5px 10px; text-transform: uppercase; cursor: pointer;">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>