@extends('BackOffice.LayoutBack.layout')

@section('content')

<div class="container-fluid p-0">

<h1 class="mb-4">Liste des Personnes de {{$name}}</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Âge</th>
                </tr>
            </thead>
            <tbody>
                @foreach($personnes as $personne)
                    <tr>
                        <td>{{ $personne['nom'] }}</td> 
                        <td>{{ $personne['prenom'] }}</td>
                        <td>{{ $personne['age'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
 @endsection