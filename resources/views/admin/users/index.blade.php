@extends ('layouts.master')

@section ('title', 'User Management')

@section ('content')

    <h2>Users Management</h2>
    <hr>
    <div class="row">
        <span class="mr-auto ml-3">
            <form method="GET" action={{ route('admin.users.index') }} class="form-inline">
                <input class="form-control " type="search" id="keywords" name="keywords" placeholder="{{ $keywords }}" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </span>

        <span class="ml-auto mr-3">
            @if ($keywords != 'Search...')
                <a class="btn btn-info" href="{{ url()->current() }}">Clear Search</a>
            @endif
        </span>
    </div>
        
    <br>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th></th>
                    <th>Nickname</th>
                    <th><small>Anonymous</small></th>
                    <th>Email<br>Mobile</th>
                    <th>FB</th>
                    <th></th>
                    <th>Registered</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td><small>
                            @if ($user->disabled)
                                <span style="color:red;"><strong>{{ $user->id}}</strong><br>(disabled)</span>
                            @else
                                <strong>{{ $user->id}}</strong>
                            @endif
                        </small></td>
                        <td><img src="{{ $user->avatar }}" height="25"></td>
                        <td>{{ $user->name }} <br><small>{{ $user->nickname }}</small></td>
                        <td><?php echo ($user->anonymous)?'<img src="/img/anonymous.png">':'' ;?></td>
                        <td><small>{{ str_limit($user->email, 25) }}</small><br>{{ $user->mobile }}</td>
                        
                        <td>
                            <?php echo ($user->facebook_id)?'<img src="/img/facebook.png">':'' ;?>
                            <?php echo ($user->linkedin_id)?'<img src="/img/linkedin.png">':'' ;?>
                        </td>
                        <td><?php echo ($user->admin)?'A':'' ;?>
                            <?php echo ($user->instructor)?'I':'' ;?>
                        </td>
                        <td><small>{{ $user->created_at->diffForHumans() }}
                            <br>{{ $user->updated_at->diffForHumans() }}</small></td>
                        <td>
                        <a class="" href="{{ route('admin.users.edit', $user->id) }}"><img src="/img/setting.png"></a>
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
    </div>

@endsection