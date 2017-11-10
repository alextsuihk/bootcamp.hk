<div class="card float-right" style="width: 300px;">
  <a class="btn btn-primary" href="{{ route('admin.users.impersonate', $user->id) }}">Impersonate</a>
  <div class="card-body"><center>
    <h4 class="card-title">User Statistic</h4>
    <p class="card-text">
        <p>Courses Followed: {{ $user->follow_courses->count() }}</p>
        <p>Lessons Enrolled: {{ $user->lessons->count() }}</p>
        <p>Questions Asked: {{ $user->questions->count() }}</p>
        <p>Comments Posted: {{  $user->comments->count() }}</p>
    </p>
  </center></div>
</div>

