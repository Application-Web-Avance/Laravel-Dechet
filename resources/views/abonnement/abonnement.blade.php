@extends('BackOffice.LayoutBack.layout')
@include('BackOffice.gestionCollect.IndexCSS')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <main class="content">
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-9 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <a href="{{ url('/back/abonnement/create') }}" type="button" class="btn btn-primary btn-md">New</a>
                            </div>
                            <table class="table table-hover my-0">
                                <thead>
                                    <tr>
                                        <th class="d-none d-xl-table-cell">Start Date</th>
                                        <th>Abonnement</th>
                                        <th>User</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Payment</th>
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

                                            <!-- Display the is_accepted status -->
                                            <td>
                                                @if ($a->is_accepted)
                                                    <span class="badge bg-success">Accepted</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>

                                            <!-- Display the is_payed status -->
                                            <td>
                                                @if ($a->is_payed)
                                                    <span class="badge bg-success">Payed</span>
                                                @else
                                                    <span class="badge bg-danger">Not Payed</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ url('/back/abonnement/' . $a->id . '/edit') }}" class="btn btn-link text-success" style="text-decoration:none;" title="edit">Update</a>
                                                <form action="{{ url('/back/abonnement/' . $a->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this abonnement?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger" style="text-decoration:none;" title="Remove">Delete</button>
                                                </form>

                                                <!-- Button to change the status -->
                                                <form action="{{ route('abonnement.updateStatus', $a->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-link text-info" style="text-decoration:none;">
                                                        {{ $a->is_accepted ? 'Revoke' : 'Accept' }}
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
