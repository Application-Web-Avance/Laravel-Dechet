@extends('BackOffice.LayoutBack.layout')
@include('BackOffice.gestionCollect.IndexCSS')
@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-dark">
                <h2 class="text-center text-white">Procédure de paiement</h2>
            </div>

            <div class="card-body">
                <!-- Détails de l'annonce -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <!-- Image de l'annonce -->
                        @if($annonce->image)
                        <img src="{{ asset('storage/' . $annonce->image) }}" alt="Image de l'annonce" style="max-width: 80%; height:100%; border-radius:30%;">
                        @else
                        <img src="https://jolymome.fr/storage/articles/2022-03-f7bc5c6e88d5a711e303ba18ccf474c8.webp" alt="Image de l'annonce" style="max-width: 100%; border-radius:20%;" />
                        @endif
                    </div>
                    <div class="col-md-6">
                        <!-- Statut de l'annonce -->
                        <h5><strong>Status:</strong> <span class="badge bg-info">{{ $annonce->status ?? 'disponible' }}</span></h5>

                        <!-- Description de l'annonce -->
                        <h5><strong>Description:</strong></h5>
                        <p class="text-muted">{{ $annonce->description ?? 'Non défini' }}</p>

                        <!-- Quantité totale -->
                        <h5><strong>Quantité totale:</strong></h5>
                        <p class="text-muted">{{ $annonce->quantite_totale ?? 'Non définie' }} kg</p>

                        <!-- Prix -->
                        <h5><strong>Prix:</strong></h5>
                        <p class="text-muted">{{ $annonce->price ? number_format($annonce->price, 2, ',', ' ') . ' DT' : 'Non défini' }}</p>
                    </div>
                </div>


                <div>
                    @csrf

                    <h4 class="text-center mb-4">Informations d'utilisateur</h4>

                    <div class="mb-3">
                        <label for="cardName" class="form-label">Nom </label>
                         <input type="hidden" name="utilisateur_id" value="{{ auth()->user()->id }}">
                         <input type="text" class="form-control rounded-3" value="{{ auth()->user()->name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="cardNumber" class="form-label">Email</label>
                         <input type="hidden" name="utilisateur_id" value="{{ auth()->user()->id }}">
                                           <input type="text" class="form-control rounded-3" value="{{ auth()->user()->email }}" disabled>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cardExpiry" class="form-label">Adresse</label>
                             <input type="hidden" name="utilisateur_id" value="{{ auth()->user()->id }}">
                                               <input type="text" class="form-control rounded-3" value="{{ auth()->user()->adresse }}" disabled>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cardCVC" class="form-label">Telephone</label>
                             <input type="hidden" name="utilisateur_id" value="{{ auth()->user()->id }}">
                                               <input type="text" class="form-control rounded-3" value="{{ auth()->user()->	telephone }}" disabled>
                        </div>
                    </div>
                    <form action="{{ route('AnnonceDechet.test', $annonce->id) }}" method="POST">
                             <div class="text-center mt-4">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <button type="submit" class="btn btn-success btn-lg">Payer {{ number_format($annonce->price, 2, ',', ' ') }} DT</button>
                                <a  class="btn btn-secondary btn-lg">Annuler</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
