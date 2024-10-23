@extends('BackOffice.LayoutBack.layout')
@include('BackOffice.gestionCollect.IndexCSS')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Liste des paiements</h2>
    <form action="{{ route('paymentdechet.index') }}" method="GET" class="mb-4">
               <div class="input-group">
                   <input type="text" name="search" class="form-control" placeholder="Rechercher par adresse, type de déchet..." value="{{ request()->query('search') }}">
                   <button type="submit" class="btn btn-primary">Rechercher</button>
               </div>
           </form>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Utilisateur</th>
                    <th>Annonce</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Status</th>
                    <th>Date de paiement</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->utilisateur->name ?? 'Utilisateur non trouvé' }}</td>
                        <td>{{ $payment->annonceDechet->type_dechet ?? 'Annonce non trouvée' }}</td>
                        <td>{{ number_format($payment->price, 2, ',', ' ') }} DT</td>
                        <td>{{ $payment->quantité }} kg</td>
                        <td>
                            <span class="badge {{ $payment->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($payment->payment_status) }}
                            </span>
                        </td>
                        <td>{{ $payment->payment_date }}</td>
                        <td>
                            <a href="{{ route('paymentdechet.show', $payment->id) }}" class="btn btn-info">Voir</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

          <div class="mt-3">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item {{ $payments->onFirstPage() ? 'disabled' : '' }}">
                                                    <a class="page-link rounded-circle" href="{{ $payments->previousPageUrl() }}"
                                                        tabindex="-1">
                                                        <i class="align-middle" data-feather="chevron-left"></i>
                                                    </a>
                                                </li>
                                                @for ($i = 1; $i <= $payments->lastPage(); $i++)
                                                    <li class="page-item {{ $i == $payments->currentPage() ? 'active' : '' }}">
                                                        <a class="page-link" href="{{ $payments->url($i) }}">{{ $i }}</a>
                                                    </li>
                                                @endfor
                                                <li class="page-item {{ $payments->hasMorePages() ? '' : 'disabled' }}">
                                                    <a class="page-link rounded-circle" href="{{ $payments->nextPageUrl() }}">
                                                        <i class="align-middle" data-feather="chevron-right"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
              </div>

    </div>


</div>
@endsection
