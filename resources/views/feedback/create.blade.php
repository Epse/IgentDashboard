@extends('layouts.app')
@section('title', 'Verstuur feedback')

@section('content')
    <div class="container">
        <div class="row">
            <h1>Verstuur feedback</h1>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{ route('feedbacks.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="room">Ruimte</label>
                        <input type="text" name="room" id="room" class="form-control" value="{{ old('room') }}" />
                    </div>
                    <div class="form-group">
                        <label for="title">Korte beschrijving van je feedback</label>
                        <input name="title" class="form-control" id="title" type="text" value="{{ old('contents') }}" />
                    </div>
                    <div class="form-group">
                        <label for="contents">Beschrijf je feedback in detail</label>
                        <textarea cols="30" id="contents" class="form-control" name="contents" rows="10">{{ old('contents') }}</textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Verzenden</button>
                </form>
            </div>
        </div>
    </div>
@endsection
