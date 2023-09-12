<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gsv-purple dark:bg-gsv-purple-dark border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest dark:hover:bg-gsv-purple-dark/60 dark:active:bg-gsv-purple-dark/90 hover:bg-gsv-purple-dark/80 active:bg-gsv-purple-dark/90 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
