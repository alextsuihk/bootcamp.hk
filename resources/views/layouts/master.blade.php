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
                </main>

            </div>
        </div>

        

        @yield ('scripts')    {{-- pull in if section 'scripts' exists --}}

<script src="{{ asset('js/app.js') }}"></script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

<script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery.min.js"><\/script>')
</script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="/js/ie10-viewport-bug-workaround.js"></script>

    </body>
</html>