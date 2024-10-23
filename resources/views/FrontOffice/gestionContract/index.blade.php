<div class="container-fluid feature bg-light py-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5" style="max-width: 800px;">
            <h4 class="text-primary">Centres disponibles</h4>
            <h1 class="display-4 mb-4">Choisissez un centre pour {{ $entreprise->nom }} spécialité {{ $entreprise->specialite }}</h1>
            <p class="mb-0">Veuillez sélectionner l'un des centres disponibles ci-dessous pour continuer avec le contrat.</p>
            <input type="text" id="search-centre-{{ $entreprise->id }}" class="form-control mt-3 search-centre" placeholder="Rechercher un centre par nom...">
        </div>

        <div class="row g-4 centre-list" id="centre-list-{{ $entreprise->id }}">
        @foreach ($centres as $index => $centre)
    <div class="col-md-6 centre-item" data-centre-name="{{ $centre->nom }}" @if ($index >= 1) style="display: none;" @endif>
        <div class="feature-item p-4 pt-0">
            <div class="feature-icon p-4 mb-4">
                <i class="fas fa-building fa-3x"></i>
            </div>
            <h4 class="mb-4">{{ $centre->nom }}</h4>
            <p class="mb-4">{{ $centre->description ?? 'Pas de description disponible.' }}</p>
            <a href="{{ route('contracts.create', ['entreprise' => $entreprise->id, 'centre' => $centre->id]) }}" class="btn btn-primary">
                Sélectionner le centre
            </a>
        </div>
    </div>




            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <button id="show-more-{{ $entreprise->id }}" class="btn btn-secondary show-more-btn">Afficher plus</button>
        </div>
        
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
