<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">

    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div id="logo">
        <a class="navbar-brand" href="/"><img src="/img/logo.png" alt="laravel logo"></a>
    </div>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/workshops">Workshops</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Questions</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown_intern" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Interns</a>
                <div class="dropdown-menu" aria-labelledby="dropdown_aboutus">
                    <a class="dropdown-item" href="#">Industry</a>
                    <a class="dropdown-item" href="#">Students</a>
                    <a class="dropdown-item" href="#">Freelancer</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown_aboutus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">About Us</a>
                <div class="dropdown-menu" aria-labelledby="dropdown_aboutus">
                    <a class="dropdown-item" href="/aboutus">About Us</a>
                    <a class="dropdown-item" href="/contactus">Contact Us</a>
                    <a class="dropdown-item" href="/aboutus#SponsorVenue">Venue Support</a>
                    <a class="dropdown-item" href="#">Consultant Services</a>
                </div>
            </li>
        </ul>

        {{-- AT-Pending: make search box expandable --}}
        {{-- https://stackoverflow.com/questions/34124050/how-to-expand-input-field-to-the-right-in-a-header-bar --}}
        <form action="#" class="form-inline">
            {{ csrf_field() }}
            <input class="form-control " type="text" id="keyword" name="keyword" placeholder="Search... (make it expandable)" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="navbar-item">
                    <a class="btn btn-primary nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="navbar-item"><a class="btn btn-primary nav-link" href="{{ route('register') }}">Register</a>
                </li>
            @else
                <li class="navbar-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="#">My Classes</a>            
                        <div class="dropdown-divider"></div>           
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            @endguest
        </ul>

     
    </div>
</nav>
