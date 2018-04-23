<?php
$relative_path = "public/js/simple-recaptcha.js?e={$e}&f={$f}&k=" . env('RECAPTCHA_PUBLIC_KEY');
?>
<script src="{{ asset($relative_path) }}"></script>