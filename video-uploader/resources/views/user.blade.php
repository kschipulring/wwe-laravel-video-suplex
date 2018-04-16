@extends('layouts.app')

@section('titlesupplment') User page for {{ $user->name }} @endsection


@section('headtag')
<link rel="stylesheet" href="{{ asset('public/css/user.css') }}" />
<script src="{{ asset('public/js/upload-list.js') }}"></script>
@endsection


@section('content')
	<div id="lightbox">
		<div id="videocontent"> </div>
		<h2>Click to close</h2>
	</div>


	<h2>{{ $user->name }} </h2>

	<br/>

	<?php
	$time = strtotime( $user->created_at );

	$newformat = date('F jS, Y', $time);
	?>

	<h3><sub>member since:</sub><br/>{{ $newformat }} </h3>

	<br/>

	<h4>Videos Uploaded:</h4>

	@if(!$videos->isEmpty())
	<div class="table-responsive">
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th>Title</th>
					<th>File Name</th>
					<th>Likes</th>
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
					<td>{{ $video->num_likes }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	@endif
@endsection