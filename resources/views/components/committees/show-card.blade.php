<a href="/comissies/{{ $unique }}" class="group overflow-hidden block max-w-sm border-b border-gray-200 rounded-lg shadow-2xl hover:bg-white/50 dark:bg-[#36373a] bg-white/20 dark:border-gray-700 dark:hover:bg-white/20 h-36 hover:translate-y-1 transition-all duration-300 ease-in-out hover:border-b-transparent dark:hover:border-b-transparent">
    <div class="dark:bg-gsv-purple-dark/80 bg-gsv-purple/80 w-[100%] p-4  ">
        <h5 class="text-ellipsis overflow-hidden truncate text-md  tracking-tight text-white "> {{ $title }} </h5>
    </div>
    <p class="line-clamp-2 overflow-hidden px-2 pt-2 font-normal text-xs text-gray-700 dark:text-gray-400 "> {{ $description }} </p>
    <div class="w-full items-end justify-end text-right px-4 pt-4 text-gray-700 dark:text-gray-400 text-xs flex flex-row">
        <p class="text-xs"> Lees meer ></p> <p class="w-0 opacity-0 group-hover:opacity-100 group-hover:w-2 transition-all duration-300">>></p> 
    </div>
</a>

