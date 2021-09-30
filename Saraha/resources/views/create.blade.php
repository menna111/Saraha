@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __($user->name) }} ({{$messages->count()}})</div>

                        <div class="card-body border-bottom text-center">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                             <img style="width: 100px; height: 100px;border-radius:80%; " class="mb-4" src="{{asset($user->image)}}">

                                <form action="{{route('message.store',$user -> id)}}" method="post">
                                   @csrf
                                        <div class="mb-3">
                                            <label for="content" class="form-label">Send your message</label>
                                            <textarea name="content" class="form-control" id="content" style="height: 175px"></textarea>
                                        </div>
                                    <button type="submit" class="btn btn-primary">ارسال</button>
                                </form>

                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection
