<div class="text-black dark:text-white pt-6 mt-6 dark:bg-[#202124] bg-[#d0d5d6] rounded-2xl ml-3 mr-3 pl-3 pr-3 pb-6">
    <div class="rounded-full aspect-square mx-auto h-24 w-24 overflow-hidden border-2 border-gsv-purple">
        <img src="{{ asset('/images/JorisInfoA.jpg') }}" alt="Profielfoto" class="object-cover h-full aspect-square" />
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