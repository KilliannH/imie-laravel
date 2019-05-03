@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-bottom: 30px">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('post-new-tweet', [
                            'content' => 'content'
                        ]) }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Message') }}</label>

                            <div class="col-md-6">
                                <input id="content" type="text" class="form-control @error('name') is-invalid @enderror" name="content" value="{{ old('content') }}" required autocomplete="content" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                {{ __("Tweeter") }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tweets</div>

                <div class="card-body">
                    @foreach ($tweets as $tweet)
                        <div class="tweet_wrapper" style="border-bottom: 1px solid rgba(0,0,0,.125); margin-bottom: 10px;">
                            <p><strong>Contenu : </strong>{{ $tweet->content }}</p>
                            <p><strong>Date de publication : </strong>{{ (new DateTime($tweet->publishDate))->format('d-m-Y')}}</p>
                            <p><strong>Statut : </strong><b @if (!$tweet->sent) class="text-danger" @else class="text-success" @endif>{{ $tweet->sent ? 'envoyé' : 'à envoyer' }}</b></p>
                            <a class="btn btn-primary" style="margin-bottom: 10px" href="{{ route('tweet-details', ['id' => $tweet->id]) }}">{{ __('Détails') }}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
