@extends('BackOffice.LayoutBack.layout')

@section('content')
<div class="container">
    <h1>Listes des annonces des déchets</h1>
    <a href="{{ route('AnnonceDechet.create') }}" class="btn btn-primary" style="margin-left:80% ;border-radius:10%" >Créer une annonce</a>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif 

    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Status</th>
                <th>Date</th>
                <th>Adresse</th>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Type</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($annonces as $annonce)
                <tr>
                    <td>
                        @if($annonce->image)
                            <img src="{{ asset('storage/' . $annonce->image) }}" alt="Image de l'annonce" class="img-fluid" style="max-width: 150px; border-radius:20%">
                        @else
                            <img src="https://jolymome.fr/storage/articles/2022-03-f7bc5c6e88d5a711e303ba18ccf474c8.webp" alt="Image de l'annonce" style="max-width: 100px; border-radius:20%"/>
                        @endif
                    </td>
                    <td class="badge {{ $annonce->status === 'disponible' ? 'bg-success' : 'bg-danger' }}" style="margin-top: 45px; border-radius: 20%; width: 100px;">
                        {{ $annonce->status }}
                    </td>

                    <td>{{ $annonce->date_demande }}</td>
                    <td>{{ $annonce->adresse_collecte }}</td>
                    <td>{{ $annonce->quantite_totale }}</td>
                    <td>{{ $annonce->price }}</td>
                    <td>{{ $annonce->type_dechet }}</td>
                    <td>
                        <a href="{{ route('AnnonceDechet.show', $annonce->id) }}" class="btn btn-info" style="width: 100px; border-radius:20%">Voir</a>
                        <a href="{{ route('AnnonceDechet.edit', $annonce->id) }}" class="btn btn-warning" style="max-width: 100px; border-radius:20%">Modifier</a>
                        <form action="{{ route('AnnonceDechet.destroy', $annonce->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Voulez-vous vraiment supprimer cette annonce ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="max-width: 100px; border-radius:20%">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

   

</div>
@endsection
