@extends('FrontOffice.LayoutFront.layout')

@section('entreprise_content')

<div class="container-fluid testimonial pb-5">
    <div class="container pb-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h4 class="text-primary">Recycling Enterprises</h4>
            <h1 class="display-4 mb-4">Our Recycling Partners</h1>
            
            <!-- Button to trigger modal -->
            <button type="button" class="button-18" data-bs-toggle="modal" data-bs-target="#addEntrepriseModal">
                <i class="fa-solid fa-plus" title="Ajouter une entreprise de recyclage"></i>
            </button>
        </div>

        <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.2s">
    @foreach ($entreprises as $entreprise)
    <div class="testimonial-item bg-light rounded">
        <div class="row g-0">
            <div class="col-4 col-lg-4 col-xl-3">
                <div class="h-100">
                <img src="{{ asset('storage/' . $entreprise->image_url) }}"  
                    class="img-fluid h-100 rounded" 
                    style="object-fit: cover;" 
                    alt="{{ $entreprise->nom }}">
                </div>
            </div>
            <div class="col-8 col-lg-8 col-xl-9">
                <div class="d-flex flex-column my-auto text-start p-4">
                    <h4 class="text-dark mb-0">{{ $entreprise->nom }}</h4>
                    <p class="mb-3">{{ $entreprise->specialite }}</p>
                    <p class="mb-0">SIRET: {{ $entreprise->numero_siret }}</p>
                    <p class="mb-0">Address: {{ $entreprise->adresse }}</p>
                    <p class="mb-0">{{ $entreprise->testimonial }}</p>

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContractModal-{{ $entreprise->id }}">
                        Add Center & Contract
                    </button>
                    <!-- Action Buttons -->
                    <button class="btn btn-link text-primary" data-bs-toggle="modal" data-bs-target="#updateModal-{{ $entreprise->id }}">
                        <i class="fa-regular fa-pen-to-square" title="Modifier"></i>
                    </button>
                    <button class="btn btn-link text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $entreprise->id }}">
                        <i class="fa-regular fa-trash-can" title="Supprimer"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
    </div>
</div>

<!-- Modal for adding entreprise -->
<div class="modal fade" id="addEntrepriseModal" tabindex="-1" aria-labelledby="addEntrepriseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEntrepriseModalLabel">Ajouter une entreprise</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('FrontOffice.gestionEntreprise.create')
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
@foreach ($entreprises as $entreprise)
<div class="modal fade" id="updateModal-{{ $entreprise->id }}" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Modifier l'Entreprise</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('FrontOffice.gestionEntreprise.update')
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Delete Confirmation Modal -->
@foreach ($entreprises as $entreprise)
<div class="modal fade" id="deleteModal-{{ $entreprise->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            @include('FrontOffice.gestionEntreprise.destroy')
        </div>
    </div>
</div>
@endforeach

@endsection


<!-- Modal for adding a center to an entreprise -->
@foreach ($entreprises as $entreprise)
<div class="modal fade" id="addContractModal-{{ $entreprise->id }}" tabindex="-1" aria-labelledby="addContractModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContractModalLabel">Add Contract for {{ $entreprise->nom }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('FrontOffice.gestionContract.index', ['entreprise' => $entreprise, 'centres' => $centres])
            </div>
        </div>
    </div>
</div>
@endforeach

