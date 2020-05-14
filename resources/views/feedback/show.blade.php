@extends('layouts.app')
@section('title', "Feedback {$feedback->id}")

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Feedback {{ $feedback->id }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                Gepubliceerd op: {{ $feedback->created_at->format('d/m/Y H:i:s') }}
                @unless (is_null($feedback->user))
                    door: {{ $feedback->user->name }}
                @endunless
            </div>
        </div>

        <div class="row">
            <div class="col">
                Ruimte: {{ $feedback->room  }}
            </div>
        </div>

        <div class="row">
            <div class="col">
                <h2>Korte omschrijving</h2>
                <p>
                    {{ $feedback->title }}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h2>Gedetaileerde beschrijving</h2>
                <p>
                    {{ $feedback->contents }}
                </p>
            </div>
        </div>

        @can('delete', $feedback)
        <div class="row">
            <div class="col">
                <form action="{{ route('feedbacks.destroy', $feedback) }}" method="post">
                    @csrf
                    @method('DESTROY')
                    <button class="btn btn-danger" type="submit">Verwijder</button>
                </form>
            </div>
        </div>
        @endcan
    </div>
@endsection
