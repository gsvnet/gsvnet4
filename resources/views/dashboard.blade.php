@extends('layouts.app')


@section('content')    
    <div class="justify-start text-white">
        <x-forum.selection-button text="Alles"/>
        <x-forum.selection-button text="Senaat"/>
        <x-forum.selection-button text="Praktisch"/>
        <x-forum.selection-button text="Vermaak"/>
    </div>
    <div class="pt-4">
        <div class="px-4 mx-2 flex flex-row text-xs">
            <div class="w-[15%] text-left pl-4">
                <p class="dark:text-white/30 text-black/30">
                    Laatste Post
                </p>
            </div>
            <div class="w-[35%] pl-4 flex flex-row">
                <p class="dark:text-white/30 text-black/30">
                    Laatste Post Door
                </p>
                <p class="dark:text-white/30 text-black/30 mr-4 mx-auto">
                    Laatste Post
                </p>
            </div>
            <div class="w-[30%] text-left pl-4">
                <p class="dark:text-white/30 text-black/30">
                    Topic
                </p>
            </div>
            <div class="w-[20%] pl-4 flex flex-row">
                <p class="dark:text-white/30 text-black/30">
                    Posts
                </p>
                <p class="dark:text-white/30 text-black/30 mr-6 mx-auto">
                    Likes
                </p>
            </div>
        </div>
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
@endsection