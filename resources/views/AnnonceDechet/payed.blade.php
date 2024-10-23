@extends('BackOffice.LayoutBack.layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-dark">
            <h2 class="text-center text-white">Procédure de paiement</h2>
        </div>
        <div class="card-body">
            <h4 class="text-center mb-4">Détails de l'annonce</h4>
            <p><strong>Description:</strong> {{ $annonce->description }}</p>
            <p><strong>Prix:</strong> {{ number_format($annonce->price, 2, ',', ' ') }} DT</p>

            <form id="payment-form" method="POST" action="{{ route('annoncedechets.handlePayment', $annonce->id) }}">
                @csrf
                <div class="form-group">
                    <label for="card-element">Carte Bancaire</label>
                    <div id="card-element" class="form-control">
                        <!-- Stripe Element sera inséré ici -->
                    </div>
                    <div id="card-errors" role="alert"></div>
                </div>
                <button id="submit" class="btn btn-success btn-lg mt-4">Payer {{ number_format($annonce->price, 2, ',', ' ') }} DT</button>
            </form>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var elements = stripe.elements();

    var card = elements.create('card', {
        style: {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        }
    });
    card.mount('#card-element');

    // Utilisation de la variable clientSecret
    var clientSecret = '{{ $clientSecret }}';

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(ev) {
        ev.preventDefault();
        stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: card,
                billing_details: {
                    name: '{{ auth()->user()->name }}',
                    email: '{{ auth()->user()->email }}',
                }
            }
        }).then(function(result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                if (result.paymentIntent.status === 'succeeded') {
                    form.submit();
                }
            }
        });
    });
</script>

@endsection
