@extends('BackOffice.LayoutBack.layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-warning text-dark">
            <h2 class="text-center">Modifier l'annonce de déchets</h2>
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

            <form action="{{ route('annoncedechets.update', $annoncedechet->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Image de l'annonce -->
                <div class="form-group mb-4">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" id="image">
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $annoncedechet->image) }}" alt="Image de l'annonce" class="img-fluid" style="max-width: 450px; border-radius:20%;margin-left:350px">
                    </div>
                </div>

                <!-- Statut -->
                <div class="form-group mb-4">
                    <label for="status" class="form-label">Statut</label>
                    <input type="text" name="status" class="form-control rounded-3" id="status" value="{{ $annoncedechet->status }}" placeholder="Saisissez le statut">
                </div>

                <!-- Description -->
                <div class="form-group mb-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control rounded-3" id="description" rows="4" placeholder="Décrivez l'annonce...">{{ $annoncedechet->description }}</textarea>
                </div>

                <!-- Date de demande -->
                <div class="form-group mb-4">
                    <label for="date_demande" class="form-label">Date de demande</label>
                    <input type="date" name="date_demande" class="form-control rounded-3" id="date_demande" value="{{ $annoncedechet->date_demande }}">
                </div>

                <!-- Adresse de collecte -->
                <div class="form-group mb-4">
                    <label for="adresse_collecte" class="form-label">Adresse de collecte</label>
                    <input type="text" name="adresse_collecte" class="form-control rounded-3" id="adresse_collecte" value="{{ $annoncedechet->adresse_collecte }}" placeholder="Saisissez l'adresse de collecte">
                </div>

                <!-- Quantité totale -->
                <div class="form-group mb-4">
                    <label for="quantite_totale" class="form-label">Quantité totale</label>
                    <input type="number" name="quantite_totale" class="form-control rounded-3" id="quantite_totale" value="{{ $annoncedechet->quantite_totale }}" placeholder="Saisissez la quantité totale">
                </div>

                <!-- Prix -->
                <div class="form-group mb-4">
                    <label for="price" class="form-label">Prix</label>
                    <input type="text" name="price" class="form-control rounded-3" id="price" value="{{ $annoncedechet->price }}" placeholder="Saisissez le prix">
                </div>

                <!-- Boutons -->
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-warning btn-lg">Enregistrer les modifications</button>
                    <a href="{{ route('annoncedechets.index') }}" class="btn btn-secondary btn-lg">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
