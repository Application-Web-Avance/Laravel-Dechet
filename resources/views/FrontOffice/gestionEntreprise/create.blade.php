<form action="{{ route('entreprises.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="nom" class="form-label">Nom de l'entreprise</label>
        <input type="text" class="form-control" id="nom" name="nom" required>
    </div>
    <div class="mb-3">
        <label for="specialite" class="form-label">Spécialité</label>
        <input type="text" class="form-control" id="specialite" name="specialite" required>
    </div>
    <div class="mb-3">
        <label for="numero_siret" class="form-label">Numéro SIRET</label>
        <input type="text" class="form-control" id="numero_siret" name="numero_siret" required>
    </div>
    <div class="mb-3">
        <label for="adresse" class="form-label">Adresse</label>
        <input type="text" class="form-control" id="adresse" name="adresse" required>
    </div>
    <div class="mb-3">
        <label for="image_url" class="form-label">Image</label>
        <input type="file" class="form-control" id="image_url" name="image_url">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>
