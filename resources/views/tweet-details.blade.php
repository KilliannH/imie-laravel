@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Informations</div>

                    <div class="card-body">
                        <p>Contenu : <b>{{ $tweet->content }}</b></p>
                        <p>Date de publication : <b class="{{$tweet->publishDate < $now && !$tweet->sent ? 'text-danger' : ''}}">{{ (new DateTime($tweet->publishDate))->format('d-m-Y')}}</b></p>
                        <p>Statut : <b>{{ $tweet->sent ? 'envoyé' : 'à envoyer' }}</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection