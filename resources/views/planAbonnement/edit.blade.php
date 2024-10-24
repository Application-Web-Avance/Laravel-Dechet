@extends('BackOffice.LayoutBack.layout')
@include('BackOffice.gestionCollect.IndexCSS')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="content">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit Plan Abonnement</h5>
        </div>
        <div class="card-body">
            <!-- Form starts here -->
            <form action="{{ route('planabonnement.update', $planAbonnement->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                <!-- Type as Select Options -->
                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-control" name="type" id="type" required>
                        <option value="" disabled>Select type</option>
                        <option value="mensuel" {{ old('type', $planAbonnement->type) == 'mensuel' ? 'selected' : '' }}>Mensuel</option>
                        <option value="trimestriel" {{ old('type', $planAbonnement->type) == 'trimestriel' ? 'selected' : '' }}>Trimestriel</option>
                        <option value="semestriel" {{ old('type', $planAbonnement->type) == 'semestriel' ? 'selected' : '' }}>Semestriel</option>
                        <option value="annuel" {{ old('type', $planAbonnement->type) == 'annuel' ? 'selected' : '' }}>Annuel</option>
                    </select>
                    @error('type')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Price -->
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" class="form-control" name="price" id="price" value="{{ old('price', $planAbonnement->price) }}" required>
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control" name="description" id="description" value="{{ old('description', $planAbonnement->description) }}" required>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Image</label>
                    <input type="file" class="form-control" name="image" accept="image/*">
                    <!-- Display existing image if it exists -->
                    @if($planAbonnement->image)
                        <p>Current image: <img src="{{ asset('storage/' . $planAbonnement->image) }}" alt="Plan Abonnement Image" style="width: 100px;"></p>
                    @endif
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" style="width: 100px;">Update</button>
                </div>
            </form>

            <!-- End of form -->
        </div>
    </div>
</main>
@endsection
