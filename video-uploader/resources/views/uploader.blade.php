@extends('layouts.app')

@section('titlesupplment') video uploader @endsection


@section('headtag')
    @include('partials.common-form-header')
@endsection


@section('content')
    <form class="form-signin">
      <img class="mb-4" src="{{ asset('public/svg/wwe_logo.svg') }}" alt="" width="100" height="100" />
      <h1 class="h3 mb-3 font-weight-normal">Upload a video</h1>
      <label for="title" class="sr-only">New Video Title</label>

      <div id="vueuploadapp">
        <!-- only is populated by ajax after jquery is fully loaded and ready. Yes, Vue is subservient to jQuery here :( -->
      </div>
    </form>
@endsection


@section('endscriptfooter')
  <script>
    window.uploaderTemplateFile = "{{ asset('resources/views/partials/uploader-form-internal.blade.php') }}";
  </script>

  <script src="{{ asset('public/js/uploader.js') }}"></script>
@endsection
