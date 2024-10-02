@extends('BackOffice.LayoutBack.layout')

@section('content')
<div class="container">
    <h1>Nouvelle Demande de Collecte</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('demandecollectes.store') }}">
        @csrf
        
        <div class="mb-3">
            <label for="utilisateur_id" class="form-label">Utilisateur</label>
            <select class="form-control" id="utilisateur_id" name="utilisateur_id" required>
                <option value="">Sélectionnez un utilisateur</option>
                @foreach($utilisateurs as $utilisateur)
                    <option value="{{ $utilisateur->id }}">{{ $utilisateur->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="entreprise_id" class="form-label">Entreprise de Recyclage</label>
            <select class="form-control" id="entreprise_id" name="entreprise_id" required>
                <option value="">Sélectionnez une entreprise</option>
                @foreach($entreprises as $entreprise)
                    <option value="{{ $entreprise->id }}">{{ $entreprise->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date_demande" class="form-label">Date de Demande</label>
            <input type="date" class="form-control" id="date_demande" name="date_demande" required>
        </div>

        <div class="mb-3">
            <label for="adresse_collecte" class="form-label">Adresse de Collecte</label>
            <input type="text" class="form-control" id="adresse_collecte" name="adresse_collecte" required>
        </div>
        
        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <select class="form-select" id="status" name="status" required>
                <option value="en attente">En attente</option>
                <option value="confirmée">Confirmée</option>
                <option value="complétée">Complétée</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="quantite_totale" class="form-label">Quantité Totale</label>
            <input type="number" class="form-control" id="quantite_totale" name="quantite_totale" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Créer Demande</button>
        <a href="{{ route('demandecollectes.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
