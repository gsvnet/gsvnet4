<html>
    <body>
{{ Form::open(array('method'=>'get')) }}
<input type="search" class="form-control search-user-input" id="naam" name="naam" placeholder="typ maar gewoon iets" value="{{{Request::input('name')}}}">
<select name="regio" id="regio">
    <option value="0">Maakt niet uit</option>
    @foreach ($regions as $region)
        <option value="{{$region->id}}" {{Request::input('regio') == $region->id ? 'selected="selected"' : ''}}>{{$region->name}}</option>
    @endforeach
</select>
<select name="jaarverband" id="jaarverband">
    <option value="0">Doet er niet toe</option>
    @foreach ($yearGroups as $yearGroup)
        <option value="{{$yearGroup->id}}" {{Request::input('jaarverband') == $yearGroup->id ? 'selected="selected"' : ''}}>{{$yearGroup}}</option>
    @endforeach
</select>
<label><input type="checkbox" name="oudleden" value="1" {{Request::input('oudleden') == 1 ? 'checked="checked"' : ''}} /> Oudleden weergeven</label>
<button type="submit" class="button">Zoeken #yolo</button>
{!! Form::close() !!}
<h1> RESULTS </h1>
@if(count($members) > 0)
    <ol class="user-profile-list list">
    @foreach ($members as $member)
       <li> {{$member}} </li>
    @endforeach
</ol>
{{ $members->links() }}
@else
    <p>Geen gebruikers gevonden</p>
@endif


</body>
</html>