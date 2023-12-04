@extends('layouts.admin')


@section('content')    
    <div class="text-black dark:text-white">
        <h1 class="text-3xl divide-black border-b-2 mb-4">
            Laatste updates
        </h1>
        <table class="min-w-full bg-transparent">
            <thead class="border-b-2 border-b-gray-100 dark:border-b-gray-700">
                <tr>
                    <th class="py-2 px-4 border-b text-left">Wanneer</th>
                    <th class="py-2 px-4 border-b text-left">Wie</th>
                    <th class="py-2 px-4 border-b text-left">Wat</th>
                </tr>
            </thead>
            <tbody>
                <tr class="{{ 0 % 2 === 0 ? 'bg-white/40' : 'bg-transparent' }} border-b-[1px] border-b-gray-100 dark:border-b-gray-700 hover:translate-x-1">
                    <td class="py-2 px-4 border-b text-sm italic text-gray-700 dark:text-gray-300">-16 jaar geleden</td>
                    <td class="py-2 px-4 border-b text-sm text-sky-600 dark:text-sky-400 hover:underline hover:cursor-pointer">Loran Knol</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Lidmaatschapsstatus gewijzigd</td>
                </tr>
                <tr class="{{ 1 % 2 === 0 ? 'bg-white/40' : 'bg-transparent' }} border-b-[1px] border-b-gray-100 dark:border-b-gray-700 hover:translate-x-1">
                    <td class="py-2 px-4 border-b text-sm italic text-gray-700 dark:text-gray-300">9 uur geleden</td>
                    <td class="py-2 px-4 border-b text-sm text-sky-600 dark:text-sky-400 hover:underline hover:cursor-pointer">Loran Knol</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Adres gewijzigd</td>
                </tr>
                <tr class="{{ 2 % 2 === 0 ? 'bg-white/40' : 'bg-transparent' }} border-b-[1px] border-b-gray-100 dark:border-b-gray-700 hover:translate-x-1">
                    <td class="py-2 px-4 border-b text-sm italic text-gray-700 dark:text-gray-300">2 dagen geleden</td>
                    <td class="py-2 px-4 border-b text-sm text-sky-600 dark:text-sky-400 hover:underline hover:cursor-pointer">Loran Knol</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Telefoonnummer gewijzigd</td>
                </tr>
                <tr class="{{ 3 % 2 === 0 ? 'bg-white/40' : 'bg-transparent' }} border-b-[1px] border-b-gray-100 dark:border-b-gray-700 hover:translate-x-1">
                    <td class="py-2 px-4 border-b text-sm italic text-gray-700 dark:text-gray-300">6 jaar geleden</td>
                    <td class="py-2 px-4 border-b text-sm text-sky-600 dark:text-sky-400 hover:underline hover:cursor-pointer">Loran Knol</td>
                    <td class="py-2 px-4 border-b text-sm dark:text-gray-200">Status gewijzigd</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection