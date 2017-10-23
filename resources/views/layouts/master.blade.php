<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
      @include ('partials.head')
    </head>

    <body>
        <a name="top" id="top"></a>

        <div class="container-fluid">
            @include ('partials.nav')

            <div class="row">
                <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
                    @include ('partials.sidebar')
                </nav>

                <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">
                    @include ('partials.message')
                    @yield ('content')
                    @include ('partials.footer')
                </main>

            </div>
        </div>
        

        @yield ('scripts')    {{-- pull in if section 'scripts' exists --}}

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

        <script src="{{ asset('js/app.js') }}"></script>
    
    </body>
</html>