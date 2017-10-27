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
                    @include ('partials.impersonate')
                    @include ('partials.message')
                    @yield ('content')
                    @include ('partials.footer')
                </main>

            </div>
        </div>
        

        @yield ('scripts')    {{-- pull in if section 'scripts' exists --}}

        <script src="{{ asset('js/app.js') }}"></script>

    
    </body>
</html>