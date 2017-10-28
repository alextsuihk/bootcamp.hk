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
            <a class="nav-link" href="#">User Mgmt&nbsp;
                <span class="badge badge-pill badge-info">2</span>
                <span class="sr-only">User Management</span>
            </a>
        </li>
    </ul>
    <hr>
@endif

@auth
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <span class="nav-link"><strong>My Shortcuts</strong></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">My Questions&nbsp;
                <span class="badge badge-pill badge-info">{{ $myQuestions }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">My Current Classes&nbsp;
                <span class="badge badge-pill badge-info">{{ $myCurrentLessons }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">My Future Classes&nbsp;
                <span class="badge badge-pill badge-info">{{ $myFutureLessons }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">My GitLab</a>
        </li>
    </ul>
    <hr>
@endauth

<ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <span class="nav-link"><strong>Recommendations</strong></span>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">New Courses&nbsp;
            <span class="badge badge-pill badge-info">{{ $newLessons }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">New Questions&nbsp;
            <span class="badge badge-pill badge-info">{{ $newQuestions }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="btn btn-primary nav-btn btn-sm" href="#">New Comments&nbsp;&nbsp;
            <span class="badge badge-pill badge-light">5</span>
        </a>
    </li>
</ul>
<hr>
<ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <span class="nav-link"><strong>Contact</strong></span>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="http://gitlab.bootcamp.hk" target="_blank">Gitlab</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Twitter</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Facebook</a>
    </li>
</ul>
