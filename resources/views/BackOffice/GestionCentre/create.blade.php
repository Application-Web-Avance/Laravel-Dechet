<!-- resources/views/BackOffice/GestionCentre/create.blade.php -->

@extends('BackOffice.LayoutBack.layout')

@section('content')
    <div class="container">
        <a class="btn btn-outline-info mb-5 " href="{{ route('centres.index') }}">< Retour</a>

        <h1>Ajouter un Centre De Recyclage</h1>
        <form action="{{ route('centres.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" name="nom" required>
            </div>

            <div class="form-group">
                <label for="adresse">Adresse</label>
                <input type="text" class="form-control" name="adresse" required>
            </div>

            <div class="form-group">
                <label for="horaires">Horaires</label>
                <input type="text" class="form-control" name="horaires" required>
            </div>


            <div class="mb-3">
                <label for="type_dechet_id" class="form-label">Types de Déchets:</label>
                <select name="type_dechet_id" id="types_dechets" class="form-select" required>
                    @foreach ($typesDechets as $typeDechet)
                        <option value="{{ $typeDechet->id }}">{{ $typeDechet->type }}</option>
                    @endforeach
                </select>
                <a class="link " href="{{route('type-dechets')}}">
                    Ajouter Nouveau Type de Déchet
                </a>
            </div>


            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
@endsection
