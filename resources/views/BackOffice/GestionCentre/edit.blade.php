@extends('BackOffice.LayoutBack.layout')

@section('content')

    <div class="container-fluid p-0">
        <h1 class="mb-4">Modifier le Centre de recyclage</h1>

        <form action="{{ route('centres.update', $centre->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $centre->nom) }}" required>
            </div>

            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse" value="{{ old('adresse', $centre->adresse) }}" required>
            </div>

            <div class="mb-3">
                <label for="horaires" class="form-label">Horaires</label>
                <input type="text" class="form-control" id="horaires" name="horaires" value="{{ old('horaires', $centre->horaires) }}" required>
            </div>

            <div class="mb-3">
                <label for="type_dechet_id" class="form-label">Type de Déchet</label>
                <select id="type_dechet_id" name="type_dechet_id" class="form-select" required>
                    @foreach($typesDechets as $typeDechet)
                        <option value="{{ $typeDechet->id }}" {{ $centre->type_dechet_id == $typeDechet->id ? 'selected' : '' }}>
                            {{ $typeDechet->type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Mettre à jour</button>
        </form>
    </div>

@endsection
