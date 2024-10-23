@extends('BackOffice.LayoutBack.layout')
@include('BackOffice.gestionCollect.IndexCSS')

@section('content')
<div class="container">
    <h2>Historique des Paiements</h2>

    @if($payments->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Montant</th>
                    <th>Quantité</th>
                    <th>Status de Paiement</th>
                    <th>Date de Paiement</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $payment->price }} TND</td>
                        <td>{{ $payment->quantité }}</td>
                        <td>{{ ucfirst($payment->payment_status) }}</td>
                        <td>{{ $payment->payment_date }}</td>
                        <td>
                            <a href="{{ route('payment.receipt', $payment->id) }}" class="btn btn-sm btn-primary">Télécharger le Reçu</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $payments->links() }}
    @else
        <p>Aucun paiement trouvé.</p>
    @endif
</div>
@endsection
