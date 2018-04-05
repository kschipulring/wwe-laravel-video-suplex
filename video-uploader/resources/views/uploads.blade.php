@extends('layouts.app')

@section('titlesupplment') list of uploaded videos @endsection

@section('content')
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
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>sample video</td>
                    <td>myvid.mp4</td>
                    <td>00:01:34</td>
                    <td>2 mb</td>
                    <td>mp4</td>
                    <td>96kbs</td>
                    <td>cool vids, dolphins, cats, first vids</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection


@section('endscriptfooter')

@endsection