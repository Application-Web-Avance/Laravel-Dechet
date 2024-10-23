@extends('FrontOffice.LayoutFront.layout')

@section('entreprise_content')

<div class="container mt-5 mb-5">
    <div class="row ">
        <div class="col-md-6">
            <h4>Informations sur l'Entreprise</h4>
            <p>Nom : {{ $entreprise->nom }}</p>
            <p>Spécialité : {{ $entreprise->specialite }}</p>

            <h4>Informations sur le Centre</h4>
            <p>Nom : {{ $centre->nom }}</p>
            <p>Description : {{ $centre->description ?? 'Pas de description disponible.' }}</p>
        </div>

        <div class="col-md-6">
            @include('FrontOffice.gestionContract.createForum',['entreprise' => $entreprise, 'centre' => $centre]);
        </div>
    </div>
</div>
@endsection
