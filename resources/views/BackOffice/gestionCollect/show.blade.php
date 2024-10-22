@extends('BackOffice.LayoutBack.layout')

@section('content')
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-md-10 offset-md-1" >
                <div class="panel panel-default" style="margin: 23px; box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2); margin-bottom: 30px;">
                    <div class="panel-body">
                        <div class="panel panel-primary" style="margin: 0;">
                            <div class="panel-heading text-center" style="background-color: #232E3C; padding: 13px;">
                                <h4 class="mb-0 text-white">Détails de l'événement</h4>
                            </div>

                            <fieldset disabled style="padding: 3px; margin: 10px;">
                                <div class="form-group">
                                    <div class="text-center">
                                        @if ($event->image)
                                            <img src="{{ asset('storage/' . $event->image) }}"
                                                 alt="Image de l'événement" style="width: 150px; height: 150px; object-fit: cover; border-radius: 20%;">
                                        @else
                                            <img src="{{ asset('storage/images/collectes/Collectdechet.jpeg') }}"
                                                 alt="Image par défaut" style="width: 150px; height: 150px; object-fit: cover; border-radius: 20%;">
                                        @endif
                                    </div>
                                </div>

                                <!-- Nom de l'Événement -->
                                <div class="form-group">
                                    <label for="disabledTextInput">Nom de l'Événement</label>
                                    <input type="text" id="disabledTextInput" class="form-control"
                                           placeholder="{{ $event->nomEvent }}">
                                </div>

                                <div class="form-group">
                                    <label for="disabledTextInput">Date</label>
                                    <input type="text" id="disabledTextInput" class="form-control"
                                           placeholder="{{ \Carbon\Carbon::parse($event->date)->format('H:i a d-m-Y') }}">
                                </div>

                                <div class="form-group">
                                    <label for="disabledTextInput">Lieu</label>
                                    <input type="text" id="disabledTextInput" class="form-control"
                                           placeholder="{{ $event->lieu }}">
                                </div>

                                <div class="form-group">
                                    <label for="disabledTextInput">Nombre de Participants</label>
                                    <input type="text" id="disabledTextInput" class="form-control"
                                           placeholder="{{ $event->nbparticipant }}">
                                </div>

                                <div class="form-group">
                                    <label for="disabledTextInput">Maximum de Participants</label>
                                    <input type="text" id="disabledTextInput" class="form-control"
                                           placeholder="{{ $event->Maxnbparticipant }}">
                                </div>

                                <div class="form-group">
                                    <label for="disabledTextInput">Description</label>
                                    <textarea id="disabledTextInput" class="form-control"
                                              placeholder="{{ $event->description }}" rows="3"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="disabledTextInput">Type de Déchet</label>
                                    <input type="text" id="disabledTextInput" class="form-control"
                                           placeholder="{{ $event->typeDeDechet->type ?? 'N/A' }}">
                                </div>

                                <!-- Date de Création -->
                                <div class="form-group">
                                    <label for="disabledTextInput">Date de Création de l'Événement</label>
                                    <input type="text" id="disabledTextInput" class="form-control"
                                           placeholder="{{ \Carbon\Carbon::parse($event->created_at)->format('H:i a d-m-Y') }}">
                                </div>
                            </fieldset>

                            <div class="text-start ms-3" style="margin-bottom: 10px;">
                                <a class="btn btn-sm btn-secondary" style="padding: 5.6px 30px; font-size: 14px; margin-bottom: 20px;"
                                   href="{{ route('evenement.index') }}">Retour</a>
                            </div>
                        </div> <!-- END: Panel -->
                    </div> <!-- END: Panel Body -->
                </div> <!-- END: Panel -->
            </div> <!-- END: Column -->
        </div> <!-- END: Row -->
    </div>
@endsection
