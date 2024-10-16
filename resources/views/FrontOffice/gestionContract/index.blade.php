
                <div class="container-fluid feature bg-light py-5">
                    <div class="container py-5">
                        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                            <h4 class="text-primary">Centres disponibles</h4>
                            <h1 class="display-4 mb-4">Choisissez un centre pour {{ $entreprise->nom }} spécialité {{ $entreprise->specialite }}</h1>
                            <p class="mb-0">Veuillez sélectionner l'un des centres disponibles ci-dessous pour continuer avec le contrat.</p>
                            <!-- Search Field -->
                            <input type="text" id="search-centre-{{ $entreprise->id }}" class="form-control mt-3 search-centre" placeholder="Rechercher un centre par nom...">
                        </div>
                        <!-- Centre List -->
                        <div class="row g-4 centre-list" id="centre-list-{{ $entreprise->id }}">
                            @foreach ($centres as $index => $centre)
                                <div class="col-md-6 centre-item" data-centre-name="{{ $centre->nom }}" @if ($index >= 1) style="display: none;" @endif>
                                    <div class="feature-item p-4 pt-0">
                                        <div class="feature-icon p-4 mb-4">
                                            <i class="fas fa-building fa-3x"></i>
                                        </div>
                                        <h4 class="mb-4">{{ $centre->nom }}</h4>
                                        <p class="mb-4">{{ $centre->description ?? 'Pas de description disponible.' }}</p>
                                        <button class="btn btn-primary select-centre" data-bs-toggle="modal" data-bs-target="#addContractModalContract-{{ $entreprise->id }}-{{ $centre->id }}">
                                            Sélectionner le centre
                                        </button>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="addContractModalContract-{{ $entreprise->id }}-{{ $centre->id }}" tabindex="-1" aria-labelledby="addContractModalContractLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addContractModalContractLabel">Ajouter un contrat pour {{ $centre->nom }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @include('FrontOffice.gestionContract.create', ['entreprise' => $entreprise, 'centre' => $centre])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Show More Button -->
                        <div class="text-center mt-4">
                            <button id="show-more-{{ $entreprise->id }}" class="btn btn-secondary show-more-btn">Affihcer plus</button>
                        </div>
                        <!-- No Results Message -->
                        <div id="no-results-{{ $entreprise->id }}" class="alert alert-warning text-center mt-3" style="display: none;">
                            N'existe pas un centre de ce nom.
                        </div>
                    </div>
                </div>






<!-- JavaScript for Search Functionality -->
<script>
document.querySelectorAll('.show-more-btn').forEach(function(showMoreBtn) {
    showMoreBtn.addEventListener('click', function() {
        const centreListId = this.getAttribute('id').replace('show-more-', 'centre-list-');
        const centreItems = document.querySelectorAll(`#${centreListId} .centre-item`);
        
        console.log('Show more clicked for:', centreListId); // Debugging line
        
        centreItems.forEach(function(item) {
            item.style.display = 'block'; // Show all items
        });
        
        this.style.display = 'none'; // Hide the "Show More" button
    });
});

document.querySelectorAll('.search-centre').forEach(function(searchInput) {
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const centreListId = this.getAttribute('id').replace('search-centre-', 'centre-list-');
        const centreItems = document.querySelectorAll(`#${centreListId} .centre-item`);
        let hasResults = false;

        centreItems.forEach(function(item) {
            const centreName = item.getAttribute('data-centre-name').toLowerCase();
            if (centreName.includes(query)) {
                item.style.display = 'block';
                hasResults = true;
            } else {
                item.style.display = 'none';
            }
        });

        const noResultsMessageId = this.getAttribute('id').replace('search-centre-', 'no-results-');
        const noResultsMessage = document.getElementById(noResultsMessageId);
        if (hasResults) {
            noResultsMessage.style.display = 'none';
        } else {
            noResultsMessage.style.display = 'block';
        }
    });
});



</script>
