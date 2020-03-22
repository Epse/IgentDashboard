@extends('layouts.app')
@section('title', 'Gebruikers')

@section('content')
    <div class="container-fluid">
        <h1>Gebruikers</h1>
        <table class="table table-hover">
            <thead>
                <th scope="col">Naam</th>
                <th scope="col">E-mail</th>
                <th scope="col">Rollen</th>
                <th scope="col">Acties</th>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->name }}</th>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles->implode('name', ', ') }}</td>
                        <td><a class="btn btn-primary" href="{{ route('users.edit', $user) }}">Bewerk</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
