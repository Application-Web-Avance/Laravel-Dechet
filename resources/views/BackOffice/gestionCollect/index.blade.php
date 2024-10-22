@include('BackOffice.gestionCollect.IndexCSS')

@extends('BackOffice.LayoutBack.layout')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @flasher_render
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex justify-content-between mb-3">
                            <h2 class="card-title mb-0">Liste de vos événements</h2>
                            <a href="{{ route('evenement.create') }}" class="btn btn-primary">Créer un Événement</a>
                        </div>
                        <input type="text" id="search" class="form-control"
                            placeholder="Rechercher dans les événements" onkeyup="filterEvents()">
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover my-0">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Nom</th>
                                    <th>Date</th>
                                    <th class="d-none d-xl-table-cell">Lieu</th>
                                    <th>nb Participants</th>
                                    <th class="d-none d-md-table-cell">Type de Déchet</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="eventTableBody">
                                @if ($collects->isEmpty())
                                <tr id="noResultsRow">
                                    <td colspan="6" class="text-center">Vous n'avez aucun événement.</td>
                                </tr>
                                @else
                                    @foreach ($collects as $collect)
                                        <tr>
                                            <td>
                                                @if ($collect->image)
                                                <img src="{{ $collect->image ? asset('storage/' . $collect->image) : $defaultImagePath }}" alt="Image de l'événement" style="width: 50px; height: 50px; object-fit: cover; border-radius: 20%;">

                                                @else
                                                    <img src="{{ asset('storage/images/collectes/Collectdechet.jpeg') }}"
                                                        alt="Image par défaut"
                                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 20%;">
                                                @endif
                                            </td>
                                            <td>{{ $collect->nomEvent }}</td>
                                            <td>{{ \Carbon\Carbon::parse($collect->date)->format('H:i a d-m-Y') }}</td>
                                            <td class="d-none d-xl-table-cell">{{ $collect->lieu }}</td>
                                            <td>{{ $collect->nbparticipant }} / {{ $collect->Maxnbparticipant }}</td>
                                            <td class="d-none d-md-table-cell">{{ $collect->typeDeDechet->type ?? 'N/A' }}
                                            </td>
                                            <td class="d-flex flex-column flex-md-row justify-content-around">
                                                <button type="button" class="btn btn-secondary mx-1 action-btn"
                                                    onclick="window.location.href='{{ route('evenement.show', $collect->id) }}'">
                                                    <i class="align-middle me-2" data-feather="eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-success mx-1 action-btn"
                                                    onclick="window.location.href='{{ route('evenement.edit', $collect->id) }}'">
                                                    <i data-feather="edit"></i>
                                                </button>
                                                <form id="delete-form-{{ $collect->id }}" action="{{ route('evenement.destroy', $collect->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger mx-1 action-btn" onclick="confirmDelete({{ $collect->id }})">
                                                        <i data-feather="delete"></i>
                                                    </button>
                                                </form>

                                                <button type="button" class="btn btn-info mx-1 action-btn"
                                                    onclick="window.location.href='{{ route('participants.show', $collect->id) }}'">
                                                    <i data-feather="users"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr id="noResultsRow" style="display: none;">
                                        <td colspan="6" class="text-center">Aucun résultat trouvé.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item {{ $collects->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link rounded-circle" href="{{ $collects->previousPageUrl() }}"
                                            tabindex="-1">
                                            <i class="align-middle" data-feather="chevron-left"></i>
                                        </a>
                                    </li>
                                    @for ($i = 1; $i <= $collects->lastPage(); $i++)
                                        <li class="page-item {{ $i == $collects->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $collects->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li class="page-item {{ $collects->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link rounded-circle" href="{{ $collects->nextPageUrl() }}">
                                            <i class="align-middle" data-feather="chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterEvents() {
            const searchValue = document.getElementById('search').value.toLowerCase();
            const rows = document.querySelectorAll('#eventTableBody tr');
            let hasVisibleRow = false; // Track if any row is visible

            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                let rowContainsSearchTerm = false;

                for (let i = 0; i < cells.length; i++) {
                    if (cells[i].textContent.toLowerCase().includes(searchValue)) {
                        rowContainsSearchTerm = true;
                        break;
                    }
                }

                // If the row contains the search term, make it visible; otherwise, hide it
                row.style.display = rowContainsSearchTerm ? '' : 'none';

                if (rowContainsSearchTerm) {
                    hasVisibleRow = true;
                }
            });

            // If no visible rows are found, display the "No results found" row
            document.getElementById('noResultsRow').style.display = hasVisibleRow ? 'none' : '';
        }
    </script>

    <script>
        function confirmDelete(eventId) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Vous ne pourrez pas revenir en arrière !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if confirmed
                    document.getElementById('delete-form-' + eventId).submit();
                }
            });
        }
    </script>

@endsection
