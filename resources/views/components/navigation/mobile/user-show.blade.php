<div class="w-full items-start m-3">
    <p class="font-semibold">
        @auth
            {{ $user->present()->fullname }}
        @endauth
    </p>
    <div class="text-sm italic flex flex-row">
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
</div>