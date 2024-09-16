@extends('layouts.app')

@section('content')
    @if (session('admin'))
        <div class="alert alert-warning">
            {{ session('admin') }}
        </div>
    @endif
<table>
    <thead>
    <tr>
        <th>Titre</th>
        <th>Likes</th>
        <th>Image</th>
        <th>Créateur</th>
        <th>Favori</th>

    </tr>
    </thead>
    <tbody>
    @if($plats->isEmpty())
        <tr>Il n'y a pas de plat enregistré</tr>
    @endif
    @foreach($plats as $plat)
        <tr>
            <td>{{ $plat->Titre }}</td>

            <td>{{ $plat->Likes }}</td>
            <td>
                @if($plat->Image)
                    <img src="{{ $plat->Image }}" alt="{{ $plat->Titre }}" >
                @else
                    Pas d'image

                @endif
            </td>
            <td>{{ $plat->user->name }}</td>
            <td>

                @if(auth()->user()->favoris()->where('plat_id', $plat->id)->exists())
                    Oui
                @else
                    Non
                @endif
            </td>
            <td>
                <a href="{{ route('plats.show', $plat) }}">Voir</a>
                <a href="{{ route('plats.edit', $plat) }}">Modifier</a>

                <form action="{{ route('plats.destroy', $plat) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Supprimer</button>
                </form>
            </td>
            <td>
                <form action="{{ route('toggle.favori', $plat) }}" method="POST">
                    @csrf
                    <button type="submit">
                        @if(auth()->user()->favoris()->where('plat_id', $plat->id)->exists())
                            Retirer des favoris
                        @else
                            Ajouter aux favoris
                        @endif

                    </button>
                </form>
            </td>

        </tr>
    @endforeach

    </tbody>

    <a href="{{route('plats.create')}}">Create</a>
</table>

<nav aria-label="Page navigation" >{{ $plats->links() }}</nav>
@endsection

