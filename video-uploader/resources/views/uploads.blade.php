@extends('layouts.app')

@section('titlesupplment') list of uploaded videos @endsection

@section('content')

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
                        <th>Likes</th>
                        <th>Uploaded By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($videos as $video)
                        <tr>
                            <td>{{ $video->title }}</td>
                            <td>{{ $video->original_file_name }}</td>
                            <td> <?php echo date('H:i:s', mktime(0, 0, $video->duration)) ?> </td>
                            <td> <?php echo round($video->size / pow(1024, 2), 2) ?> mb</td>
                            <td>{{ $video->format }}</td>
                            <td><?php echo round($video->bitrate / 1024, 2) ?> kbs</td>
                            <td>{{ $video->keywords }}</td>
                            <td>{{ $video->location }}</td>
                            <td>likes</td>
                            <td><a href="<?php echo url("/user/{$video->uploaded_by_uid}") ?>">{{ $video->username }}</a></td>
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