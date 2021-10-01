@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>{{ __($user->name) }}</h2>
                        <a href="{{asset($user->image)}}" target="_blank">
                            <img style="width: 100px; height: 100px;border-radius:80%;" src="{{asset($user->image)}}" alt="$user->name" title="$user->name">

                        </a>
                    </div>

                        <div class="card-body border-bottom text-center">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                                @if (session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if($isvalid == true)
                                <form action="{{route('message.store',$user -> id)}}" method="post">
                                   @csrf
                                        <div class="mb-3">
                                            <label for="content" class="form-label">Send your message</label>
                                            <textarea name="content" class="form-control text-right" id="content" rows="6"></textarea>
                                        </div>
                                    <button type="submit" class="btn btn-primary">ارسال</button>
                                </form>
                                @else
                                    <h3 class="alert-danger">"you can not send to yourself share link to your friends"</h3>
                                @endif
                        </div>

                </div>
            </div>
        </div>
    </div>
@endsection
