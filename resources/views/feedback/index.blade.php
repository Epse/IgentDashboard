@extends('layouts.app')
@section('title', 'Feedback')

@section('content')
    <div class="container-fluid">
        <div class="row"><div class="col">
            <h1>Recente feedback</h1>
        </div></div>
        <div class="row">
            <div class="col">
                <table class="table table-hover">
                    <thead>
                        <th scope="col">Korte omschrijving</th>
                        <th scope="col">Datum</th>
                        <th scope="col">Inhoud</th>
                        <th scope="col">Acties</th>
                    </thead>
                    <tbody>
                        @foreach ($feedbacks as $feedback)
                            <tr>
                                <td>{{ $feedback->title }}</td>
                                <td>{{ $feedback->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ Str::limit($feedback->contents, 50) }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('feedbacks.show', $feedback) }}">
                                        Bekijk
                                    </a>
                                    @can ('delete', $feedback)
                                    <form class="d-inline" action="{{ route('feedbacks.destroy', $feedback) }}" method="post">
                                        @csrf
                                        @method('DESTROY')
                                        <button class="btn btn-danger" type="submit">Verwijder</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $feedbacks->links() }}
            </div>
        </div>
    </div>
@endsection
