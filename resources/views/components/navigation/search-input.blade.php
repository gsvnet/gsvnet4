<form class="mx-auto md:pl-52">
        <div class="flex max-w-md mx-auto pt-4 pb-4">
            <label for="search-dropdown" class="mb-2 text-sm font-medium text-white sr-only">Zoek</label>
            <button id="dropdown-button" data-dropdown-toggle="dropdown" class="flex-shrink-0 z-10 inline-flex items-center px-4 text-xs font-medium text-center dark:text-white text-black dark:bg-[#202124] bg-[#d0d5d6] border border-white/70 dark:border-[#3d3e44] rounded-l-lg dark:hover:bg-[#36383d] hover:bg-white/70 focus:outline-none dark:focus:ring-gsv-purple-dark focus:ring-gsv-purple focus:ring-2 focus:border-gsv-purple dark:focus:border-gsv-purple-dark ease-linear duration-200 transition-all" type="button">Zoekgebied <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg></button>
            <div id="dropdown" class="fixed top-4 z-10 hidden bg-[#d0d5d6] dark:bg-[#161616] divide-y divide-[#3d3e44] rounded-lg shadow w-44">
                <ul class="py-2 text-xs text-black/80 dark:text-white/80" aria-labelledby="dropdown-button">
                    <x-navigation.search-input-option name="Eerste bericht + Topic-naam" /> 
                    <x-navigation.search-input-option name="Alle berichten" /> 
                    <x-navigation.search-input-option name="Leden" /> 
                </ul>
            </div>
            <div class="relative w-full">
                <input type="search" id="search-dropdown" class="block w-full z-20 text-sm text-white bg-[#d0d5d6] dark:bg-[#202124] rounded-r-lg border-l-white/70 dark:border-l-[#26272b] border-l-2 border border-white/70 dark:border-[#3d3e44] dark:focus:ring-gsv-purple-dark focus:ring-gsv-purple focus:ring-2 hover:cursor-text dark:hover:bg-[#36383d] hover:bg-white/70 dark:hover:border-l-[#36383d] focus:border-transparent dark:focus:border-l-gsv-purple-dark focus:border-l-gsv-purple ease-linear duration-75 transition-all" placeholder="Zoek..." required>
                <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium h-full text-white bg-transparent rounded-r-lg hover:gsv-purple-dark focus:ring-4 focus:outline-none focus:ring-transparent hover:scale-90 ease-linear duration-75 transition-all">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Zoek</span>
                </button>
            </div>
        </div>
    </form>