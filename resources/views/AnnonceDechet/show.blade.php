@extends('BackOffice.LayoutBack.layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
    <div class="card-header bg-primary text-dark">
            <h2 class="text-center">Détails de l'annonce</h2>
        </div>

        <div class="card-body">
            <!-- Image de l'annonce -->
            <div class="row mb-3">
                <div class="col-md-6">
                    @if($annonce->image)
                    <img src="{{ asset('storage/' . $annonce->image) }}" alt="Image de l'annonce" style="max-width: 80%;height:100%; border-radius:30%;">
                    @else
                    <img src="https://jolymome.fr/storage/articles/2022-03-f7bc5c6e88d5a711e303ba18ccf474c8.webp" alt="Image de l'annonce" style="max-width: 100%; border-radius:20%;"/>
                    @endif
                </div>
                <div class="col-md-6">
                    <!-- Statut de l'annonce -->
                    <h5><strong>Status:</strong> <span class="badge  {{ $annonce->status === 'disponible' ? 'bg-success' : 'bg-danger' }}" >{{ $annonce->status}}</span></h5>

                    <!-- Description de l'annonce -->
                    <h5><strong>Description:</strong></h5>
                    <p class="text-muted">{{ $annonce->description ?? 'Non défini' }}</p>

                    <!-- Date de demande -->
                    <h5><strong>Date de demande:</strong></h5>
                    <p class="text-muted">{{ $annonce->date_demande ?? 'Non définie' }}</p>

                    <!-- Adresse de collecte -->
                    <h5><strong>Adresse de collecte:</strong></h5>
                    <p class="text-muted">{{ $annonce->adresse_collecte ?? 'Non définie' }}</p>

                    <!-- Quantité totale -->
                    <h5><strong>Quantité totale:</strong></h5>
                    <p class="text-muted">{{ $annonce->quantite_totale ?? 'Non définie' }} kg</p>

                    <!-- Prix -->
                    <h5><strong>Prix:</strong></h5>
                    <p class="text-muted">{{ $annonce->price ? number_format($annonce->price, 2, ',', ' ') . ' DT' : 'Non défini' }}</p>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('annoncedechets.index') }}" class="btn bg-primary btn-lg text-white">Retour à la liste</a>
            </div>
        </div>
    </div>
</div>
@endsection
