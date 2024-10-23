@extends('BackOffice.LayoutBack.layout')
@include('BackOffice.gestionCollect.IndexCSS')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container">
    <h1>Listes des annonces des déchets</h1>
      <form action="{{ route('annoncedechets.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Rechercher par adresse, type de déchet..." value="{{ request()->query('search') }}">
                <button type="submit" class="btn btn-primary" style="border-radius:10px">Rechercher</button>
            </div>
        </form>
<a href="{{ route('annoncedechets.create') }}" class="btn btn-primary" style="margin-left:80% ;border-radius:10px" >Créer une annonce</a>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

 <table class="table table-hover my-0">
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
                    <td class="badge  {{ $annonce->status === 'disponible' ? 'bg-success' : 'bg-danger' }}" style="margin-top: 45px; border-radius: 20px; width: 90px;">
                        {{ $annonce->status }}
                    </td>

                    <td>{{ $annonce->date_demande }}</td>
                    <td>{{ $annonce->adresse_collecte }}</td>
                    <td>{{ $annonce->quantite_totale }}</td>
                    <td>{{ $annonce->price }}</td>
                    <td>{{ $annonce->type_dechet }}</td>
                  <td>
                      <a href="{{ route('annoncedechets.show', $annonce->id) }}" class="btn btn-info btn-sm d-inline-flex align-items-center" style="border-radius: 20px; padding: 5px 15px;">
                          <i class="fas fa-eye"></i>&nbsp;Voir
                      </a>
                      <a href="{{ route('annoncedechets.edit', $annonce->id) }}" class="btn btn-warning btn-sm d-inline-flex align-items-center" style="border-radius: 20px; padding: 5px 15px;">
                          <i class="fas fa-edit"></i>&nbsp;Modifier
                      </a>
                      <form action="{{ route('annoncedechets.destroy', $annonce->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Voulez-vous vraiment supprimer cette annonce ?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm d-inline-flex align-items-center" style="border-radius: 20px; padding: 5px 15px;">
                              <i class="fas fa-trash"></i>&nbsp;Supprimer
                          </button>
                      </form>
                  </td>

                </tr>
            @endforeach
        </tbody>
    </table>

     <div class="mt-3">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item {{ $annonces->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link rounded-circle" href="{{ $annonces->previousPageUrl() }}"
                                                tabindex="-1">
                                                <i class="align-middle" data-feather="chevron-left"></i>
                                            </a>
                                        </li>
                                        @for ($i = 1; $i <= $annonces->lastPage(); $i++)
                                            <li class="page-item {{ $i == $annonces->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $annonces->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor
                                        <li class="page-item {{ $annonces->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link rounded-circle" href="{{ $annonces->nextPageUrl() }}">
                                                <i class="align-middle" data-feather="chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
      </div>



</div>
@endsection
