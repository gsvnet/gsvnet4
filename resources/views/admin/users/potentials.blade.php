@extends('layouts.admin')

<!-- TO DO: SORT TABLES -->
@section('content')    
    <div class="text-black dark:text-white">
        <h1 class="text-3xl divide-black border-b-2 mb-4">
            Novieten
        </h1>
        <table class="min-w-full bg-transparent">
            <thead class="border-b-2 border-b-gray-100 dark:border-b-gray-700">
                <tr>
                    <th class="py-2 px-4 border-b text-left text-xs">Gebruikersnaam</th>
                    <th class="py-2 px-4 border-b text-left text-xs">Voornaam</th>
                    <th class="py-2 px-4 border-b text-left text-xs">t/v</th>
                    <th class="py-2 px-4 border-b text-left text-xs">Achternaam</th>
                    <th class="py-2 px-4 border-b text-left text-xs">Email</th>
                    <th class="py-2 px-4 border-b text-left text-xs">Aanmelddatum</th>
                    <th class="py-2 px-4 border-b text-left text-xs">Superkrachten</th>
                </tr>
            </thead>
            <tbody>
                <tr class="{{ 0 % 2 === 0 ? 'bg-white/40' : 'bg-transparent' }} border-b-[1px] border-b-gray-100 dark:border-b-gray-700 hover:translate-x-1">
                    <td class="py-2 px-4 border-b text-sm text-sky-600 dark:text-sky-400 hover:underline hover:cursor-pointer">Stoerste Fakka</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Henk</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200"></td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Lorem</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">voorbeeld@jazeker.nl</td>
                    <td class="py-2 px-4 border-b text-sm italic text-gray-700 dark:text-gray-300">2023-02-07 18:57:38</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200"><button type="button" class="focus:outline-none flex items-center text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-1.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">@svg('gmdi-delete-outline-tt', 'h-4 w-4 mr-2') Verwijder</button></td>
                </tr>
                <tr class="{{ 1 % 2 === 0 ? 'bg-white/40' : 'bg-transparent' }} border-b-[1px] border-b-gray-100 dark:border-b-gray-700 hover:translate-x-1">
                    <td class="py-2 px-4 border-b text-sm text-sky-600 dark:text-sky-400 hover:underline hover:cursor-pointer">Stoerste Fakka</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Henk</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200"></td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Lorem</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">voorbeeld@jazeker.nl</td>
                    <td class="py-2 px-4 border-b text-sm italic text-gray-700 dark:text-gray-300">2023-02-07 18:57:38</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200"><button type="button" class="focus:outline-none flex items-center text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-1.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">@svg('gmdi-delete-outline-tt', 'h-4 w-4 mr-2') Verwijder</button></td>
                </tr>
                <tr class="{{ 2 % 2 === 0 ? 'bg-white/40' : 'bg-transparent' }} border-b-[1px] border-b-gray-100 dark:border-b-gray-700 hover:translate-x-1">
                    <td class="py-2 px-4 border-b text-sm text-sky-600 dark:text-sky-400 hover:underline hover:cursor-pointer">Stoerste Fakka</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Henk</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200"></td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Lorem</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">voorbeeld@jazeker.nl</td>
                    <td class="py-2 px-4 border-b text-sm italic text-gray-700 dark:text-gray-300">2023-02-07 18:57:38</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200"><button type="button" class="focus:outline-none flex items-center text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-1.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">@svg('gmdi-delete-outline-tt', 'h-4 w-4 mr-2') Verwijder</button></td>
                </tr>
                <tr class="{{ 3 % 2 === 0 ? 'bg-white/40' : 'bg-transparent' }} border-b-[1px] border-b-gray-100 dark:border-b-gray-700 hover:translate-x-1">
                    <td class="py-2 px-4 border-b text-sm text-sky-600 dark:text-sky-400 hover:underline hover:cursor-pointer">Stoerste Fakka</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Henk</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200"></td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Lorem</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">voorbeeld@jazeker.nl</td>
                    <td class="py-2 px-4 border-b text-sm italic text-gray-700 dark:text-gray-300">2023-02-07 18:57:38</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200"><button type="button" class="focus:outline-none flex items-center text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-1.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">@svg('gmdi-delete-outline-tt', 'h-4 w-4 mr-2') Verwijder</button></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection