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
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
  </body>
</html>