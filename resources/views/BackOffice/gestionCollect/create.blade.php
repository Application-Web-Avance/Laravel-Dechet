@extends('BackOffice.LayoutBack.layout')

@section('content')
    <div class="container-fluid p-0">
        <div class="panel panel-default"
            style="margin: 23px; box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2); margin-bottom: 30px;">
            <div class="panel-heading" style="background-color: #232E3C; padding: 13px; color: aliceblue;">
                <h1 class="h3 mb-0" style="color: aliceblue">Créer un Événement</h1>
            </div>
            <div class="panel-body p-4">
                <!-- Form to create an event -->
                <form action="{{ route('evenement.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Nom de l'Événement -->
                        <div class="col-md-4 mb-3">
                            <label for="nomEvent" class="form-label">Nom de l'Événement</label>
                            <input type="text"
                                class="form-control @if ($errors->has('nomEvent')) is-invalid @elseif(old('nomEvent')) is-valid @endif"
                                id="nomEvent" name="nomEvent" value="{{ old('nomEvent') }}" required>
                            @if ($errors->has('nomEvent'))
                                <div class="invalid-feedback">{{ $errors->first('nomEvent') }}
                                    <i class="align-middle me-2" data-feather="alert-circle"></i>
                                </div>
                            @elseif(old('nomEvent'))
                                <div class="valid-feedback">
                                    <i class="align-middle me-2" data-feather="check-circle"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Date et Heure -->
                        <div class="col-md-4 mb-3">
                            <label for="date" class="form-label">Date et Heure</label>
                            <input type="datetime-local"
                                class="form-control @if ($errors->has('date')) is-invalid @elseif(old('date')) is-valid @endif"
                                id="date" name="date" value="{{ old('date') }}" required>
                            @if ($errors->has('date'))
                                <div class="invalid-feedback">{{ $errors->first('date') }}
                                    <i class="align-middle me-2" data-feather="alert-circle"></i>
                                </div>
                            @elseif(old('date'))
                                <div class="valid-feedback">
                                    <i class="align-middle me-2" data-feather="check-circle"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Lieu -->
                        <div class="col-md-4 mb-3">
                            <label for="lieu" class="form-label">Lieu</label>
                            <input type="text"
                                class="form-control @if ($errors->has('lieu')) is-invalid @elseif(old('lieu')) is-valid @endif"
                                id="lieu" name="lieu" value="{{ old('lieu') }}" required>
                            @if ($errors->has('lieu'))
                                <div class="invalid-feedback">{{ $errors->first('lieu') }}
                                    <i class="align-middle me-2" data-feather="alert-circle"></i>
                                </div>
                            @elseif(old('lieu'))
                                <div class="valid-feedback">
                                    <i class="align-middle me-2" data-feather="check-circle"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <!-- Maximum de Participants -->
                        <div class="col-md-6 mb-3">
                            <label for="Maxnbparticipant" class="form-label">Maximum de Participants</label>
                            <input type="number"
                                class="form-control @if ($errors->has('Maxnbparticipant')) is-invalid @elseif(old('Maxnbparticipant')) is-valid @endif"
                                id="Maxnbparticipant" name="Maxnbparticipant" value="{{ old('Maxnbparticipant') }}" required
                                min="1">
                            @if ($errors->has('Maxnbparticipant'))
                                <div class="invalid-feedback">{{ $errors->first('Maxnbparticipant') }}
                                    <i class="align-middle me-2" data-feather="alert-circle"></i>
                                </div>
                            @elseif(old('Maxnbparticipant'))
                                <div class="valid-feedback">
                                    <i class="align-middle me-2" data-feather="check-circle"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Type de Déchet -->
                        <div class="col-md-6 mb-3">
                            <label for="type_de_dechet_id" class="form-label">Type de Déchet</label>
                            <select
                                class="form-select @if ($errors->has('type_de_dechet_id')) is-invalid @elseif(old('type_de_dechet_id')) is-valid @endif"
                                id="type_de_dechet_id" name="type_de_dechet_id" required>
                                <option value="" disabled selected>Sélectionnez un type de déchet</option>
                                @foreach ($typesDeDechets as $typeDeDechet)
                                    <option value="{{ $typeDeDechet->id }}"
                                        {{ old('type_de_dechet_id') == $typeDeDechet->id ? 'selected' : '' }}>
                                        {{ $typeDeDechet->type }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('type_de_dechet_id'))
                                <div class="invalid-feedback">{{ $errors->first('type_de_dechet_id') }}
                                    <i class="align-middle me-2" data-feather="alert-circle"></i>
                                </div>
                            @elseif(old('type_de_dechet_id'))
                                <div class="valid-feedback">
                                    <i class="align-middle me-2" data-feather="check-circle"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea
                            class="form-control @if ($errors->has('description')) is-invalid @elseif(old('description')) is-valid @endif"
                            id="description" name="description" rows="3" required>{{ old('description') }}</textarea>

                        <!-- Affichage du message d'erreur si la description n'est pas valide -->
                        @if ($errors->has('description'))
                            <div class="invalid-feedback">{{ $errors->first('description') }}
                                <i class="align-middle me-2" data-feather="alert-circle"></i>
                            </div>
                        @elseif(old('description'))
                            <div class="valid-feedback">
                                <i class="align-middle me-2" data-feather="check-circle"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Image Upload -->
                    <div class="col-12 mb-3">
                        <label for="image" class="form-label">Image de l'Événement (optionnel)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}  <i class="align-middle me-2" data-feather="alert-circle"></i></div>
                        @enderror
                    </div>


                    <!-- Form Actions -->
                    <div class="form-actions fluid">
                        <a href="{{ route('evenement.index') }}" class="btn btn-secondary"
                            style="margin-top: 10px;">Retour</a>
                        <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Créer
                            l'Événement</button>
                    </div>
                </form>

            </div> <!-- END: Panel Body -->
        </div> <!-- END: Panel -->
    </div>
@endsection
