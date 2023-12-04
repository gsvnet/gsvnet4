@extends('layouts.admin')

<!-- TO DO: SORT TABLES -->
@section('content')    
    <div class="text-black dark:text-white">
        <h1 class="text-3xl divide-black border-b-2 mb-4">
            Leden
        </h1>
        <div class="flex flex-row pb-6 gap-x-2">
            <div>
                <label for="helper-text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Naam</label>
                <input type="text" id="helper-text" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gsv-purple/50 focus:border-gsv-purple/50 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gsv-purple/50 dark:focus:border-gsv-purple/50 py-3" placeholder="Japie">
            </div>
            <div>
                <label for="helper-text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jaarverband</label>
                <select class="hover:bg-gray-500 appearance-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gsv-purple/50 focus:border-gsv-purple/50 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gsv-purple/50 dark:focus:border-gsv-purple/50 py-3 px-4 pr-8" id="grid-state">
                    <option disabled selected value hidden> -- jaarverband -- </option>    
                    <option>Chezulas</option>
                    <option>Chezulas.2</option>
                    <option>Altijd Chezulas</option>
                </select>
            </div>
            <div>
                <label for="helper-text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jaarverband</label>
                <select class="appearance-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gsv-purple/50 focus:border-gsv-purple/50 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gsv-purple/50 dark:focus:border-gsv-purple/50 py-3 px-4 pr-8" id="grid-state">
                    <option disabled selected value hidden> -- regio -- </option>    
                    <option>Noord</option>
                    <option>Noord.2</option>
                    <option>Altijd Noord</option>
                </select>
            </div>
            <div class='flex items-end'>
                <button type="button" class="flex text-white bg-gsv-purple hover:bg-gsv-purple/80 focus:ring-4 focus:ring-gsv-purple/30 font-medium rounded-lg text-sm px-5 py-3 dark:bg-gsv-purple-dark dark:hover:bg-gsv-purple-dark/80 focus:outline-none dark:focus:ring-gsv-purple/80">@svg('heroicon-o-funnel', 'h-4 w-4 mr-2') Filter</button>
            </div>
        </div>
        <div class='flex flex-col'>
            <table class="min-w-full bg-transparent">
                <thead class="border-b-2 border-b-gray-100 dark:border-b-gray-700">
                    <tr>
                        <th class="py-2 px-4 border-b text-left text-xs">Voornaam</th>
                        <th class="py-2 px-4 border-b text-left text-xs">t/v</th>
                        <th class="py-2 px-4 border-b text-left text-xs">Achternaam</th>
                        <th class="py-2 px-4 border-b text-left text-xs">Jaarverband</th>
                        <th class="py-2 px-4 border-b text-left text-xs">Laatst Bijgewerkt</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="{{ 0 % 2 === 0 ? 'bg-white/40' : 'bg-transparent' }} border-b-[1px] border-b-gray-100 dark:border-b-gray-700 hover:translate-x-1">
                        <td class="py-2 px-4 border-b text-sm text-sky-600 dark:text-sky-400 hover:underline hover:cursor-pointer">Loran</td>
                        <td class="py-2 px-4 border-b text-sm dark:text-gray-200">van de</td>
                        <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Bos</td>
                        <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Chezulas (2019)</td>
                        <td class="py-2 px-4 border-b text-sm italic text-gray-700 dark:text-gray-300">2023-02-07 18:57:38</td>
                    </tr>
                    <tr class="{{ 1 % 2 === 0 ? 'bg-white/40' : 'bg-transparent' }} border-b-[1px] border-b-gray-100 dark:border-b-gray-700 hover:translate-x-1">
                        <td class="py-2 px-4 border-b text-sm text-sky-600 dark:text-sky-400 hover:underline hover:cursor-pointer">Loran</td>
                        <td class="py-2 px-4 border-b text-sm dark:text-gray-200">van de</td>
                        <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Bos</td>
                        <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Chezulas (2019)</td>
                        <td class="py-2 px-4 border-b text-sm italic text-gray-700 dark:text-gray-300">2023-02-07 18:57:38</td>
                    </tr>
                    <tr class="{{ 2 % 2 === 0 ? 'bg-white/40' : 'bg-transparent' }} border-b-[1px] border-b-gray-100 dark:border-b-gray-700 hover:translate-x-1">
                        <td class="py-2 px-4 border-b text-sm text-sky-600 dark:text-sky-400 hover:underline hover:cursor-pointer">Loran</td>
                        <td class="py-2 px-4 border-b text-sm dark:text-gray-200">van de</td>
                        <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Bos</td>
                        <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Chezulas (2019)</td>
                        <td class="py-2 px-4 border-b text-sm italic text-gray-700 dark:text-gray-300">2023-02-07 18:57:38</td>
                    </tr>
                    <tr class="{{ 3 % 2 === 0 ? 'bg-white/40' : 'bg-transparent' }} border-b-[1px] border-b-gray-100 dark:border-b-gray-700 hover:translate-x-1">
                        <td class="py-2 px-4 border-b text-sm text-sky-600 dark:text-sky-400 hover:underline hover:cursor-pointer">Loran</td>
                        <td class="py-2 px-4 border-b text-sm dark:text-gray-200">van de</td>
                        <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Bos</td>
                        <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Chezulas (2019)</td>
                        <td class="py-2 px-4 border-b text-sm italic text-gray-700 dark:text-gray-300">2023-02-07 18:57:38</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection