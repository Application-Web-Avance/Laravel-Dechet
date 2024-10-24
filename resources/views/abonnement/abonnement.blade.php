@extends('BackOffice.LayoutBack.layout')
@include('BackOffice.gestionCollect.IndexCSS')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="content">
    <div class="row">
        <div class="col-12">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"style="color:green;">Liste des Abonnements</h3>
                    <a href="{{ url('/back/abonnement/create') }}" class="btn btn-primary btn-md">Add New</a>
                </div>
                <table class="table table-hover my-0 w-100"> <!-- Ensured the table takes full width -->
                    <thead>
                        <tr>
                            <th class="d-none d-xl-table-cell">Start Date</th>
                            <th>Abonnement</th>
                            <th>User</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Blocked</th> <!-- New column for blocked status -->
                            <th class="d-none d-md-table-cell">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($abonnement as $a)
                            <tr>
                                <td class="d-none d-xl-table-cell">{{ $a->date_debut }}</td>
                                <td class="d-none d-xl-table-cell">{{ $a->planAbonnement->type }}</td>
                                <td>{{ $a->user->name }}</td>

                                <td>
                                    @if ($a->image)
                                        <img src="{{ asset('storage/' . $a->image) }}" style="width: 50px; height: 50px;">
                                    @else
                                        <img src="{{ asset('path/to/default/image.jpg') }}" alt="Default Image" style="width: 50px; height: 50px;">
                                    @endif
                                </td>

                                <td>
                                    @if ($a->is_accepted)
                                        <span class="badge bg-success">Accepted</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($a->is_payed)
                                        <span class="badge bg-success">Payed</span>
                                    @else
                                        <span class="badge bg-danger">Not Payed</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($a->user->is_blocked)
                                        <span class="badge bg-danger">Blocked</span>
                                    @else
                                        <span class="badge bg-success">Active</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ url('/back/abonnement/' . $a->id . '/edit') }}" class="btn btn-link text-success" title="Edit">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <form action="{{ url('/back/abonnement/' . $a->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this abonnement?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger" title="Remove">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>

                                    <form action="{{ route('abonnement.updateStatus', $a->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-link text-info" title="Accept">
                                            <i class="fas fa-check"></i> {{ $a->is_accepted ? 'Revoke' : 'Accept' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('abonnement.updateBlockedStatus', $a->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-link text-warning" title="Block/Unblock">
                                            <i class="fas fa-user-lock"></i> {{ $a->user->is_blocked ? 'Unblock' : 'Block' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

<style>
/* Custom styles for buttons */
.btn-link {
    padding: 10px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.btn-link:hover {
    background-color: rgba(0, 0, 0, 0.1);
}

.table {
    width: 100%; /* Ensures the table takes full width */
}
</style>
