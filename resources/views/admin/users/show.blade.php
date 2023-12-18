@extends('layouts.admin')

@section('content')    
<div class="text-black dark:text-white">
    <h1 class="text-3xl divide-black border-b-2 mb-4" id="fullName">
        <!-- TODO: Add avatar here -->
        {{ $user->present()->fullName }}
    </h1>
    <div class="max-w-7xl grid grid-cols-7">
        <div class="overflow-hidden col-span-5">
            <div class="p-6">
                    {{-- Name --}}
                    <form method="POST" action="{{ route('gebruikers.updateName', ['user' => $user->id]) }}"> 
                        @csrf
                        @method('PUT')
                        
                        <x-label for="firstname" value="Naam" ></x-label>
                        <div id="textFullname" class="flex group items-center">
                            <p class="mt-1 w-fit mr-1 font-ligt text-xs italic">({{ $user->profile->initials }})</p>
                            <p class="mt-1 w-fit group-hover:underline text-lg">{{ $user->present()->fullName }}</p>
                            <button type="button" class="group-hover:block hidden ml-2 hover:text-slate-400 items-center" onclick="toggleInput('Fullname')"> @svg('gmdi-edit', 'h-4 w-4') </button>
                        </div>
                        <div id="inputFullname" class="hidden">
                            <div class="flex flex-col md:flex-row">
                                <x-input id="initials" name="initials" type="text" class="mt-1 w-40 md:w-20 mr-1 bg-slate-100" value="{{ $user->profile->initials }}" required />
                                <x-input id="firstname" name="firstname" type="text" class="mt-1 w-40 bg-slate-100" required  value="{{ $user->firstname }}" />
                                <x-input id="middlename" name="middlename" type="text" class="mt-1 w-40 md:w-20 md:mx-1 bg-slate-100"  value="{{ $user->middlename }}" />
                                <x-input id="lastname" name="lastname" type="text" class="mt-1 w-40 bg-slate-100" required  value="{{ $user->lastname }}" />
                                <x-button class="ml-3 mt-2 md:mt-0 mx-auto md:mr-0" type="submit">
                                    Update
                                </x-button>
                            </div>
                        </div>
                    </form>

                    {{-- Username --}}
                    <form method="POST" action="{{ route('gebruikers.updateUsername', ['user' => $user->id]) }}" class="mt-4"> 
                        @csrf
                        @method('PUT')
                        
                        <x-label for="username" value="Gebruikersnaam" ></x-label>
                        <div id="textUsername" class="flex group items-center">
                            <p class="mt-1 w-fit group-hover:underline text-lg">{{ $user->username }}</p>
                            <button type="button" class="group-hover:block hidden ml-2 hover:text-slate-400 items-center" onclick="toggleInput('Username')"> @svg('gmdi-edit', 'h-4 w-4') </button>
                        </div>
                        <div id="inputUsername" class="hidden">
                            <div class="flex flex-col md:flex-row">
                                <x-input id="username" name="username" type="text" class="mt-1 w-40 bg-slate-100" value="{{ $user->username }}" required />
                                <x-button class="ml-3 mt-2 md:mt-0 mx-auto md:mr-0" type="submit">
                                    Update
                                </x-button>
                        </div>
                    </div>
                    </form>

                    <!-- TODO: Continue this practice for all other input parts && to component -->
            </div>
        </div>
        <div class="col-span-2">
            @svg('gmdi-family-restroom-r', 'w-24 h-24')
            FAMILIE!!
        </div>
    </div>
</div>

<script>
    function toggleInput(id) {
        document.getElementById('text' + id).classList.toggle('hidden');
        document.getElementById('input' + id).classList.toggle('hidden');
    }
</script>

@endsection
