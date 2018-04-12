@extends('layouts.app')

@section('titlesupplment') list of uploaded videos @endsection

<?php
//logged in user id
$authId = Auth::id();

$likeClass = "";
$unlikeClass = "";
?>


@section('headtag')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<link rel="stylesheet" href="{{ asset('public/css/upload-list.css') }}" />

<script>
window.videoLikeAjaxPath = "{{ url('/videolikeajax') }}";
window.videoUnlikeAjaxPath = "{{ url('/videounlikeajax') }}";
</script>

<script src="{{ asset('public/js/upload-list.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjVzCkrxEegU6CotWGUEVlL0VIzSQbIds&callback=mapGroup"></script>
@endsection


@section('content')
    <div id="lightbox">
        <div id="videocontent"> </div>
        <h2>Click to close</h2>
    </div>

    @if(!$videos->isEmpty())
        <h1>Complete List of Uploaded Videos</h1>

        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>File Name</th>
                        <th>Duration (HH:MM:SS)</th>
                        <th>File Size</th>
                        <th>Video Format</th>
                        <th>Bitrate</th>
                        <th>Keywords</th>
                        <th>Location</th>
                        <th>
                        @if (Auth::check()) 
                            Like?
                        @else
                            Please log in to like
                        @endif
                        </th>
                        <th>Likes</th>
                        <th>Uploaded By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($videos as $video)
                        <tr>
                            <td>{{ $video->title }}</td>
                            <td>
                                <a href="<?php echo asset('storage/app/' . $video->file_name) ?>" class="lightbox_trigger">
                                    {{ $video->original_file_name }}
                                </a>
                            </td>
                            <td> <?php echo date('H:i:s', mktime(0, 0, $video->duration)) ?> </td>
                            <td> <?php echo round($video->size / pow(1024, 2), 2) ?> mb</td>
                            <td>{{ $video->format }}</td>
                            <td><?php echo round($video->bitrate / 1024, 2) ?> kbs</td>
                            <td>{{ $video->keywords }}</td>
                            <td>
                                @if ( $video->location )
                                    <iframe class="google_iframe"
                                    src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAjVzCkrxEegU6CotWGUEVlL0VIzSQbIds
                                    &q={{$video->location}}" allowfullscreen>
                                    </iframe>
                                    <br/>
                                    <span id="location_{{$video->id}}" class="location_geo">
                                        {{ $video->location }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if (Auth::check())
                                <div id="liked_{{$video->id}}">
                                    <?php
                                    if($video->ifcurrentuserlike != 1){
                                        $likeClass = "show";
                                        $unlikeClass = "hide";
                                    }else{
                                        $likeClass = "hide";
                                        $unlikeClass = "show";
                                    }
                                    ?>

                                    <button type="button" class="btn btn-danger like_trigger {{$likeClass}}" id="like_{{$video->id}}" rel="{{$video->id}},{{$authId}}" vid="{{$video->id}}">
                                        <span class="glyphicon glyphicon-thumbs-up"></span> Like
                                    </button>

                                    <button type="button" class="btn btn-danger unlike_trigger {{$unlikeClass}}" id="unlike_{{$video->id}}" rel="{{$video->id}},{{$authId}}" vid="{{$video->id}}">
                                        <span class="glyphicon glyphicon-thumbs-down"></span> Unlike
                                    </button>
                                </div>
                                @endif
                            </td>
                            <td><span id="num_likes_{{$video->id}}">{{ $video->num_likes }}</span> likes</td>
                            <td>
                                <a href="<?php echo url("/user/{$video->uploaded_by_uid}") ?>" class="lightbox_trigger">
                                    {{ $video->username }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <br/>

        <a href="{{ url('/videosuploader') }}">Upload another video to this list?</a>
    @else
        Oh no, wrestling fans...  There are no videos!

        <br/>
        <br/>

        <a href="{{ url('/videosuploader') }}">Would you like to upload one?</a>
    @endif
@endsection


@section('endscriptfooter')

@endsection