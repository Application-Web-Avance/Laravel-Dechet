@extends('BackOffice.LayoutBack.layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h2 class="text-center">Créer une nouvelle annonce</h2>
        </div>
        <div class="card-body p-5">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('AnnonceDechet.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Image de l'annonce -->
                <div class="form-group mb-4">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>

                <!-- Description de l'annonce -->
                <div class="form-group mb-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control rounded-3" id="description" name="description" rows="4" placeholder="Décrivez l'annonce..." required>{{ old('description') }}</textarea>
                </div>

                <!-- Adresse de collecte -->
                <div class="form-group mb-4">
                    <label for="adresse_collecte" class="form-label">Adresse de Collecte</label>
                    <input type="text" class="form-control rounded-3" id="adresse_collecte" name="adresse_collecte" value="{{ old('adresse_collecte') }}" placeholder="Saisissez l'adresse de collecte" required>
                </div>

                <!-- Quantité totale -->
                <div class="form-group mb-4">
                    <label for="quantite_totale" class="form-label">Quantité Totale</label>
                    <input type="number" class="form-control rounded-3" id="quantite_totale" name="quantite_totale" value="{{ old('quantite_totale') }}" placeholder="Saisissez la quantité totale" required>
                </div>

                <!-- Prix -->
                <div class="form-group mb-4">
                    <label for="price" class="form-label">Prix</label>
                    <input type="number" class="form-control rounded-3" id="price" name="price" value="{{ old('price') }}" placeholder="Saisissez le prix" required>
                </div>

                <!-- Statut -->
                <div class="form-group mb-4">
                    <label for="status" class="form-label">Statut</label>
                    <input type="text" class="form-control rounded-3" id="status" name="status" value="{{ old('status') }}" placeholder="Saisissez le statut" required>
                </div>

                <div class="form-group mb-4">
                    <label for="type_dechet" class="form-label">Type de déchet</label>
                    <input type="text" class="form-control rounded-3" id="type_dechet" name="type_dechet" value="{{ old('type_dechet') }}" placeholder="Saisissez le type de déchet" required>
                </div>

                <!-- Date de demande -->
                <div class="form-group mb-4">
                    <label for="date_demande" class="form-label">Date de Demande</label>
                    <input type="date" class="form-control rounded-3" id="date_demande" name="date_demande" value="{{ old('date_demande') }}" required>
                </div>

                <!-- Sélection de l'utilisateur -->
                <div class="form-group mb-4">
                    <label for="utilisateur_id" class="form-label">Utilisateur</label>
                    <select class="form-control rounded-3" id="utilisateur_id" name="utilisateur_id" required>
                        <option value="">Sélectionnez un utilisateur</option>
                        @foreach($utilisateurs as $utilisateur)
                            <option value="{{ $utilisateur->id }}">{{ $utilisateur->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary btn-lg">Créer l'annonce</button>
                    <a href="{{ route('AnnonceDechet.index') }}" class="btn btn-secondary btn-lg">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
