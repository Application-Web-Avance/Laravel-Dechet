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
                <label for="types_dechets" class="form-label">Types de Déchets:</label>
                <select name="types_dechets[]" id="types_dechets" class="form-select" required>
                    @foreach ($typesDechets as $typeDechet)
                        <option value="{{ $typeDechet->id }}">{{ $typeDechet->name }}</option>
                    @endforeach
                </select>

                <button class="btn btn-link p-0" type="button" data-bs-toggle="collapse" data-bs-target="#newTypeDechetContainer" aria-expanded="false" aria-controls="newTypeDechetContainer">
                    Ajouter Nouveau Type de Déchet
                </button>

                <div class="collapse"  id="newTypeDechetContainer">
                    <hr/>
                    <h3 class="offset-4">Ajouter un nouveau type de déchet</h3>
                    <div class="m-5">
                        <input type="text" id="new_type_dechet" class="form-control mx-5" placeholder="Ajouter nouveau type de déchet">
                        <button type="button" class="btn btn-success my-2 offset-5" id="add_type_dechet">Ajouter</button>
                    </div>
                    <hr/>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
@endsection
