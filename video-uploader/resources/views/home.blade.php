@extends('layouts.app')

<?php 
if( empty($message) ){
    $message = $_GET["message"];
}

$dec_msg = base64_decode( $message );
?>

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


                    {{ $dec_msg }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('endscriptfooter')
  <script src="{{ asset('public/js/app.js') }}"></script>
@endsection
