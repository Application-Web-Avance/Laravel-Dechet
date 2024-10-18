@extends('BackOffice.LayoutBack.layout')

@section('content')

    <div class="container-fluid p-0">
        <a class="btn btn-success m-3 mx-5" href="{{ route('centres.create') }}">+ Ajouter un nouveau centre</a>
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
                    @if($isAdmin)
                        <th>Identifiant du Responsable</th>
                    @endif
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($centres as $centre)
                    <tr>
                        <td>{{ $centre->nom }}</td>
                        <td>{{ $centre->adresse }}</td>
                        <td>{{ $centre->horaires }}</td>
                        <td>{{$centre->typedechet->type}}</td>
                        @if($isAdmin)
                            <td>{{$centre->id_utilisateur}}</td>
                        @endif
                        <td>
                            <form action="{{ route('centres.edit', $centre->id) }}" style="display:inline-block;">
                                <button type="submit" class="btn btn-info btn-sm" onclick="">Mettre a jour</button>
                            </form>
                            <form action="{{ route('centres.destroy', $centre->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce centre ?');">Supprimer</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

    </div>

@endsection
