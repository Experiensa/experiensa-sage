{{--
Template Name: Report
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')
    @include('partials.content-page')

    @php $voyages = Voyage::list(); @endphp
    @if ( $voyages->have_posts() )
      @php
      $good = 0;
      $bad = 0;
      @endphp

      @while ( $voyages->have_posts() )
        @php $voyages->the_post() @endphp
        @php $current_month = get_the_date('F'); @endphp

        {{-- https://wordpress.stackexchange.com/questions/176141/display-posts-by-month --}}
        @if ( $voyages->current_post === 0 )
          <h3 class="fw1 ttc">{{ the_date( 'F Y' ) }}</h3>
          <ul class="list-group">
          @else
            @php
            $f = $voyages->current_post - 1;
            $old_date = mysql2date( 'F', $voyages->posts[$f]->post_date );
            @endphp
            @if ($current_month != $old_date)
              @php echo '</ul>' @endphp
              <b>Total good:</b> {{ $good }} - <b>Total bad:</b> {{$bad}}
              @php
              $good = 0;
              $bad = 0;
              @endphp
              <br><br>
              <h3 class="fw1 ttc">{{ the_date( 'F Y' ) }}</h3>
              <ul class="list-group">
              @endif
            @endif

            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>
                @php $result = voyage::evaluation(get_the_ID()) @endphp
                @if ( $result == 'green')
                  @php $good = $good + 1; @endphp
                @else
                  @php $bad = $bad + 1 @endphp
                @endif
                {!! voyage::display_icon($result) !!}
                <a href="{{ the_permalink() }}">{{ get_the_title() }}</a>
              </span>
              <small class="text-muted">
                @if (get_post_meta(get_the_ID(),'_wp_old_date',true) )
                  created: {{ get_the_date('Y-m-d') }} -
                  modified: {{ get_the_date('Y-m-d') }}
                @else
                  created: {{ get_the_date('Y-m-d') }}
                @endif
                | {{ __('By', 'sage') }} <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="author" class="fn">
                  {{ get_the_author() }}
                </a>
              </small>
            </li>

            {{-- https://gist.github.com/thewirelessguy/7312492 --}}
            @if (($voyages->current_post + 1 ) == ($voyages->post_count))
              @php echo '</ul>'; @endphp
              <b>Total good:</b> {{ $good }} - <b>Total bad:</b> {{$bad}}
            @endif
          @endwhile
        @else
          <div class="">
            There are no voyages found
          </div>
        @endif
        @php wp_reset_postdata(); @endphp
      @endwhile
      <br>
      <br>
    @endsection
