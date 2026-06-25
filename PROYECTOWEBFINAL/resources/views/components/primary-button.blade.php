<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-accent-500 to-accent-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:from-accent-600 hover:to-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-400 focus:ring-offset-2 transition shadow-md hover:shadow-lg active:scale-[0.98]']) }}>
    {{ $slot }}
</button>
