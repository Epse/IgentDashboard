@extends('layouts.app')
@section('title', 'Nieuwe enquête')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Nieuwe enquête</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('surveys.store') }}" method="post">
                    @csrf

                    {{-- TODO: errors --}}

                    @error('title')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                    @enderror
                    <div class="form-group">
                        <label for="title">Titel</label>
                        <input id="title" class="form-control" name="title" type="text" value="{{ old('title') }}" />
                    </div>

                    @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="description">Beschrijving</label>
                        <textarea class="form-control" cols="30" id="" name="description" id="description" rows="10">{{ old('description') }}</textarea>
                    </div>

                    <p>
                        Vragen kan je toevoegen na het aanmaken van de enquête.
                    </p>

                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Opslaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
