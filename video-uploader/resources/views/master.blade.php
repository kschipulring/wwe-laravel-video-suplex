<!doctype html>
<html lang="en">
  <head>
    <title>WWE video uploader</title>
    @include('common-form-header')
  </head>

  <body class="text-center">
    <form class="form-signin">
      <img class="mb-4" src="public/svg/wwe_logo.svg" alt="" width="100" height="100" />
      <h1 class="h3 mb-3 font-weight-normal">Upload a video</h1>
      <label for="title" class="sr-only">New Video Title</label>
      

      <div id="app">
        <input type="text" id="title" name="title" class="form-control" v-model="form.title" :disabled="disabled == 1 ? true : false" placeholder="your awesome title" autofocus />

        <div class="checkbox mb-3">
          <label>
            <input type="checkbox" id="checkbox" v-model="disabled" /> Attempt to use title from video meta data if one is present
          </label>
        </div>

        <div class="mb-3">
          <input name="videofile" type="file" accept="video/mp4" required />
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Upload</button>
      </div>
      <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
    </form>
  </body>
  <script src="public/js/uploader.js"></script>
</html>