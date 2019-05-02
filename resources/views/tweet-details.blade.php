@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Informations</div>

                    <div class="card-body">
                        <p><strong>Contenu : </strong>{{ $tweet->content }}</p>
                        <p><strong>Date de publication : </strong>{{ (new DateTime($tweet->publishDate))->format('d-m-Y')}}</p>
                        <p><strong>Statut : </strong><b @if (!$tweet->sent) class="text-danger" @endif>{{ $tweet->sent ? 'envoyé' : 'à envoyer' }}</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection