@extends('FrontOffice.LayoutFront.layout')

@section('content')

    <div class="container-fluid p-5 m-5">
        <h1 class="mb-4">Liste des Centres de recyclage</h1>
        @if($centres->isEmpty())
            <p>Aucun centre trouvé, après l'ajout d'un centre il va-t-etre affiché ici.</p>
        @else
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Adresse</th>
                    <th>Horaire</th>
                    <th>Type Dechet</th>
                </tr>
                </thead>
                <tbody>
                @foreach($centres as $centre)
                    <tr>
                        <td>{{ $centre->nom }}</td>
                        <td>{{ $centre->adresse }}</td>
                        <td>{{ $centre->horaires }}</td>
                        <td>{{$centre->typedechet->type}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

    </div>


@endsection
