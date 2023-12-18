@extends('layouts.admin')

@section('content')    
<div class="text-black dark:text-white">
    <h1 class="text-3xl divide-black border-b-2 mb-4">
        Lid of gebruiker toevoegen
    </h1>
    <div class="max-w-7xl">
        <div class="overflow-hidden">
            <div class="p-6">
                <form method="POST" action="{{ route('gebruikers.store') }}">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <x-label for="firstname" value="Naam" ></x-label>
                        <div class="flex">
                            <x-input id="firstname" name="firstname" type="text" class="mt-1 w-40 flex-1 bg-slate-100" required />
                            <x-input id="middlename" name="middlename" type="text" class="mt-1 w-20 mx-1 bg-slate-100" />
                            <x-input id="lastname" name="lastname" type="text" class="mt-1 w-40 flex-1 bg-slate-100" required />
                        </div>
                    </div>

                    {{-- Type --}}
                    <div class="mt-4">
                        <x-label for="type" value="Type" ></x-label>
                        <x-select id="type" class="block mt-1 w-full bg-slate-100 dark:bg-inherit" name="type">
                            @foreach (config('gsvnet.userTypes') as $type)
                                {{-- Type is numeric --}}
                                <option class="dark:text-black" value={{ $type }}>{{ config('gsvnet.userTypesFormatted')[$type] }}</option>
                            @endforeach
                        </x-select>
                    </div>

                    {{-- Username --}}
                    <div class="mt-4">
                        <x-label for="username" value="Gebruikersnaam" ></x-label>
                        <x-input id="username" name="username" type="text" class="block mt-1 w-full bg-slate-100" required />
                    </div>

                    {{-- Email --}}
                    <div class="mt-4">
                        <x-label for="email" value="E-mail" ></x-label>
                        <x-input id="email" name="email" type="email" class="block mt-1 w-full bg-slate-100" required />
                    </div>

                    {{-- Password --}}
                    <div class="mt-4">
                        <x-label for="password" value="Wachtwoord" />
        
                        <x-input id="password" class="block mt-1 w-full bg-slate-100"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password2" value="Herhaal wachtwoord" />
        
                        <x-input id="password2" class="block mt-1 w-full bg-slate-100"
                                        type="password"
                                        name="password_confirmation"
                                        required autocomplete="new-password" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-3" type="submit">
                            Maak account
                        </x-button>
                    </div>
                </form>

                {{-- Reset form only if there are no errors --}}
                @if ($errors->any())
                    <script>
                        document.getElementById('firstname').value = "{{ old('firstname') }}";
                        document.getElementById('middlename').value = "{{ old('middlename') }}";
                        document.getElementById('lastname').value = "{{ old('lastname') }}";
                        document.getElementById('type').value = "{{ old('type') }}";
                        document.getElementById('username').value = "{{ old('username') }}";
                        document.getElementById('email').value = "{{ old('email') }}";
                    </script>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
