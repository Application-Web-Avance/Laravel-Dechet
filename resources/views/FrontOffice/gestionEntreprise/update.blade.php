<form action="{{ route('entreprises.update', $entreprise->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Add your form fields here, pre-filled with the entreprise data -->
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
                        <label for="testimonial" class="form-label">Témoignage</label>
                        <textarea class="form-control" id="testimonial" name="testimonial">{{ $entreprise->testimonial }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>