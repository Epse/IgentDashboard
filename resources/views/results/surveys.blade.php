@extends('layouts.app')
@section('title', 'Enquêteresultaten')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h1>Resultaten</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <survey-results
                    survey-index-url="{{ route('surveys.index') }}"
                ></survey-results>
            </div>
        </div>
    </div>
@endsection
