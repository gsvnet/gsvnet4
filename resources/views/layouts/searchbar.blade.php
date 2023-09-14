<div class="fixed top-0 dark:bg-[#161616] bg-[#d9e0e1] w-full flex flex-row">
    <form class="mx-auto">
        <div class="flex max-w-md mx-auto pt-4 pb-4">
            <label for="search-dropdown" class="mb-2 text-sm font-medium text-white sr-only">Zoek</label>
            <button id="dropdown-button" data-dropdown-toggle="dropdown" class="flex-shrink-0 z-10 inline-flex items-center px-4 text-xs font-medium text-center dark:text-white text-black dark:bg-[#202124] bg-[#d0d5d6] border border-white/70 dark:border-[#3d3e44] rounded-l-lg dark:hover:bg-[#36383d] hover:bg-white/70 focus:outline-none dark:focus:ring-gsv-purple-dark focus:ring-gsv-purple focus:ring-2 focus:border-gsv-purple dark:focus:border-gsv-purple-dark ease-linear duration-75 transition-all" type="button">Zoekgebied <svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg></button>
            <div id="dropdown" class="fixed top-4 z-10 hidden bg-[#d0d5d6] dark:bg-[#161616] divide-y divide-[#3d3e44] rounded-lg shadow w-44">
                <ul class="py-2 text-xs text-black/80 dark:text-white/80" aria-labelledby="dropdown-button">
                    <li>
                        <button type="button" class="dropdown-option inline-flex w-full px-4 py-2 dark:hover:bg-[#4e5158] hover:bg-white/70 ">Eerste bericht + Topic-naam</button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-option inline-flex w-full px-4 py-2 dark:hover:bg-[#4e5158] hover:bg-white/70 ">Alle berichten</button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-option inline-flex w-full px-4 py-2 dark:hover:bg-[#4e5158] hover:bg-white/70 ">Leden</button>
                    </li>
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

    <div class="right-0 mr-4 my-auto">
        <button type="button" x-bind:class="darkMode ? 'bg-gsv-purple-dark' : 'bg-gsv-purple'"
            x-on:click="darkMode = !darkMode"
            class="relative hover:border-white border-transparent inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:gsv-purple-dark focus:ring-offset-2"
            role="switch" aria-checked="false">
            <span class="sr-only">Dark mode toggle</span>
            <span x-bind:class="darkMode ? 'translate-x-5 bg-gray-700': 'translate-x-0 bg-white'"
                class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full shadow ring-0 transition duration-200 ease-in-out">
                <span
                    x-bind:class="darkMode ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200'"
                    class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
                    aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                    </svg>
                </span>
                <span
                    x-bind:class="darkMode ?  'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100'"
                    class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"
                    aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
            </span>
        </button>
    </div>
</div>

<script>
    const dropdownButton = document.getElementById("dropdown-button");
    const dropdown = document.getElementById("dropdown");
    const dropdownOptions = document.querySelectorAll('.dropdown-option');

    dropdownButton.addEventListener("click", function () {
        dropdown.classList.toggle("hidden");
    });

    dropdownOptions.forEach(option => {
        option.addEventListener('click', function () {
            const selectedText = option.textContent.trim();
            
            dropdownButton.textContent = `${selectedText}`;

            dropdown.classList.add('hidden');
        });
    });

</script>