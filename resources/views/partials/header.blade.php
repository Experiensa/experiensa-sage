<header class="navbar navbar-expand-lg navbar-light bg-light banner">
  <div class="container">
    <a class="brand navbar-brand" href="{{ home_url('/') }}">{{ get_bloginfo('name', 'display') }}</a>
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="{{ home_url('/') }}wp-admin" target="_blank">Login</a>
      </li>
    </ul>
    {{-- <nav class="nav-primary">
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
      @endif
    </nav> --}}
  </div>
</header>
