@include('BackOffice.gestionContract.IndexCSS')

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
                            <h2 class="card-title mb-0">Liste de vos contrats</h2>
                        </div>
                        <input type="text" id="search" class="form-control"
                            placeholder="Rechercher un contrat" onkeyup="filterContracts()">
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover my-0">
                            <thead>
                                <tr>
                                    <th>Entreprise</th>
                                    <th>Centre</th>
                                    <th>Date de Début</th>
                                    <th>Date de Fin</th>
                                    <th>Statut</th>
                                    <th>Preuve</th>
                                </tr>
                            </thead>
                            <tbody id="contractTableBody">
                                @if ($contracts->isEmpty())
                                <tr id="noResultsRow">
                                    <td colspan="7" class="text-center">Aucun contrat trouvé.</td>
                                </tr>
                                @else
                                    @foreach ($contracts as $contract)
                                        <tr>
                                            <td data-bs-toggle="modal" data-bs-target="#entrepriseModal-{{ $contract->entreprise->id }}">{{ $contract->entreprise->nom }}</td>
                                            <td data-bs-toggle="modal" data-bs-target="#centreModal-{{ $contract->centre->id }}">{{ $contract->centre->nom }}</td>
                                            <td>{{ \Carbon\Carbon::parse($contract->date_signature)->format('d-m-Y') }}</td>
                                            
                                            <td class="contract-end-date" data-duree="{{ calculateContractDuration($contract->duree_contract) }}">{{ $contract->date_fin }}</td>
                                            <td>
                                                <select class="form-select statut-dropdown" onchange="updateStatus({{ $contract->id }}, this)">
                                                    <option value="en cours" {{ $contract->typeContract == 'en cours' ? 'selected' : '' }}>En Cours</option>
                                                    <option value="accepté" {{ $contract->typeContract == 'accepté' ? 'selected' : '' }}>Accepté</option>
                                                    <option value="refusé" {{ $contract->typeContract == 'refusé' ? 'selected' : '' }}>Refusé</option>
                                                </select>
                                            </td>

                                            <td >
                                                @if ($contract->pdf_proof)
                                                    <a href="{{ Storage::url($contract->pdf_proof) }}" target="_blank">Voir la preuve (PDF)</a>
                                                @else
                                                    non preuve trouver
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr id="noResultsRow" style="display: none;">
                                        <td colspan="7" class="text-center">Aucun résultat trouvé.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-3">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item {{ $contracts->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link rounded-circle" href="{{ $contracts->previousPageUrl() }}" tabindex="-1">
                                            <i class="align-middle" data-feather="chevron-left"></i>
                                        </a>
                                    </li>
                                    @for ($i = 1; $i <= $contracts->lastPage(); $i++)
                                        <li class="page-item {{ $i == $contracts->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $contracts->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li class="page-item {{ $contracts->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link rounded-circle" href="{{ $contracts->nextPageUrl() }}">
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




        <!-- Entreprise Modal -->
    <div class="modal fade" id="entrepriseModal-{{ $contract->entreprise->id }}" tabindex="-1" aria-labelledby="entrepriseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="entrepriseModalLabel">{{ $contract->entreprise->nom }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <p>Adresse: {{ $contract->entreprise->adresse }}</p>
                    <p>Email: {{ $contract->entreprise->email }}</p>
                    <p>Specialite: {{ $contract->entreprise->specialite }}</p>
                    <p>Numero siret: {{ $contract->entreprise->numero_siret }}</p>
                    <p>Description: {{ $contract->entreprise->description }}</p>
                    <!-- view the image  image_url -->
                    <!-- Add more entreprise details as needed -->
                </div>
            </div>
        </div>
    </div>

    <!-- Centre Modal -->
    <div class="modal fade" id="centreModal-{{ $contract->centre->id }}" tabindex="-1" aria-labelledby="centreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="centreModalLabel">{{ $contract->centre->nom }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Adresse: {{ $contract->centre->adresse }}</p>
                    <p>Contact: {{ $contract->centre->contact }}</p>
                    <!-- Add more centre details as needed -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterContracts() {
            const searchValue = document.getElementById('search').value.toLowerCase();
            const rows = document.querySelectorAll('#contractTableBody tr');
            let hasVisibleRow = false;

            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                let rowContainsSearchTerm = false;

                for (let i = 0; i < cells.length; i++) {
                    if (cells[i].textContent.toLowerCase().includes(searchValue)) {
                        rowContainsSearchTerm = true;
                        break;
                    }
                }

                row.style.display = rowContainsSearchTerm ? '' : 'none';

                if (rowContainsSearchTerm) {
                    hasVisibleRow = true;
                }
            });

            document.getElementById('noResultsRow').style.display = hasVisibleRow ? 'none' : '';
        }

        function confirmDelete(contractId) {
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "Vous ne pourrez pas revenir en arrière!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + contractId).submit();
                }
            });
        }

        function updateStatus(contractId, selectElement) {
            const typeContract = selectElement.value;

            fetch(`/back/contracts/${contractId}`, {
                method: 'PUT', // Ensure the method matches the route
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ typeContract: typeContract })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Succès', 'Le statut a été mis à jour.', 'success');
                } else {
                    Swal.fire('Erreur', data.message || 'Erreur lors de la mise à jour du statut.', 'error');
                }
            })
            .catch(error => {
                Swal.fire('Erreur', 'Erreur lors de la mise à jour du statut.', 'error');
            });
        }

        document.querySelectorAll('.contract-end-date').forEach(function(td) {
            td.addEventListener('mouseover', function() {
                const duration = this.getAttribute('data-duree');
                const tooltip = document.createElement('span');
                tooltip.className = 'tooltip';
                tooltip.textContent = duration;
                tooltip.style.position = 'absolute';
                tooltip.style.backgroundColor = '#222E3C';
                tooltip.style.color = '#fff';
                tooltip.style.padding = '5px';
                tooltip.style.borderRadius = '4px';
                tooltip.style.top = `${this.offsetTop - 30}px`;
                tooltip.style.left = `${this.offsetLeft}px`;

                this.appendChild(tooltip);

                this.addEventListener('mouseleave', function() {
                    tooltip.remove();
                }, { once: true });
            });
        });

    </script>

    <?php

    function calculateContractDuration($months) {
        $years = intdiv($months, 12);
        $remainingMonths = $months % 12;
        $duration = [];

        if ($years > 0) {
            $duration[] = $years . ' ' . ($years > 1 ? 'ans' : 'ans');
        }
        if ($remainingMonths > 0) {
            $duration[] = $remainingMonths . ' ' . ($remainingMonths > 1 ? 'moi(s)' : 'moi(s)');
        }

        return implode(' ', $duration);
    }
    ?>
@endsection
