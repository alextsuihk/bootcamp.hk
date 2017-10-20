@extends ('layouts.master')

@section ('title', 'Workshop Listing')

@section ('content')

    <h2>Workshop Listing</h2>
    <br>
    @include ('partials.search')
    <br>
    <br>
    <a class="btn btn-primary" href="/workshops/create">Add Workshop</a>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Title</th>
                    <th>Level</th>
                    <th>Detail</th>
                    <th>Edit (admin)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workshops as $workshop)
                {{-- AT-Pending: hide if not admin && !is_active  (hide for normal users if is_active=false) --}}
                    <tr>
                        <td><a href="/workshops/{{ $workshop->number }}">{{ $workshop->number }}</a></td>
                        <td><strong>{{ str_limit($workshop->title, 30, ' ...') }} </strong></td>
                        <td>{{ $workshop->level->difficulty }}</td>
                        <td><a class="btn btn-primary" href="/workshops/{{ $workshop->number }}">View</a></td>
                        <td><a class="btn btn-primary" href="/workshops/{{ $workshop->number }}/edit">Edit</a>
                            <a class="btn btn-primary" href="/workshops/{{ $workshop->number }}">Classes</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include ('partials.footer')

@endsection