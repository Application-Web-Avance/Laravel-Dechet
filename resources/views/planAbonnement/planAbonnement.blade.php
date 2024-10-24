@extends('BackOffice.LayoutBack.layout')
@include('BackOffice.gestionCollect.IndexCSS')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <main class="content">
                <div class="row">
                    <div class="col-12 col-lg-12 col-xxl-9 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <a href="{{ url('/back/planabonnement/create') }}" class="btn btn-primary btn-md">
                                    New
                                </a>
                            </div>
                            <table class="table table-hover my-0">
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
                                                <!-- Update button -->
                                                <a href="{{ url('/back/planabonnement/' . $a->id . '/edit') }}" class="btn btn-link text-success" style="text-decoration:none;" title="Edit">
                                                    Update
                                                </a>

                                                <!-- Delete form -->
                                                <form action="{{ route('planabonnement.destroy', $a->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger" style="text-decoration:none;" title="Delete">
                                                        Delete
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
