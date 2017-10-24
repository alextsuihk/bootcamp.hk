{{-- 
AT-Pending: add Auth::check()
show My_Class
show My_Question: no of unread answered

 --}}

@auth
    @if (auth()->user()->admin)
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <span class="nav-link"><strong>Admin</strong></span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">User Mgmt&nbsp;
                    <span class="badge badge-pill badge-info">2</span>
                    <span class="sr-only">unread comments</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">New Questions&nbsp;
                    <span class="badge badge-pill badge-info">5</span>
                    <span class="sr-only">unread comments</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">GitLab</a>
            </li>
        </ul>
        <hr>
    @endif

    <ul class="nav nav-pills flex-column">
    {{--     <li class="nav-item">
            <a class="nav-link active" href="#">My Questions <span class="sr-only">(current)</span></a>
        </li> --}}
        <li class="nav-item">
            <span class="nav-link"><strong>My Shortcuts</strong></span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">My Questions&nbsp;
                <span class="badge badge-pill badge-info">2</span>
                <span class="sr-only">unread comments</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">My Classes&nbsp;
                <span class="badge badge-pill badge-info">5</span>
                <span class="sr-only">unread comments</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">New Courses&nbsp;
                <span class="badge badge-pill badge-info">2</span>
                <span class="sr-only">unread comments</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">GitLab</a>
        </li>
    </ul>
    <hr>
@endauth

<ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <span class="nav-link"><strong>Menu</strong></span>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Unread Comments <span class="badge badge-info">5</span></a>
    </li>
    <li class="nav-item">
        <a class="btn btn-primary nav-btn btn-sm" href="#">New Comments&nbsp;&nbsp;
            <span class="badge badge-pill badge-light">5</span>
            <span class="sr-only">unread comments</span>
        </a>
    </li>
</ul>
<hr>
<ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <span class="nav-link"><strong>Contact</strong></span>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Gitlab</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Twitter</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">Facebook</a>
    </li>
</ul>
