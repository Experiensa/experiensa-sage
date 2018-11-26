{{--
Template Name: Voyages
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    {{-- @include('partials.page-header') --}}
    {{-- @include('partials.content-page') --}}
    @php $voyages = Voyage::list(); @endphp
    <br>
    <h3 class="text-muted">Number of offers: {{$voyages->post_count }}</h3>
    @if ( $voyages->have_posts() )
      <div class="row">
        @while ( $voyages->have_posts() )
          <div class="col-12 col-sm-6 col-md-4 col-lg-4">
            @php $voyages->the_post() @endphp
            <div class="card">
              <img class="card-img-top" src="{{ get_the_post_thumbnail_url(get_the_ID(),'thumbnail') }}" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title">@php the_title() @endphp</h5>
                <i class="text-muted">
                  {{ get_post_meta(get_the_ID(),'exp_voyage_slogan',true) }}
                </i>
                <span class="price db mt-1"><b>Price:</b> {{ Voyage::price(get_the_ID()) }} CHF <br></span>
                <span class="discount"><b>Discount:</b> {{ get_post_meta(get_the_ID(),'exp_voyage_discount',true) }} CHF</span>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <b>Region:</b> @php echo get_the_term_list( get_the_ID(), 'exp_region','',', ','' ); @endphp
                </li>
                <li class="list-group-item">
                  <b>Country:</b> @php echo get_the_term_list( get_the_ID(), 'exp_country','',', ','' ); @endphp
                </li>
                <li class="list-group-item">
                  <b>Destination:</b> @php echo get_the_term_list( get_the_ID(), 'exp_location','',', ','' ); @endphp
                </li>
                <li class="list-group-item">
                  <b>Theme:</b> @php echo get_the_term_list( get_the_ID(), 'exp_theme','',', ','' ); @endphp
                </li>
                <li class="list-group-item">
                  <b>Categories:</b> @php echo get_the_term_list( get_the_ID(), 'category','',', ','' ); @endphp
                </li>
                <li class="list-group-item">
                  <b>Tags:</b> @php echo get_the_term_list( get_the_ID(), 'post_tag','',', ','' ); @endphp
                </li>
                <li class="list-group-item">
                  @php
                  $start_date = get_post_meta(get_the_ID(),'exp_voyage_start_date',true);
                  $formatted_start_date = date("d-m-Y", strtotime($start_date));
                  @endphp
                  @if (get_post_meta(get_the_ID(),'exp_voyage_start_date',true))
                    <b>Start date:</b> {{ $formatted_start_date }}
                  @else
                    <b>Start date:</b> {{ get_post_meta(get_the_ID(),'exp_voyage_start_date',true) }}
                  @endif
                </li>
                <li class="list-group-item">
                  @php
                  $end_date = get_post_meta(get_the_ID(),'exp_voyage_end_date',true);
                  $today = date("Y-m-d");
                  $formatted_end_date = date("d-m-Y", strtotime($end_date));
                  @endphp
                  @if (get_post_meta(get_the_ID(),'exp_voyage_end_date',true))
                    @if ($today >= $end_date)
                      <b>End date:</b> {{ $formatted_end_date }} <span class="badge badge-danger">Expired</span>
                    @else
                      <b>End date:</b> {{ $formatted_end_date }}
                    @endif
                  @else
                    <b>End date:</b> {{ get_post_meta(get_the_ID(),'exp_voyage_end_date',true) }}
                  @endif
                </li>
                <li class="list-group-item">
                  <b>Duration:</b> {{ get_post_meta(get_the_ID(),'exp_voyage_number_days',true) }} Days / {{ get_post_meta(get_the_ID(),'exp_voyage_number_nights',true) }} Nights
                </li>
                <li class="list-group-item">
                  @if (get_post_meta(get_the_ID(),'exp_voyage_original_source',true))
                    <a href="{{ get_post_meta(get_the_ID(),'exp_voyage_original_source',true) }}" class="card-link btn btn-primary btn-sm">Source</a>
                  @else
                    <a href="#" class="card-link btn btn-primary btn-sm disabled">Source</a>
                  @endif
                  @php echo Voyage::media(get_the_ID(),'exp_voyage_panorama_image','Panorama') @endphp
                  @php echo Voyage::media(get_the_ID(),'exp_voyage_portrait_image','Portrait') @endphp
                  @php echo Voyage::media(get_the_ID(),'exp_voyage_flyer','Flyer') @endphp
                </li>
              </ul>
              <div class="card-footer">
                <a href="{{ the_permalink() }}" class="btn btn-primary btn-block card-link">Details</a>
              </div>
            </div>
            <br>
          </div>
        @endwhile
      </div>
    @else
      // no posts found
    @endif
    {{-- Additional info
    Gallery*
    Panorama image
    Portrait image
    Flyer
    Categories
    Tags
    Included
    Excluded --}}
    @php wp_reset_postdata(); @endphp
    <br>
  @endwhile
@endsection
