@extends('BackOffice.LayoutBack.layout')
@include('BackOffice.gestionCollect.IndexCSS')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <main class="content">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Create Plan Abonnement</h5>
                    </div>
                    <div class="card-body">

                        <!-- Form starts here -->
                        <form action="{{ route('planabonnement.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf <!-- Add CSRF token for form security -->

                            <!-- Type as Select Options -->
                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" name="type" id="type" required>
                                    <option value="" disabled selected>Select type</option>
                                    <option value="mensuel">Mensuel</option>
                                    <option value="trimestriel">Trimestriel</option>
                                    <option value="semestriel">Semestriel</option>
                                    <option value="annuel">Annuel</option>
                                </select>
                            </div>

                            <!-- Price -->
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" name="price" id="price" required>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" class="form-control" name="description" id="description" required>
                            </div>

                            <!-- Image Upload -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Image</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                            </div>

                            <!-- Submit Button -->
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary" style="width: 100px;">Submit</button>
                            </div>
                        </form>
                        <!-- End of form -->

                    </div>
                </div>
            </main>
            @endsection
