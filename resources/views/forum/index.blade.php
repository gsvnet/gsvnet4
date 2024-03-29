@extends('layouts.app')

@section('content')   
    <div class="bg-gsv-purple w-full px-2 rounded-t-2xl">
        <h1 class="text-white mx-auto text-center text-2xl font-semibold py-8"> Discussie gezocht </h1>
    </div>

    <a class="text-black dark:text-white text-xs hover:text-black/50" href="/">
        < Alle Topics
    </a>

    <div class="flex mx-8 flex-col lg:flex-row">
        <div class="flex flex-col">
            <x-forum.message />
            <x-forum.message />
            <x-forum.message />
            <x-forum.message />
            <x-forum.message />
        </div>

        <div class="mt-4 ml-4">
            <p class="font-bold text-gsv-purple capitalize">
                Extern
            </p>
            <p>
                Dit topic staat Extern
            </p>
            <p class="font-bold text-gsv-purple capitalize mt-2">
                Tags
            </p>
            <p>
                GSV, Fiets, Auto
            </p>
        </div>
    </div>
   

@endsection