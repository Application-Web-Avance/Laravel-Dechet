@extends('FrontOffice.LayoutFront.layout')
@section('content')

<!-- Feature Start -->
<div class="container-fluid feature bg-light py-5">
    <div class="container py-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h4 class="text-primary">Our Plans</h4>
            <h1 class="display-4 mb-4">Choose the Best Plan for You</h1>
            <p class="mb-0">Explore our flexible and affordable plans designed to meet your needs.</p>
        </div>
        <div class="row g-4">
            @foreach($plans as $plan)
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.2s">
                <div class="feature-item p-4 pt-0">
                    <div class="feature-icon p-4 mb-4">
                        @if($plan->image)
                            <img src="{{ asset('storage/' . $plan->image) }}" alt="{{ $plan->type }}" class="img-fluid">
                        @else
                            <i class="fa fa-bullseye fa-3x"></i>
                        @endif
                    </div>
                    <h4 class="mb-4">{{ $plan->type }}</h4>
                    <p class="mb-4">{{ $plan->description }}</p>
                    <p class="mb-4">Price: ${{ $plan->price }}</p>
                    <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Learn More</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Feature End -->

@endsection
