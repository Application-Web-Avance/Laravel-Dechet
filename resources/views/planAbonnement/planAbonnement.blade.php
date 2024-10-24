@extends('BackOffice.LayoutBack.layout')
@include('BackOffice.gestionCollect.IndexCSS')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="content">
    <div class="row">
        <div class="col-12">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"style="color:green;">Liste des Plans</h3>

                    <a href="{{ url('/back/planabonnement/create') }}" class="btn btn-primary btn-md">Add New</a>
                </div>
                <table class="table table-hover my-0 w-100"> <!-- Table taking full width -->
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th class="d-none d-md-table-cell">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($planAbonnement as $a)
                            <tr>
                                <td>{{ $a->type }}</td>
                                <td>{{ $a->price }}</td>
                                <td>{{ $a->description }}</td>
                                <td>
                                    @if ($a->image)
                                        <img src="{{ asset('storage/' . $a->image) }}" style="width: 50px; height: 50px;">
                                    @else
                                        <img src="{{ asset('path/to/default/image.jpg') }}" alt="Default Image" style="width: 50px; height: 50px;">
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('/back/planabonnement/' . $a->id . '/edit') }}" class="btn btn-link text-success" title="Edit">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <form action="{{ route('planabonnement.destroy', $a->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger" title="Delete">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Error Validation -->
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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

.card-header {
    background-color: #f8f9fa; /* Light background for header */
    border-bottom: 1px solid #dee2e6; /* Border for separation */
}
</style>
