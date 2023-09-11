<div class="fixed top-0 bg-[#161616] w-full">
    <form>
        <div class="flex max-w-md mx-auto pt-4 pb-4">
            <label for="search-dropdown" class="mb-2 text-sm font-medium text-white sr-only ">Zoek</label>
            <button id="dropdown-button" data-dropdown-toggle="dropdown" class="flex-shrink-0 z-10 inline-flex items-center px-4 text-xs font-medium text-center text-white bg-[#202124] border border-[#3d3e44] rounded-l-lg hover:bg-[#36383d] focus:outline-none focus:ring-gsv-purple-dark focus:ring-2 focus:border-gsv-purple-dark ease-linear duration-75 transition-all" type="button">All categories <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg></button>
                <div id="dropdown" class="z-10 hidden bg-[#161616] divide-y divide-[#3d3e44] rounded-lg shadow w-44 ">
                    <ul class="py-2 text-sm text-white/80" aria-labelledby="dropdown-button">
                    <li>
                        <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-[#4e5158] ">Eerste bericht + Topic-naam</button>
                    </li>
                    <li>
                        <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-[#4e5158] ">Alle berichten</button>
                    </li>
                    <li>
                        <button type="button" class="inline-flex w-full px-4 py-2 hover:bg-[#4e5158] ">Leden</button>
                    </li>
                    </ul>
                </div>
                <div class="relative w-full">
                    <input type="search" id="search-dropdown" class="block w-full z-20 text-sm text-white bg-[#202124]  rounded-r-lg border-l-[#26272b] border-l-2 border border-[#3d3e44] focus:ring-gsv-purple-dark focus:ring-2 hover:cursor-text hover:bg-[#36383d] hover:border-l-[#36383d] focus:border-transparent focus:border-l-gsv-purple-dark  ease-linear duration-75 transition-all" placeholder="Zoek..." required>
                    <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium h-full text-white bg-transparent rounded-r-lg hover:gsv-purple-dark focus:ring-4 focus:outline-none focus:ring-transparent hover:scale-90 ease-linear duration-75 transition-all">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                        <span class="sr-only">Zoek</span>
                </button>
            </div>
        </div>
    </form>
</div>
