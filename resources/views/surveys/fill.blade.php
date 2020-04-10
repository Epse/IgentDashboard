@extends('layouts.app')
@section('title', "Invullen enquête {$survey->id}")

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>{{ $survey->title }}</h1>
                <p>
                    {{ $survey->description }}
                </p>
            </div>
        </div>

        <hr/>

        <form action="{{ route('surveys.fill', $survey) }}" method="post">
            @csrf

            @foreach ($questions as $question)
                <div class="row">
                    <div class="col">
                        <h3>{{ $question->question }}</h3>
                        <div class="form-group">
                        @if ($question->type == 'boolean')
                            {{-- Radio buttons --}}
                            <div class="form-check">
                                <input class="form-check-input" id="response{{ $question->id }}" name="response[{{ $question->id }}]" type="radio" value="1" required />
                                <label class="form-check-label" for="response{{ $question->id }}">Ja</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="response{{ $question->id }}" name="response[{{ $question->id }}]" type="radio" value="0" required />
                                <label class="form-check-label" for="response{{ $question->id }}">Neen</label>
                            </div>
                        @elseif ($question->type == 'scale')
                            {{-- More radio buttons?? --}}
                            <input class="form-control-range" name="response[{{ $question->id }}]" type="range" min="0" max="10" step="1" value="5" required />
                            <small class="form-text text-muted">Links is 0, rechts is 10.</small>
                        @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="row">
                <div class="col">
                    <button class="btn btn-primary" type="submit">Verzenden</button>
                </div>
            </div>
        </form>
    </div>
@endsection
