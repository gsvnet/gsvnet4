@extends('layouts.app')


@section('content')    
    <div class="text-black dark:text-white pt-6 dark:bg-[#202124] bg-[#d0d5d6] rounded-2xl ml-3 mr-3 pl-3 pr-3 pb-6">
        <div class="justify-start text-white">
            <x-forum.selection-button text="Alles"/>
            <x-forum.selection-button text="Senaat"/>
            <x-forum.selection-button text="Praktisch"/>
            <x-forum.selection-button text="Vermaak"/>
        </div>
        <div class="pt-2">
            <x-forum.show-card />
            <x-forum.show-card />
            <x-forum.show-card />
            <x-forum.show-card />
            <x-forum.show-card />
            <x-forum.show-card />
            <x-forum.show-card />
            <x-forum.show-card />
            <x-forum.show-card />
            <x-forum.show-card />
            <x-forum.show-card />
            <x-forum.show-card />
            <x-forum.show-card />
            <x-forum.show-card />
        </div>
    </div>
@endsection