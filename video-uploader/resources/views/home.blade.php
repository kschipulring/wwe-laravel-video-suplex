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
?>

@section('titlesupplment') Home - {{ $dec_msg }}  @endsection

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

                    You are logged in!  
                    <br/>
                    <br/>

                    {{ $dec_msg }}

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
  <script src="{{ asset('public/js/app.js') }}"></script>
@endsection
