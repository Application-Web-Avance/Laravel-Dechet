@extends('BackOffice.LayoutBack.layout')

@section('content')
<style>
    .pagination {
        margin: 1rem 0;
        display: flex;
        justify-content: center;
        align-items: center;
        list-style: none;
    }

    .pagination .page-item {
        margin: 0 0.25rem;
    }

    .pagination .page-link {
        border: 1px solid #007bff;
        border-radius: 50%;
        color: #007bff;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
    }

    .pagination .page-link:hover:not(.disabled) {
        background-color: rgba(0, 123, 255, 0.1);
    }
</style>

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <div class="card flex-fill">
                <div class="card-header">
                    <h2 class="card-title mb-0">Participants de l'Événement</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <input type="text" id="search" class="form-control"
                               placeholder="Rechercher dans les participants" onkeyup="filterParticipants()">
                    </div>
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="participantsTableBody">
                            @if ($participants->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">Aucun participant trouvé.</td>
                                </tr>
                            @else
                                @foreach ($participants as $participant)
                                    <tr>
                                        <td>{{ $participant->name }}</td>
                                        <td>{{ $participant->email }}</td>
                                        <td>{{ $participant->telephone }}</td>
                                        <td>
                                            <form action="{{ route('participants.destroy', [$event->id, $participant->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce participant ?');">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>

                    </table>


                    <div class="mt-3">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item {{ $participants->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link rounded-circle" href="{{ $participants->previousPageUrl() }}" tabindex="-1">
                                        <i class="align-middle" data-feather="chevron-left"></i>
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $participants->lastPage(); $i++)
                                    <li class="page-item {{ $i == $participants->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $participants->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ $participants->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link rounded-circle" href="{{ $participants->nextPageUrl() }}">
                                        <i class="align-middle" data-feather="chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div>
                        <a href="{{ route('evenement.index') }}" class="btn btn-secondary">Retour</a>
                    </div>
                    
                </div> <!-- END: Card Body -->
            </div> <!-- END: Card -->
        </div> <!-- END: Column -->
    </div> <!-- END: Row -->
</div>

<script>
    function filterParticipants() {
        const searchValue = document.getElementById('search').value.toLowerCase();
        const rows = document.querySelectorAll('#participantsTableBody tr');

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
        });
    }
</script>
@endsection
