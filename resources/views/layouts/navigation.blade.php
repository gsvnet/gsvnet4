<div class="fixed top-0 dark:bg-[#161616] bg-[#d9e0e1] min-h-screen w-52 flex-col pt-6">
    <div class="dark:text-white text-black mx-auto flex-row">
        <img src="{{ asset('/images/Logo-GSV-klein-icon.png') }}" alt="Logo GSV" class="mx-auto" x-bind:class="darkMode ? 'h-12 w-12'  : 'h-0 w-0'" />
        <img src="{{ asset('/images/Logo-GSV-klein-icon-zwart.png') }}" alt="Logo GSV" class="mx-auto" x-bind:class="darkMode ? 'h-0 w-0' : 'h-12 w-12'" />
    </div>

    <div class="text-black dark:text-white pt-6 mt-6 dark:bg-[#202124] bg-[#d0d5d6] rounded-2xl ml-3 mr-3 pl-3 pr-3 pb-6">
        <div class="rounded-full mx-auto h-24 w-24 overflow-hidden border-2 border-gsv-purple">
            <img src="{{ asset('/images/JorisInfoA.jpg') }}" alt="Profielfoto" class="object-cover h-full aspect-auto" />
        </div>

        <p class="mx-auto text-center pt-6 font-semibold">
            @auth
                {{ $user->present()->fullname }}
            @endauth
        </p>
        <div class="mx-auto text-center text-sm italic flex flex-row items-center justify-center">
            <p>
                @auth
                    {{ $user->profile->present()->yearGroupName }}
                @endauth
            </p>
            <p class="text-gsv-purple ml-2">
                @auth
                    • {{ $user->present()->membershipType }}
                @endauth 
            </p>
        </div>

        <div class="grid grid-cols-2 pt-6 text-center">
            <div class="border-r-2 border-white group">
                <p class="text-sm group-hover:scale-105 font-semibold">
                    {{ $activeUserPostCount }}
                </p>
                <p class="text-xs text-gray-500 group-hover:scale-105">
                    posts
                </p>
            </div>
            <div class=" hover:scale-105">
                <p class="text-sm font-semibold">
                    {{ $activeUserTopicCount }}
                </p>
                <p class="text-xs text-gray-500">
                    topics
                </p>
            </div>
        </div>
    </div>

    <div class="dark:text-white text-black pt-6 mt-6 dark:bg-[#202124] bg-[#d0d5d6] rounded-2xl ml-3 mr-3 pb-6 text-center">
    <div class="hover:border-l-[#c5023d] hover:cursor-pointer border-l-2 border-l-transparent hover:bg-gradient-to-r hover:from-gsv-purple/80 hover:to-transparent w-full h-full pt-2 pb-2 mb-2 transition-all duration-300 ease-in">
            <a class="flex flex-row justify-center">
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 3C5.11765 3 3 4.64706 3 10C3 13.7383 4.0328 15.6692 7 16.4939V21L11.0124 16.9876C11.3301 16.996 11.6592 17 12 17C18.8824 17 21 15.3529 21 10C21 4.64706 18.8824 3 12 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg> 
                Forum
            </a>
        </div>
        <div class="hover:border-l-[#c5023d] hover:cursor-pointer border-l-2 border-l-transparent hover:bg-gradient-to-r hover:from-gsv-purple/80 hover:to-transparent w-full h-full pt-2 pb-2 mb-2 transition-all duration-300 ease-in">
        <a class="flex flex-row justify-center">
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 6C3 4.34315 4.34315 3 6 3H14C15.6569 3 17 4.34315 17 6V14C17 15.6569 15.6569 17 14 17H6C4.34315 17 3 15.6569 3 14V6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M21 7V18C21 19.6569 19.6569 21 18 21H7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3 12.375L6.66789 8.70711C7.05842 8.31658 7.69158 8.31658 8.08211 8.70711L10.875 11.5M10.875 11.5L13.2304 9.1446C13.6209 8.75408 14.2541 8.75408 14.6446 9.14461L17 11.5M10.875 11.5L12.8438 13.4688" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg> 
                Foto's
            </a>
        </div>
        <div class="hover:border-l-[#c5023d] hover:cursor-pointer border-l-2 border-l-transparent hover:bg-gradient-to-r hover:from-gsv-purple/80 hover:to-transparent w-full h-full pt-2 pb-2 mb-2 transition-all duration-300 ease-in">
            <a class="flex flex-row justify-center">
                <svg fill="none" class="h-6 w-6 mr-2" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 21C5 17.134 8.13401 14 12 14C15.866 14 19 17.134 19 21M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>                 
                Admin
            </a>
        </div>
    </div>
    <div class="items-center justify-center flex">
        <form method="POST" action="{{ route('uitloggen') }}">
            @csrf

            <button type="submit" class="flex flex-row dark:text-white text-black ml-6 mt-2 hover:cursor-pointer hover:text-black/70 dark:hover:text-white/70">
                <p class="text-xs my-auto mr-2 mx-auto">
                    Log uit
                </p>
                <svg class="h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 20H6C4.89543 20 4 19.1046 4 18L4 6C4 4.89543 4.89543 4 6 4H14M10 12H21M21 12L18 15M21 12L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </form>
    </div>

</div>
