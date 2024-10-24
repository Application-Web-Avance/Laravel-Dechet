@extends('FrontOffice.LayoutFront.layout')

@section('content')
    <!-- Feature Start -->
    <div class="container-fluid feature bg-light py-5">
        <div class="container">


            <!-- Subscription Status Section -->
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8">
                    <div
                        class="subscription-status-wrapper p-4 bg-white shadow-sm rounded d-flex justify-content-center align-items-center">
                        @if (!empty($statusData) && isset($statusData['status']))
                            @switch($statusData['status'])
                                @case('trial')
                                    <span class="alert alert-warning text-center">
                                        {{ $statusData['message'] ?? 'Your free trial ends in ' . $statusData['days_remaining'] . ' days' }}
                                    </span>
                                @break

                                @case('active')
                                    <span class="alert alert-success text-center">
                                        {{ $statusData['message'] ?? 'Active Plan: ' . ucfirst($statusData['plan']) . '. Your subscription ends in ' . $statusData['days_remaining'] . ' days.' }}
                                    </span>
                                @break

                                @case('pending')
                                    <span class="alert alert-info text-center">
                                        {{ $statusData['message'] ?? 'Your abonnement will be active in ' . $statusData['days_until_active'] . ' days.' }}
                                    </span>
                                @break

                                @case('expired')
                                    <span class="alert alert-danger text-center">
                                        {{ $statusData['message'] ?? 'Your subscription has expired.' }}
                                    </span>
                                @break

                                @default
                                    <span class="alert alert-danger text-center">Unknown subscription status.</span>
                            @endswitch
                        @else
                            <span class="alert alert-danger text-center">No Subscription Info Available</span>
                        @endif
                    </div>
                </div>
            </div>
            <!-- End Subscription Status Section -->

            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">Our Plans</h4>
                <h1 class="display-4 mb-4">Choose the Best Plan for You</h1>
                <p class="mb-0">Explore our flexible and affordable plans designed to meet your needs.</p>
            </div>

            <div class="row g-4">
                @foreach ($plans as $plan)
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="feature-item p-4 pt-0">
                            <div class="feature-icon p-4 mb-4">
                                @if ($plan->image)
                                    <img src="{{ asset('storage/' . $plan->image) }}" alt="{{ $plan->type }}"
                                        class="img-fluid">
                                @else
                                    <i class="fa fa-bullseye fa-3x"></i>
                                @endif
                            </div>
                            <h4 class="mb-4">{{ $plan->type }}</h4>
                            <p class="mb-4">{{ $plan->description }}</p>
                            <p class="mb-4">Price: ${{ $plan->price }}</p>

                            <!-- Subscribe Now Button -->
                            <button type="button" class="btn btn-dark rounded-pill py-3 px-4 px-md-5 me-2"
                                data-toggle="modal" data-target="#subscribeModal" data-plan-id="{{ $plan->id }}">
                                Subscribe Now
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Feature End -->

    <!-- Modal for Date Selection -->
    <div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="subscribeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('abonnement.test', $plan->id) }}" method="POST">
                    @csrf
                    <div class="modal-header" style="margin-top: 20px;margin-bottom: 20px ">
                        <h5 class="modal-title" id="subscribeModalLabel">Choose start date for your subscription</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="plan_id" id="plan_id">
                        <div class="form-group">
                            <input type="date" id="date_debut" name="date_debut" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center mt-4">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-dark rounded-pill">Payer
                                {{ number_format($plan->price, 2, ',', ' ') }} DT</button>
                            <button type="button" class="btn btn-light rounded-pill"
                                style="padding-left: 30px;padding-right: 30px" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Alert Notification -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subscribeButtons = document.querySelectorAll('button[data-target="#subscribeModal"]');
            subscribeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const planId = this.getAttribute('data-plan-id');
                    document.getElementById('plan_id').value = planId;
                });
            });

            document.getElementById('subscribeForm').addEventListener('submit', function(event) {
                event.preventDefault();

                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Your subscription request has been submitted",
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(() => {
                    this.submit();
                }, 2000);
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
@endsection
