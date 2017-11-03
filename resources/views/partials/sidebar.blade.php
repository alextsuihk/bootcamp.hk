{{-- 
AT-Pending: add Auth::check()
show My_Class
show My_Question: no of unread answered

 --}}

@if (Helper::admin())
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <span class="nav-link"><strong>Admin</strong></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.users.index') }}">New Users&nbsp;
                <span class="badge badge-pill badge-info">{{ $newUsers }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('questions.index', ['type'=>'openQuestions']) }}">Open Questions&nbsp;
                <span class="badge badge-pill badge-info">{{ $openQuestions }}</span></a>
        </li>
    </ul>
    <hr>
@endif

@auth
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <span class="nav-link"><strong>My Dashboard</strong></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('questions.index', ['type'=>'myQuestions']) }}">Questions&nbsp;
                <span class="badge badge-pill badge-info">{{ $myQuestions }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('questions.index', ['type'=>'myNewComments']) }}">New Comments&nbsp;
                <span class="badge badge-pill badge-info">{{ $myNewComments }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('lessons.index', ['type'=>'myCurrentLessons']) }}">
                Current Classes&nbsp;
                <span class="badge badge-pill badge-info">{{ $myCurrentLessons }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('lessons.index', ['type'=>'myFutureLessons']) }}">
                Future Classes&nbsp;
                <span class="badge badge-pill badge-info">{{ $myFutureLessons }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="http://gitlab.bootcamp.hk/dashboard/projects"  target="_blank">My GitLab</a>
        </li>
    </ul>
    <hr>
@endauth

<ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <span class="nav-link"><strong>Recommendations</strong></span>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('lessons.index', ['type'=>'new']) }}">New Classes&nbsp;
            <span class="badge badge-pill badge-info">{{ $newLessons }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('lessons.index') }}">All Classes&nbsp;
            <span class="badge badge-pill badge-info">{{ $allLessons }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">New Questions&nbsp;
            <span class="badge badge-pill badge-info">{{ $newQuestions }}</span>
        </a>
    </li>
</ul>
<hr>
<ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <span class="nav-link"><strong>Other Links</strong></span>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="https://gitlab.bootcamp.hk/dashboard" target="_blank">Gitlab</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="http://www.twitter.com">Twitter</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="http://www.facebook.com">Facebook</a>
    </li>
</ul>
