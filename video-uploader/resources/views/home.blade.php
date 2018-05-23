@extends('layouts.app')

<?php 

if( empty($message) ){
    if(! empty($_GET["message"]) ){
        $message = $_GET["message"];
    }else{
        $message = "";
    }
}

$dec_msg = base64_decode( trim($message) );


$base_dir = urlencode( asset('/') );
?>

@section('titlesupplment') Home @if ($dec_msg) - {{ $dec_msg }} @endif  @endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (Auth::check())

                        You are logged in!  
                        <br/>
                        <br/>
                        {{ $dec_msg }}
                    @else
                        <a href="{{ url('/login') }}">
                            Log in or register if you would like to upload a video.
                        </a>
                        <br/>
                        <sub>(not required to see or use any other part of the site)</sub>
                    @endif

                    <br/>
                    <br/>

                    <a href="{{ url('/videosuploaded') }}">See Video Uploads</a>

                    <br/>
                    <br/>

                    <a href="{{ url('/videosuploader') }}">Upload a video</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('endscriptfooter')
  <script src="{{ asset('public/js/app.js?base_dir=') . $base_dir }}"></script>
@endsection
