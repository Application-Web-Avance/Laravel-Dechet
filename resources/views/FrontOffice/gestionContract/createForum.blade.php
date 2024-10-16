<form action="{{ route('contracts.store', ['id' => $entreprise->id, 'id2' => $centre->id]) }}" method="POST">
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

                <!--<div class="mb-3">
                    <label for="typeContract" class="form-label">Type de Contrat</label>
                    <input type="text" name="typeContract" id="typeContract" class="form-control" required>
                </div>-->
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Ajouter le Contrat</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
</form>