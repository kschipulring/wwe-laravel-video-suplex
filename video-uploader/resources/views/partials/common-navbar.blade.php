    <nav class="site-header sticky-top py-1">
      <ul class="nav" id="vuenav">
        <div class="container d-flex flex-column flex-md-row justify-content-between">
          <li>
            <a href="{{ url('/') }}">
              <img class="nav-image" src="{{ asset('/public/svg/wwe_logo.svg') }}" alt="WWE" />
            </a>
          </li>

          @if (Auth::check())
             <li><a class="py-2 d-none d-md-inline-block" href="{{ url('/videosuploader') }}">Upload</a></li>
          @endif

          <li><a class="py-2 d-none d-md-inline-block" href="{{ url('/videosuploaded') }}">See Uploads</a></li>

    		  @if (Auth::check())
            <li class="dropdown">
                <a href="#" class="dropdown-toggle py-2 d-none d-md-inline-block" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }} <!--<span class="caret"></span>-->
                </a>

                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>

      		@else
      		  <li><a class="py-2 d-none d-md-inline-block" href="{{ route('login') }}">Sign In</a></li>
      		  <li><a class="py-2 d-none d-md-inline-block" href="{{ route('register') }}">Register</a></li>
      		@endif
        </div>
    </ul>
    </nav>