@extends('layouts.admin')

<!-- TO DO: SORT TABLES -->
@section('content')    
    <div class="text-black dark:text-white">
        <h1 class="text-3xl divide-black border-b-2 mb-4">
            Oud-leden der GSV
        </h1>
        <form class="flex flex-row pb-6 gap-x-2">
            <div>
                <label for="helper-text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Naam</label>
                <input type="text" name="zoekwoord" id="helper-text" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gsv-purple/50 focus:border-gsv-purple/50 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gsv-purple/50 dark:focus:border-gsv-purple/50 py-3" placeholder="Japie">
            </div>
            <div>
                <label for="helper-text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jaarverband</label>
                <select name="jaarverband" class="hover:cursor-pointer appearance-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gsv-purple/50 focus:border-gsv-purple/50 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gsv-purple/50 dark:focus:border-gsv-purple/50 py-3 px-4 pr-8" id="grid-state">
                    <option disabled selected value hidden> -- jaarverband -- </option>    
                    @foreach ($yearGroups as $yearGroup)
                        <option value="{{ $yearGroup->id }}">{{ $yearGroup->name }} ({{ $yearGroup->year }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="helper-text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Regio</label>
                <select name="regio" class="hover:cursor-pointer appearance-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gsv-purple/50 focus:border-gsv-purple/50 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gsv-purple/50 dark:focus:border-gsv-purple/50 py-3 px-4 pr-8" id="grid-state">
                    <option disabled selected value hidden> -- regio -- </option>    
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class='flex items-end'>
                <button type="submit" class="flex text-white bg-gsv-purple hover:bg-gsv-purple/80 focus:ring-4 focus:ring-gsv-purple/30 font-medium rounded-lg text-sm px-5 py-3 dark:bg-gsv-purple-dark dark:hover:bg-gsv-purple-dark/80 focus:outline-none dark:focus:ring-gsv-purple/80">@svg('heroicon-o-funnel', 'h-4 w-4 mr-2') Filter</button>
            </div>
        </form>
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
                    @foreach($profiles as $profile)
                        <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-white/40' : 'bg-transparent' }} border-b-[1px] border-b-gray-100 dark:border-b-gray-700 hover:translate-x-1">
                            <td class="py-2 px-4 border-b text-sm text-sky-600 dark:text-sky-400 hover:underline hover:cursor-pointer">{{ $profile->user->firstname }}</td>
                            <td class="py-2 px-4 border-b text-sm dark:text-gray-200">{{ $profile->user->middlename }}</td>
                            <td class="py-2 px-4 border-b text-sm dark:text-gray-200">{{ $profile->user->lastname }}</td>
                            @if($profile->yearGroup)
                                <td class="py-2 px-4 border-b text-sm dark:text-gray-200">{{ $profile->yearGroup->name }} ({{ $profile->yearGroup->year }})</td>
                            @else
                                <td class="py-2 px-4 border-b text-sm contrast-50 dark:text-gray-200">Onbekend</td>
                            @endif
                            <td class="py-2 px-4 border-b text-sm italic text-gray-700 dark:text-gray-300">{{ $profile->updated_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection