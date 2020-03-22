@extends('layouts.app')
@section('title', "Bewerk gebruiker: {$user->name}")

@section('content')
    <div class="container-fluid">
        <h1>{{ $user->name }}</h1>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <p>
            In de kolom <i>Huidig</i> zie je of de gebruiker momenteel een rol heeft.
            In de kolom <i>Keuze</i> kan je aanduiden of je wilt dat de gebruiker deze rol heeft.
        </p>
        <form action="{{ route('users.update', $user) }}" method="post">
            @csrf
            @method('PUT')

            {{-- Temp until you can edit this --}}
            <input name="name" type="hidden" value="{{ $user->name }}"/>
            <input name="email" type="hidden" value="{{ $user->email }}"/>

            <input name="roles[]" type="hidden" value=""/>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Opslaan</button>
            </div>
            <table class="table table-hover">
                <thead>
                    <th role="col">Rol</th>
                    <th role="col">Huidig</th>
                    <th role="col">Keuze</th>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <th scope="row">{{ $role->name }}</th>
                            @if ($user->hasRole($role))
                                <td><input type="checkbox" checked disabled/></td>
                                <td><input name="roles[]" type="checkbox" value="{{ $role->name }}" checked /></td>
                            @else
                                <td><input type="checkbox" disabled/></td>
                                <td><input name="roles[]" type="checkbox" value="{{ $role->name }}" /></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
@endsection
