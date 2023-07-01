<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('gebruikers.store') }}">
                        @csrf

                        {{-- Name --}}
                        <div>
                            <x-label for="firstname" value="Naam" ></x-label>
                            <div class="flex">
                                <x-input id="firstname" name="firstname" type="text" class="mt-1 w-40 flex-1" required />
                                <x-input id="middlename" name="middlename" type="text" class="mt-1 w-20 mx-1" />
                                <x-input id="lastname" name="lastname" type="text" class="mt-1 w-40 flex-1" required />
                            </div>
                        </div>

                        {{-- Username --}}
                        <div class="mt-4">
                            <x-label for="username" value="Gebruikersnaam" ></x-label>
                            <x-input id="username" name="username" type="text" class="block mt-1 w-full" required />
                        </div>

                        {{-- Type --}}
                        <div class="mt-4">
                            <x-label for="type" value="Type" ></x-label>
                            <x-select class="block mt-1 w-full" name="type">
                                @foreach (config('gsvnet.userTypes') as $type)
                                    {{-- Type is numeric --}}
                                    <option value={{ $type }}>{{ config('gsvnet.userTypesFormatted')[$type] }}</option>
                                @endforeach
                            </x-select>
                        </div>

                        {{-- Email --}}
                        <div class="mt-4">
                            <x-label for="email" value="E-mail" ></x-label>
                            <x-input id="email" name="email" type="email" class="block mt-1 w-full" required />
                        </div>

                        {{-- Password --}}
                        <div class="mt-4">
                            <x-label for="password" value="Wachtwoord" />
            
                            <x-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            required autocomplete="new-password" />
                        </div>

                        <div class="mt-4">
                            <x-label for="password2" value="Herhaal wachtwoord" />
            
                            <x-input id="password2" class="block mt-1 w-full"
                                            type="password"
                                            name="password_confirmation"
                                            required autocomplete="new-password" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">
                                Maak account
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>