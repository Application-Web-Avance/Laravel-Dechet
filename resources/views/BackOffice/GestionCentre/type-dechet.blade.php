@extends('BackOffice.LayoutBack.layout')

@section('content')
    <form action="{{ route('type-dechets.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="type" class="form-label">Type de déchet</label>
            <input type="text" name="type" id="type" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Ajouter Type de déchet</button>
    </form>
@endsection
