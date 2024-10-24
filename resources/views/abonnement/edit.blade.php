@extends('BackOffice.LayoutBack.layout')
@include('BackOffice.gestionCollect.IndexCSS')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="content">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit Abonnement</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('abonnement.update', $abonnement->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT') <!-- Indicate that this is a PUT request -->

                <!-- Select Plan Abonnement -->
                <div class="mb-3">
                    <label for="plan_abonnement_id" class="form-label">Select Plan Abonnement</label>
                    <select class="form-select @error('plan_abonnement_id') is-invalid @enderror" name="plan_abonnement_id" id="plan_abonnement_id" required>
                        <option selected disabled>Select a plan</option>
                        @foreach ($plans as $plan)
                            <option value="{{ $plan->id }}" {{ $plan->id == $abonnement->plan_abonnement_id ? 'selected' : '' }}>
                                {{ $plan->type }} - ${{ $plan->price }}
                            </option>
                        @endforeach
                    </select>
                    @error('plan_abonnement_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date Input -->
                <div class="mb-3">
                    <label for="date_debut" class="form-label">Start Date</label>
                    <input type="date" class="form-control @error('date_debut') is-invalid @enderror" name="date_debut" id="date_debut" value="{{ old('date_debut', $abonnement->date_debut) }}" required>
                    @error('date_debut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div class="mb-3">
                    <label for="image" class="form-label">Upload New Image (optional)</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
                    @if ($abonnement->image)
                        <p>Current Image: <img src="{{ asset('storage/' . $abonnement->image) }}" alt="Current Image" style="max-width: 100px;"></p>
                    @endif
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
