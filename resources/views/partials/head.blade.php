<title>@yield('title')</title>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

{{-- Bootstrap core CSS --}}
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.min.css" crossorigin="anonymous">

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js" crossorigin="anonymous"></script>

{{-- TinyMCE --}}
<script src='/tinymce/tinymce.min.js'></script>
{{-- <link rel="stylesheet" href="/tinymce/jquery/tinymce.min.css"> --}}
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea',

        plugins: "autosave autolink contextmenu code codesample help hr image imagetools link lists paste preview save searchreplace table textcolor noneditable ",
        
        /*menubar: "file edit view insert format tools help",*/
        
        toolbar: "preview restoredraft | paste searchreplace link hr | codesample | forecolor fontselect fontsizeselect h1 h2 bold italic underline strikethrough superscript subscript | numlist bullist  | help",

        contextmenu: "preview paste codesample link hr | inserttable cell row column deletetable",

        paste_data_images: true, 
        branding: true,
        noneditable_editable_class: "mceEditable",
        noneditable_noneditable_class: "mceNonEditable",
    });
</script>

{{-- Prism for displaying  --}}
<script src='/prism.js'></script>
<link rel="stylesheet" href="/prism.css">


<meta name="description" content="Bootcamp.HK is a platform supporting new engineers & developers to catch up the latest techology ">

<meta name="author" content="Alex">

<link rel="icon" href="/favicon.ico">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Custom styles for this template -->
<link href="/css/dashboard.css" rel="stylesheet">

