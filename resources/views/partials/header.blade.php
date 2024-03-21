<header class="fixed-top">
  <div class="container">
    <div class="row">
      <nav class="navbar navbar-expand-lg" style="border: none;">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">
            <img src="img/sourcee logo.png" alt="logo" class="img-fluid" />
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">TA Advisory</a>
              </li>
            </ul>
            <div class="d-flex">
              @if(Auth::check())
              <a href="{{ route('dashboard') }}" class="btn btn-type-one">Go to Dashboard</a>&nbsp;&nbsp;
              <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>&nbsp;&nbsp;
              @else
              <a class="btn btn-type-one" href="{{ route('login') }}">Login</a>
              @endif
            </div>
          </div>
        </div>
      </nav>
    </div>
  </div>
</header>