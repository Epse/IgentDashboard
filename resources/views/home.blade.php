@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="row justify-content-center mb-3">
                <div class="col-md-8">
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                </div>
            </div>
        @endif

        <h2>Openstaande enquêtes</h2>

        @foreach ($surveys as $survey)
            <div class="row justify-content-center mb-3">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            {{ $survey->title }}
                            @if ($survey->answered)
                            <span class="badge badge-secondary">Ingevuld</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <p>
                                {{ $survey->description }}
                            </p>
                            <a href="{{ route('surveys.fill', $survey) }}" class="btn btn-primary">Vul in</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
