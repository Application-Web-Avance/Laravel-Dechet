@extends('BackOffice.LayoutBack.layout')
@include('BackOffice.gestionCollect.IndexCSS')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <main class="content">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Create Abonnement</h5>
                    </div>
                    <div class="card-body">

                        <!-- Form starts here -->
                        <form action="{{ route('abonnement.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf <!-- Add CSRF token for form security -->

                            <!-- Select Plan Abonnement -->
                            <div class="mb-3">
                                <label for="plan_abonnement_id" class="form-label">Select Plan Abonnement</label>
                                <select class="form-select" name="plan_abonnement_id" id="plan_abonnement_id" required>
                                    <option selected disabled>Select a plan</option>
                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Select User -->
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Select User</label>
                                <select class="form-select" name="user_id" id="user_id" required>
                                    <option selected disabled>Select a user</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date Input -->
                            <div class="mb-3">
                                <label for="date_debut" class="form-label">Start Date</label>
                                <input type="date" class="form-control" name="date_debut" id="date_debut" required>
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
