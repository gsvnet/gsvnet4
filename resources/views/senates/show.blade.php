<h1> SENATE: {{$senate }}</h1>
<h1> Members </h1>
@foreach ($members as $member)
       <li> {{$member}} </li>
@endforeach
<h1> Other senates </h1>
@foreach ($senates as $senate)
       <li> {{$senate}} </li>
@endforeach