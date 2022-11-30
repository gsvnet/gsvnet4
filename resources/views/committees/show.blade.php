<h1> COMMITTEE: {{$committee }}</h1>
<h1> Active members </h1>
@foreach ($activeMembers as $member)
       <li> {{$member}} </li>
@endforeach
<h1> Other committees </h1>
@foreach ($committees as $committee)
       <li> {{$committee}} </li>
@endforeach