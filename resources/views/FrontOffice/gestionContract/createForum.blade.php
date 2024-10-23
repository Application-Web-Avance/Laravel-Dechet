<form action="{{ route('contracts.store', ['id' => $entreprise->id, 'id2' => $centre->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="entreprise_id" value="{{ $entreprise->id }}">
    <input type="hidden" name="centre_id" value="{{ $centre->id }}">
    <!-- Champs du formulaire de contrat -->
    <div class="mb-3">
        <label for="date_signature" class="form-label">Date de Signature</label>
        <input type="date" name="date_signature" id="date_signature" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="duree_contract" class="form-label">Durée du Contrat (en mois)</label>
        <input type="number" name="duree_contract" id="duree_contract" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="montant" class="form-label">Montant du Contrat</label>
        <input type="number" name="montant" id="montant" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="pdf_proof" class="form-label">Preuve (PDF)</label>
        <input type="file" name="pdf_proof" id="pdf_proof" class="form-control" accept="application/pdf">
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Ajouter le Contrat</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
    </div>
</form>
