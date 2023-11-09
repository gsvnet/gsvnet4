@extends('layouts.admin')


@section('content')    
    <div class="text-black dark:text-white">
        <h1 class="text-3xl divide-black border-b-2 border-gray-300 mb-4">
            GSVnet van achter
        </h1>
        <p>
            Welkom bij de achterkant van de website! Op basis van de commissies die je doet kun je hier de dingen wel of niet aanpassen.
        </p>
        <h3 class="text-xl font-extralight mt-4">
            Snelle dingetjes
        </h3>
        <div class="mt-4">
            <button class="bg-gsv-purple hover:bg-gsv-purple/80 dark:bg-gsv-purple-dark dark:hover:bg-gsv-purple-dark/60 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                <span>Ledenbestand (csv)</span>
            </button>
        </div>
        <div class="mt-4">
            <button class="bg-gsv-purple hover:bg-gsv-purple/80 dark:bg-gsv-purple-dark dark:hover:bg-gsv-purple-dark/60 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
                <span>SIC-ontvangers (csv)</span>
            </button>
        </div>
    </div>
@endsection