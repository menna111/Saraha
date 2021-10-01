@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h4 class="p-2" style="background-color: antiquewhite">share your link: <a href="{{route('message.create',$user->id)}}">Link</a></h4>

                <div class="card-header">{{ __($user->name) }} ({{$messages->count()}})</div>
                <div class="card-header" style="background-color: antiquewhite">
                    <div class="row text-center">
                        <div class="col-4">
                            عدد الرسائل
                            <br>
                            {{$messages->count()}}
                        </div>
                        <div class="col-4">
                           عدد الزيارات
                            <br>
                            {{$user->no_of_visits}}
                        </div>
                        <div class="col-4">
                            تاريخ اخر زيارة
                            <br>
                            {{$user->updated_at}}
                        </div>
                    </div>

                </div>
                @forelse($messages as $message )
                <div class="card-body border-bottom p-2 m-2">
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
                        <p>"you have not any messages yet"</p>

                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
