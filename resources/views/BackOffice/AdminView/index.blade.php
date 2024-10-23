@include('BackOffice.gestionCollect.IndexCSS')

@extends('BackOffice.LayoutBack.layout')

@section('content')
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex justify-content-between mb-3">
                            <h2 class="card-title mb-0">Liste des utilisateurs vérifiés</h2>
                            <a href="{{ route('evenement.create') }}" class="btn btn-primary">Ajouter un Utilisateur</a>
                        </div>
                        <input type="text" id="search" class="form-control"
                            placeholder="Rechercher dans les utilisateurs" onkeyup="filterUsers()">
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover my-0">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle Demandé</th>
                                    <th>Nom du Centre</th>
                                    <th>CIN</th>
                                    <th>Téléphone</th>
                                    <th>Preuve PDF</th>
                                    <th>Actions</th> <!-- New Actions header -->
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                @if ($users->isEmpty())
                                    <tr id="noResultsRow">
                                        <td colspan="8" class="text-center">Aucun utilisateur vérifié trouvé.</td>
                                    </tr>
                                @else
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->demandeRole->role_requested ?? 'N/A' }}</td>
                                            <td>{{ $user->demandeRole->nom_centre ?? 'N/A' }}</td>
                                            <td>{{ $user->cin ?? 'N/A' }}</td>
                                            <td>{{ $user->telephone ?? 'N/A' }}</td>
                                            <td>
                                                @if ($user->demandeRole && $user->demandeRole->proof_pdf)
                                                    <a href="{{ asset('storage/' . $user->demandeRole->proof_pdf) }}" target="_blank">Voir PDF</a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('users.accept', $user->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">Accepter</button>
                                                </form>
                                                <form action="{{ route('users.reject', $user->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm">Refuser</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr id="noResultsRow" style="display: none;">
                                        <td colspan="8" class="text-center">Aucun résultat trouvé.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link rounded-circle" href="{{ $users->previousPageUrl() }}" tabindex="-1">
                                            <i class="align-middle" data-feather="chevron-left"></i>
                                        </a>
                                    </li>
                                    @for ($i = 1; $i <= $users->lastPage(); $i++)
                                        <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                                        <a class="page-link rounded-circle" href="{{ $users->nextPageUrl() }}">
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
        function filterUsers() {
            const searchValue = document.getElementById('search').value.toLowerCase();
            const rows = document.querySelectorAll('#userTableBody tr');
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
    </script>
@endsection
