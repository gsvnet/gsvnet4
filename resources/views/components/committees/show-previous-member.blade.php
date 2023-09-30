
<a href="/{{ $member->id }}" class="border-b hover:bg-white/50 dark:bg-[#36373a] bg-white/20 hover:translate-y-1 transition-all duration-300 ease-in-out border-t border-gsv-purple/60 px-2 py-2 rounded-b-sm dark:shadow-white/10 shadow-lg dark:shadow-sm" href="/">
    <div class="rounded-full mx-auto w-[80%] overflow-hidden aspect-square">
        <img src="{{ asset('/images/JorisInfoA.jpg') }}" alt="Profielfoto" class="object-cover h-full aspect-auto" />
    </div>
    <div>
        <p class="text-center text-sm text-ellipsis overflow-hidden">
            {{ $member->present()->firstname}}
        </p>
        <p class="text-center font-serif italic text-xs lowercase pt-1">
            tot {{ $member->present()->outCommiteeSince }}
        </p>
    </div>
</a>