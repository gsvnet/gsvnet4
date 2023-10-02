@extends('layouts.app')

@section('content')
       <div class="bg-gsv-purple w-full px-2 rounded-t-2xl">
              <h1 class="text-white mx-auto text-center text-2xl font-semibold py-8">{{ $committee->name }} </h1>
       </div>
       <a class="text-black dark:text-white text-xs hover:text-black/50" href="/commissies">
              < Alle commissies
       </a>
       <p class="pt-2 px-4">
              {{{ $committee->description }}}
       </p>

       <h2 class="pt-2 text-xs px-4">
       Actieve Leden:
       </h2>
       <div class="grid sm:grid-cols-6 lg:grid-cols-8 pt-2 gap-2 px-6 grid-cols-4">
              @foreach ($activeMembers as $member)
                     <x-committees.show-member :member=$member/>
              @endforeach
       </div>

       <h2 class="pt-8 text-xs px-4">
       Leden Afgelopen Twee Jaar:
       </h2>       </h2>
       <div class="grid lg:grid-cols-12 sm:grid-cols-8 grid-cols-6 sm pt-2 gap-2 px-6">
              @foreach ($previousMembers as $member)
                     <x-committees.show-previous-member :member=$member/>
              @endforeach
       </div>
@endsection
