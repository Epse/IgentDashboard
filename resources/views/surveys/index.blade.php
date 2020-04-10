@extends('layouts.app')
@section('title', 'Alle enquêtes')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>Alle enquêtes</h1>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-hover">
                    <thead>
                        <th scope="col">Titel</th>
                        <th scope="col">Aantal vragen</th>
                        <th scope="col">Acties</th>
                    </thead>
                    <tbody>
                        @foreach ($surveys as $survey)
                            <tr>
                                <th scope="row">{{ $survey->title }}</th>
                                <td>{{ $survey->questions()->count() }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('surveys.edit', $survey) }}">Bewerk</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
