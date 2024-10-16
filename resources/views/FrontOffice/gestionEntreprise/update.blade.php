<form action="{{ route('entreprises.update', $entreprise->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- Form fields -->
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" value="{{ $entreprise->nom }}">
    </div>
    <div class="mb-3">
        <label for="specialite" class="form-label">Spécialité</label>
        <input type="text" class="form-control" id="specialite" name="specialite" value="{{ $entreprise->specialite }}">
    </div>
    <div class="mb-3">
        <label for="adresse" class="form-label">Adresse</label>
        <input type="text" class="form-control" id="adresse" name="adresse" value="{{ $entreprise->adresse }}">
    </div>
    <div class="mb-3">
        <label for="numero_siret" class="form-label">Numero Siret</label>
        <input type="text" class="form-control" id="numero_siret" name="numero_siret" value="{{ $entreprise->numero_siret }}">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description">{{ $entreprise->description }}</textarea>
    </div>
    <!-- Display existing image if available -->
    @if ($entreprise->image_url)
    <div class="mb-3">
        <label for="current_image" class="form-label">Image Actuelle</label>
        <div>
            <img src="{{ asset('storage/' . $entreprise->image_url) }}" alt="Image actuelle de l'entreprise" style="max-width: 150px;">
        </div>
    </div>
    @endif

    <!-- Field to upload a new image -->
    <div class="mb-3">
        <label for="image_url" class="form-label">Changer l'image</label>
        <input type="file" class="form-control" id="image_url" name="image_url">
    </div>
    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>
