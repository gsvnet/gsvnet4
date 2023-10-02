@extends('layouts.app')

@section('content')   
       <div class="justify-start text-white">
              <x-committees.selection-button text="Commisies"/>
              <x-committees.selection-button text="Senaten"/>
       </div>

       <div class="pt-4 grid lg:grid-cols-4 grid-cols-3 gap-x-2 gap-y-4">
              @foreach ($committees as $committee)
                     <x-committees.show-card title="{{ $committee->name }}" description="{{ $committee->description }}" unique="{{ $committee->unique_name }}" />
              @endforeach
       </div>
@endsection



