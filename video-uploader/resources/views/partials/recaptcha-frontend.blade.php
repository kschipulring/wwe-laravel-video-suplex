<?php
$relative_path = "public/js/simple-recaptcha.js?e={$e}&f={$f}&k=" . env('RECAPTCHA_PUBLIC_KEY');
?>

@if ($errors->has('recaptcha'))
    <span class="help-block" id="recaptcha_help">
        <strong>{{ $errors->first('recaptcha') }}</strong>
    </span>
@endif

<script src="{{ asset($relative_path) }}"></script>