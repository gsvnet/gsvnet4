<li class="hover:border-l-[rgb(197,2,61)] hover:cursor-pointer border-l-2 border-l-transparent hover:bg-gradient-to-r hover:from-gsv-purple/80 hover:to-transparent w-full h-full pt-2 pb-2 mb-2 transition-all duration-300 ease-in">
    <a class="ml-4 flex flex-row justify-begin" href="{{ $link }}">
        {{ $slot }}
        <p class="mx-auto">
            {{ $title }}
        </p>
    </a>
</li>