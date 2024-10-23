@extends('BackOffice.LayoutBack.layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
    <div class="card-header bg-primary text-dark">
            <h2 class="text-center">Informations sur le Paiement</h2>
        </div>

        <div class="card-body">
            <!-- Image de l'annonce -->
            <div class="row mb-3">
                <div class="col-md-6">
                    @if($payment->annonceDechet->image)
                    <img src="{{ asset('storage/' .$payment->annonceDechet->image) }}" alt="Image de l'annonce" style="max-width: 80%;height:100%; border-radius:30%;">
                    @else
                    <img src="https://jolymome.fr/storage/articles/2022-03-f7bc5c6e88d5a711e303ba18ccf474c8.webp" alt="Image de l'annonce" style="max-width: 100%; border-radius:20%;"/>
                    @endif
                </div>
                <div class="col-md-6">
                    <!-- Statut de l'annonce -->
                     <h5><strong>Utilisateur:</strong> <span> {{ $payment->utilisateur->name ?? 'Utilisateur non trouvé' }}</span></h5>
                    <h5><strong>price:</strong> <span>{{ $payment->price }}</span></h5>
                    <h5><strong>Quantité:</strong> <span >{{ $payment->quantité }}</span></h5>
                    <h5><strong>Status:</strong> <span >{{ $payment->payment_status }}</span></h5>
                    <h5><strong>Date de Paiement:</strong> <span >{{ $payment->payment_date }}</span></h5>
                    <h5><strong>Annonce:</strong> <span>{{$payment->annonceDechet->type_dechet ?? 'Annonce non trouvée' }}</span></h5>
                    <h5><strong>Description Annonce:</strong> <span>{{$payment->annonceDechet->description ?? 'Annonce non trouvée' }}</span></h5>


                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('paymentdechet.index') }}" class="btn bg-primary btn-lg text-white">Retour à la liste</a>
            </div>
        </div>
    </div>
</div>
@endsection
