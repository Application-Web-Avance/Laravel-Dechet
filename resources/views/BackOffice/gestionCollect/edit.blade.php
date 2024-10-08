@extends('BackOffice.LayoutBack.layout')

@section('content')
<div class="container-fluid p-0">
    <div class="panel panel-default" style="margin: 23px; box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2); margin-bottom: 30px;">
        <div class="panel-heading" style="background-color: #232E3C; padding: 13px; color: aliceblue;">
            <h1 class="h3 mb-0" style="color: aliceblue">Éditer l'Événement</h1>
        </div>
        <div class="panel-body p-4">
            <form action="{{ route('evenement.update', $collect->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')


                <div class="row">
                    <!-- Nom de l'Événement -->
                    <div class="col-md-4 mb-3">
                        <label for="nomEvent" class="form-label">Nom de l'Événement</label>
                        <input type="text" class="form-control @error('nomEvent') is-invalid @enderror" id="nomEvent" name="nomEvent" value="{{ old('nomEvent', $collect->nomEvent) }}" required>
                        @error('nomEvent')
                            <div class="invalid-feedback">{{ $message }} <i class="align-middle me-2" data-feather="alert-circle"></i></div> 
                        @enderror
                    </div>

                    <!-- Date et Heure -->
                    <div class="col-md-4 mb-3">
                        <label for="date" class="form-label">Date et Heure</label>
                        <input type="datetime-local" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', \Carbon\Carbon::parse($collect->date)->format('Y-m-d\TH:i')) }}" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }} <i class="align-middle me-2" data-feather="alert-circle"></i></div>
                        @enderror
                    </div>

                    <!-- Lieu -->
                    <div class="col-md-4 mb-3">
                        <label for="lieu" class="form-label">Lieu</label>
                        <input type="text" class="form-control @error('lieu') is-invalid @enderror" id="lieu" name="lieu" value="{{ old('lieu', $collect->lieu) }}" required>
                        @error('lieu')
                            <div class="invalid-feedback">{{ $message }} <i class="align-middle me-2" data-feather="alert-circle"></i></div> 
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Maximum de Participants -->
                    <div class="col-md-6 mb-3">
                        <label for="Maxnbparticipant" class="form-label">Maximum de Participants</label>
                        <input type="number" class="form-control @error('Maxnbparticipant') is-invalid @enderror" id="Maxnbparticipant" name="Maxnbparticipant" value="{{ old('Maxnbparticipant', $collect->Maxnbparticipant) }}" required>
                        @error('Maxnbparticipant')
                            <div class="invalid-feedback">{{ $message }} <i class="align-middle me-2" data-feather="alert-circle"></i></div> 
                        @enderror
                    </div>

                    <!-- Type de Déchet -->
                    <div class="col-md-6 mb-3">
                        <label for="type_de_dechet_id" class="form-label">Type de Déchet</label>
                        <select class="form-select @error('type_de_dechet_id') is-invalid @enderror" id="type_de_dechet_id" name="type_de_dechet_id" required>
                            <option value="">Sélectionnez un type de déchet</option>
                            @foreach ($typesDeDechets as $typeDeDechet)
                                <option value="{{ $typeDeDechet->id }}" {{ old('type_de_dechet_id', $collect->type_de_dechet_id) == $typeDeDechet->id ? 'selected' : '' }}>
                                    {{ $typeDeDechet->type }}
                                </option>
                            @endforeach
                        </select>
                        @error('type_de_dechet_id')
                            <div class="invalid-feedback">{{ $message }} <i class="align-middle me-2" data-feather="alert-circle"></i></div> 
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="col-12 mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $collect->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}  <i class="align-middle me-2" data-feather="alert-circle"></i></div>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div class="col-12 mb-3">
                    <label for="image" class="form-label">Télécharger une nouvelle image (optionnel)</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }} <i class="align-middle me-2" data-feather="alert-circle"></i></div> 
                    @enderror
                </div>

                <!-- Hidden Field for nbparticipant -->
                <input type="hidden" name="nbparticipant" value="{{ $collect->nbparticipant }}"> <!-- Conserver le nombre de participants -->

                <!-- Form Actions -->
                <div class="form-actions fluid">
                    <a href="{{ route('evenement.index') }}" class="btn btn-secondary" style="margin-top: 10px;">Retour</a>
                    <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Mettre à jour l'Événement</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
