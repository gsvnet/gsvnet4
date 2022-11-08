<html>
    <body>
        <h1>Hello, {{ $user->firstname }}</h1>
        <h2> Committees: </h2>
        @forelse ($committees as $committee)
            <li>{{ $committee }}</li>
        @empty
            <p>Geen commissies</p>
        @endforelse
        <h2> Senaat: </h2>
        @forelse ($senates as $senate)
            <li>{{ $senate }}</li>
        @empty
            <p>Geen Senaten</p>
        @endforelse
        <h2> Oude regios: </h2>
        @forelse ($formerRegions as $regio)
            <li>{{ $regio }}</li>
        @empty
            <p>Geen voorgaande regios</p>
        @endforelse
    </body>
</html>