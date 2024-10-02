@extends('BackOffice.LayoutBack.layout')

@section('content')
<div class="container">
    <h1>Demandes de collecte</h1>
    <a href="{{ route('demandecollectes.create') }}" class="btn btn-primary">Nouvelle demande</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Status</th>
                <th>Adresse</th>
                <th>Quantité Totale</th>
                <th>description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($demandes as $demande)
                <tr>
                    <td>{{ $demande->date_demande }}</td>
                    <td>{{ $demande->status }}</td>
                    <td>{{ $demande->adresse_collecte }}</td>
                    <td>{{ $demande->quantite_totale }}</td>
                     <td>{{ $demande->description }}</td>
                    <td>
                        <a  class="btn btn-info">Voir</a>
                        <a class="btn btn-warning">Modifier</a>
                        <form  method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
