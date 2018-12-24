<header class="navbar navbar-expand-lg navbar-light bg-light banner">
  <div class="container">
    <a class="brand navbar-brand" href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a>
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="{{ home_url('/') }}wp-admin" target="_blank">Login</a>
      </li>
      @if (is_user_logged_in())
        <li class="nav-item active">
          <a class="nav-link" href="{{ home_url('/') }}wp-json/experiensa-rest-api/v1/voyages?per_page=200" target="_blank">Rest API</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ home_url('/report') }}" target="_blank">Report</a>
        </li>
      @endif
    </ul>
  </div>
</header>
