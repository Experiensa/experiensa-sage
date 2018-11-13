{{--
Template Name: Voyages
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    {{-- @include('partials.page-header') --}}
    {{-- @include('partials.content-page') --}}

    @php $voyages = Voyage::list(); @endphp

    @if ( $voyages->have_posts() )
      <div class="row">
        @while ( $voyages->have_posts() )
          <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            @php $voyages->the_post() @endphp
            <div class="card grow">
              <a href="{{ the_permalink() }}">
                <img class="card-img-top" src="{{ get_the_post_thumbnail_url() }}" alt="Card image cap">
              </a>
              <div class="card-body">
                  <h5 class="title">@php the_title() @endphp</h5>
                <h6 class="card-country">
                  @php echo get_the_term_list( get_the_ID(), 'exp_country','',', ','' ); @endphp
                </h6>
                <i class="text-muted pb-4">
                  {{ get_post_meta(get_the_ID(),'exp_voyage_slogan',true) }}
                </i>
                <br><br>
                <strong class="pt-4">{{ Voyage::price(get_the_ID()) }} CHF</strong>
              </div>
            </div>
            <br>
          </div>
        @endwhile
      </div>
    @else
      // no posts found
    @endif

    @php wp_reset_postdata(); @endphp
    <br>
  @endwhile
@endsection
