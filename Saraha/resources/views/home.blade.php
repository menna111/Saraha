@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __($user->name) }} ({{$messages->count()}})</div>
                @forelse($messages as $message )
                <div class="card-body border-bottom ">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __($message->content) }}
                    <span class="float-right">{{$message -> created_at}}</span>
                    <div class="clearfix"></div>
                </div>
                @empty
                        <p>you have not any messages yet</p>

                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
