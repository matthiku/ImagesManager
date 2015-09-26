@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Something failed.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <div class="panel-heading">Home</div>

                <div class="panel-body">
                    Welcome, please <a href="{{ url('/auth/login') }}">login</a> or <a href="{{ url('/auth/register') }}">create</a> an account
                </div>
            </div>
        </div>
    </div>
</div>
@endsection