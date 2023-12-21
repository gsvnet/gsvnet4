@extends('layouts.admin')

@section('content')    
<div class="text-black dark:text-white">
    <h1 class="text-3xl divide-black border-b-2 mb-4" id="fullName">
        <!-- TODO: Add avatar here -->
        {{ $userShow->present()->fullName }}
    </h1>
    <div class="max-w-7xl grid grid-cols-7">
        <div class="overflow-hidden col-span-7 md:col-span-5">
            <div class="py-6">
                    {{-- Name --}}
                    <form method="POST" action="{{ route('gebruikers.updateName', ['user' => $userShow->id]) }}"> 
                        @csrf
                        @method('PUT')
                        
                        <x-label for="firstname" value="Naam" ></x-label>
                        <div id="textFullname" class="flex group items-center">
                            <p class="mt-1 w-fit mr-1 font-ligt text-xs italic">({{ $userShow->profile->initials }})</p>
                            <p class="mt-1 w-fit group-hover:underline text-lg">{{ $userShow->present()->fullName }}</p>
                            <button type="button" class="group-hover:block hidden ml-2 hover:text-slate-400 items-center" onclick="toggleInput('Fullname')"> @svg('gmdi-edit', 'h-4 w-4') </button>
                        </div>
                        <div id="inputFullname" class="hidden">
                            <div class="flex flex-col md:flex-row">
                                <x-input id="initials" name="initials" type="text" class="mt-1 w-40 md:w-20 mr-1 bg-slate-100" value="{{ $userShow->profile->initials }}" required />
                                <x-input id="firstname" name="firstname" type="text" class="mt-1 w-40 bg-slate-100" required  value="{{ $userShow->firstname }}" />
                                <x-input id="middlename" name="middlename" type="text" class="mt-1 w-40 md:w-20 md:mx-1 bg-slate-100"  value="{{ $userShow->middlename }}" />
                                <x-input id="lastname" name="lastname" type="text" class="mt-1 w-40 bg-slate-100" required  value="{{ $userShow->lastname }}" />
                                <x-button class="ml-3 mt-2 md:mt-0 mx-auto md:mr-0" type="submit">
                                    Update
                                </x-button>
                            </div>
                        </div>
                    </form>

                    {{-- Username --}}
                    <form method="POST" action="{{ route('gebruikers.updateUsername', ['user' => $userShow->id]) }}" class="mt-4"> 
                        @csrf
                        @method('PUT')
                        
                        <x-label for="username" value="Gebruikersnaam" ></x-label>
                        <div id="textUsername" class="flex group items-center">
                            <p class="mt-1 w-fit group-hover:underline text-lg">{{ $userShow->username }}</p>
                            <button type="button" class="group-hover:block hidden ml-2 hover:text-slate-400 items-center" onclick="toggleInput('Username')"> @svg('gmdi-edit', 'h-4 w-4') </button>
                        </div>
                        <div id="inputUsername" class="hidden">
                            <div class="flex flex-col md:flex-row">
                                <x-input id="username" name="username" type="text" class="mt-1 w-40 bg-slate-100" value="{{ $userShow->username }}" required />
                                <x-button class="ml-3 mt-2 md:mt-0 mx-auto md:mr-0" type="submit">
                                    Update
                                </x-button>
                        </div>
                    </div>
                    </form>

                    <!-- TODO: Continue this practice for all other input parts && to component -->
            </div>
        </div>
        <div class="col-span-7 md:col-span-2">
            <h2 class="flex items-end text-2xl">
                @svg('gmdi-family-restroom-r', 'w-14 h-14 mr-2')
                GSV-familie
            </h2>
            <h3 class="mt-2 font-thin text-xl">
                Papa of Mama
            </h3>
            @forelse($userShow->parents as $parent)
                <p class="mt-1 ml-1">
                    {{$parent->present()->fullName() }}
                </p>
            @empty
                <p class="mt-1 ml-1 text-gray-500 italic">Geen ouders</p>
            @endforelse

            <h3 class="mt-4 font-thin text-xl">
                Kinderen
            </h3>
            @forelse($userShow->children as $child)
                <p class="mt-1 ml-1">
                    {{$child->present()->fullName() }}
                </p>
            @empty
                <p class="mt-1 ml-1 text-gray-500 italic">Geen kinderen</p>
            @endforelse

            <h2 class="flex items-end text-2xl mt-8">Laatste veranderingen</h2>
            <ul class="mt-4">
                @forelse($userShow->profileChanges()->take(10)->orderBy('at', 'DESC')->get() as $change)
                    <li class="max-w-sm my-1 px-4 py-2 hover:-translate-x-1 bg-white/25 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <h4 class="mb-[0.5] text-md font-semibold tracking-tight text-gray-900 dark:text-white">{{ $change->present()->actionName() }}</h4>
                        <p class="mb-1 font-normal text-gray-500 dark:text-gray-400 text-sm">{{ $change->at->diffForHumans() }}</p>
                    </li>
                @empty
                    <li class="mb-3 font-normal text-gray-500 dark:text-gray-400 italic">Niks recent veranderd</li>
                @endforelse
            </ul>
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