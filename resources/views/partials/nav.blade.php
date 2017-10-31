<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">

    <button class="navbar-toggler md-lg-none" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div id="logo">
        <a class="navbar-brand" href="/"><img src="/img/logo.png" alt="bootcamp logo"></a>
    </div>

    <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('courses.index') }}">Courses</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown_questions" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Questions</a>
                <div class="dropdown-menu" aria-labelledby="dropdown_questions">
                    <a class="dropdown-item" href="#">Instruction</a>
                    <a class="dropdown-item" href="#">Ask Question</a>
                    <a class="dropdown-item" href="#">Search Answer</a>
                </div>
            </li>

{{--             <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown_interns" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Interns</a>
                <div class="dropdown-menu" aria-labelledby="dropdown_interns">
                    <a class="dropdown-item" href="#">Industry</a>
                    <a class="dropdown-item" href="#">Student</a>
                    <a class="dropdown-item" href="#">Freelance</a>
                </div>
            </li> --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown_aboutus" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">About Us</a>
                <div class="dropdown-menu" aria-labelledby="dropdown_aboutus">
                    <a class="dropdown-item" href="/aboutus">About Us</a>
                    <a class="dropdown-item" href="/contactus">Contact Us</a>
{{--                     <a class="dropdown-item" href="/aboutus#SponsorVenue">Venue Support</a>
                    <a class="dropdown-item" href="#">Consultant Services</a> --}}
                </div>
            </li>
        </ul>

        {{-- AT-Pending: make search box expandable --}}
        {{-- https://stackoverflow.com/questions/34124050/how-to-expand-input-field-to-the-right-in-a-header-bar --}}
        <div class="d-none d-lg-block d-lg-none">
            <form action="#" class="form-inline my-2 my-lg-0">
                {{ csrf_field() }}
                <input class="form-control mr-sm-2" type="search" id="keyword" name="keyword" placeholder="Search... (make it expandable)" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><img src="/img/search.png" width="24" alt="search"></button>
            </form>
        </div>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="navbar-item">
                    <a class="btn btn-primary nav-btn" href="{{ route('login') }}">Login</a>
                </li>
                <li class="navbar-item">
                    <a class="btn btn-primary nav-btn" href="{{ route('register') }}">Register</a>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="dropdown_login" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if (strlen(Auth::user()->nickname) == 0)
                            {{ Auth::user()->name }} 
                        @else
                            {{ Auth::user()->nickname }}
                        @endif
                        <span class="caret"></span></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown_login">
                        <a class="dropdown-item disabled" href="#">My Class</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/profile">Profile</a>
                        <a class="dropdown-item" href="/password/change">Change Password</a>
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
