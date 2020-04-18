@extends('layouts.app')
@section('title', "Enquête {$survey->id}")

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>
                    Enquête {{ $survey->id }}
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h2>Titel</h2>
                <p>
                    {{ $survey->title }}
                </p>

                <h2>Beschrijving</h2>
                <p>
                    {{ $survey->description }}
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <h2>Vragen</h2>
            </div>
        </div>

        @foreach ($survey->questions as $question)
            <div class="row">
                <div class="col">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h3 class="card-title">{{ $question->question }}</h3>
                            <h4 class="card-subtitle mb-2 text-muted">{{ $question->type }}</h4>
                            <form action="{{ route('questions.destroy', $question) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Verwijder</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="row">
            <div class="col">
                <div class="card mb-3">
                    <div class="card-body">
                        <h3 class="card-title">Nieuwe vraag</h3>
                        <form action="{{ route('surveys.questions.store', $survey) }}" method="post">
                            @csrf

                            @error('question')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="question">Vraag</label>
                                <input name="question" id="question" class="form-control" type="text" value="{{ old('question') }}" />
                            </div>

                            @error('type')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="boolean">Ja - Nee</option>
                                    <option value="scale">Schaal</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <p class="form-text">Indien je het type 'schaal' koos, kan je hier een minimum en maximum instellen.</p>
                                <label for="min">Minimale waarde</label>
                                <input name="min" id="min" step="1" class="form-control" type="number" value="{{ old('min') }}"/>
                                <label for="max">Maximale waarde</label>
                                <input name="max" id="max" step="1" class="form-control" type="number" value="{{ old('max') }}"/>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Opslaan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
