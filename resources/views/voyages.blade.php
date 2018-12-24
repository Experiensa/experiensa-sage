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
          @php $voyages->the_post() @endphp
          <div class="col-12 col-sm-6 col-md-4 col-lg-4">
            <div class="card">
              <img class="card-img-top" src="{{ get_the_post_thumbnail_url(get_the_ID(),'thumbnail') }}" alt="Card image cap">
              <div class="card-img-overlay hover-bg-black-60 white">
                @php
                $post_thumbnail_id = get_post_thumbnail_id( $post_id );
                $img = wp_get_attachment_image_src($post_thumbnail_id, 'full');
                $filesize = filesize( get_attached_file( $post_thumbnail_id ) );
                @endphp
                @if ( $filesize > 200000)
                  <p class="card-text"><i class="fas fa-times-circle" style="color:red"></i> filesize is {{ $filesize }} it should be less than 200kb</p>
                @endif
                @if (($img[1] < 1919) || ($img[1] > 1921))
                  <table>
                    <tr>
                      <td valign="top"><i class="fas fa-times-circle" style="color:red"></i></td>
                      <td>Cover image width: {{ $img[1] }}. (It should be 1920) </td>
                    </tr>
                  </table>
                @endif
                @if ($img[2] < 1079 || $img[2] > 1081)
                  <table>
                    <tr>
                      <td valign="top"><i class="fas fa-times-circle" style="color:red"></i></td>
                      <td>Cover image height: {{ $img[2] }}. It should be 1080</td>
                    </tr>
                  </table>
                @endif
              </div>
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
                  @php
                  echo Voyage::display_terms('exp_region', get_the_ID(), 0);
                  @endphp
                  <b>Region:</b> @php echo get_the_term_list( get_the_ID(), 'exp_region','',', ','' ); @endphp
                </li>
                <li class="list-group-item">
                  @php
                  echo Voyage::display_terms('exp_country', get_the_ID(), 0);
                  @endphp
                  <b>Country:</b> @php echo get_the_term_list( get_the_ID(), 'exp_country','',', ','' ); @endphp
                </li>
                <li class="list-group-item">
                  @php
                  echo Voyage::display_terms('exp_location', get_the_ID(), 0);
                  @endphp
                  <b>Destination:</b> @php echo get_the_term_list( get_the_ID(), 'exp_location','',', ','' ); @endphp
                </li>
                <li class="list-group-item">
                  @php
                  echo Voyage::display_terms('exp_theme', get_the_ID(), 1);
                  @endphp
                  <b>Theme:</b> @php echo get_the_term_list( get_the_ID(), 'exp_theme','',', ','' ); @endphp
                </li>
                <li class="list-group-item">
                  @php
                  echo Voyage::display_terms('category', get_the_ID(), 0);
                  @endphp
                  <b>Categories:</b> @php echo get_the_term_list( $id, 'category','',', ','' );@endphp
                </li>
                <li class="list-group-item">
                  @php $tags = get_the_tags(); @endphp
                  @if ( count($tags) > 3)
                    <i class="fas fa-check-circle" style="color:green"></i>
                    <b>Tags:</b> @php echo get_the_term_list( get_the_ID(), 'post_tag','',', ','' ); @endphp
                  @else
                    <i class="fas fa-times-circle" style="color:red"></i>
                    <b>Tags:</b> @php echo get_the_term_list( get_the_ID(), 'post_tag','',', ','' ); @endphp
                  @endif
                </li>
                <li class="list-group-item">
                  @php
                  $start_date = get_post_meta(get_the_ID(),'exp_voyage_start_date',true);
                  $formatted_start_date = date("d-m-Y", strtotime($start_date));
                  @endphp
                  @if (get_post_meta(get_the_ID(),'exp_voyage_start_date',true))
                    <i class="fas fa-check-circle" style="color:green"></i>
                    <b>Start date:</b> {{ $formatted_start_date }}
                  @else
                    <i class="fas fa-times-circle" style="color:red"></i>
                    <b>Start date:</b> Obligatory (Set it for today)
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
                      <i class="fas fa-times-circle" style="color:red"></i>
                      <b>End date:</b> {{ $formatted_end_date }} <span class="badge badge-danger">Expired</span>
                    @else
                      <i class="fas fa-check-circle" style="color:green"></i>
                      <b>End date:</b> {{ $formatted_end_date }}
                    @endif
                  @else
                    <i class="fas fa-times-circle" style="color:red"></i>
                    <b>End date:</b> Obligatory (Set it to 6 months from starting date) {{ get_post_meta(get_the_ID(),'exp_voyage_end_date',true) }}
                  @endif
                </li>
                <li class="list-group-item">
                  @if (get_post_meta(get_the_ID(),'exp_voyage_number_days',true) && get_post_meta(get_the_ID(),'exp_voyage_number_nights',true) )
                    <b>Duration:</b> {{ get_post_meta(get_the_ID(),'exp_voyage_number_days',true) }} Days / {{ get_post_meta(get_the_ID(),'exp_voyage_number_nights',true) }} Nights
                  @else
                    <b>Duration:</b>
                  @endif
                </li>
                <li class="list-group-item">
                  @php
                  $gallery = get_post_meta(get_the_ID(), 'exp_voyage_gallery');
                  @endphp
                  @if ( count($gallery) > 7)
                    <i class="fas fa-check-circle" style="color:green"></i>
                    <b>Gallery count:</b> {{ count($gallery) }}
                  @else
                    <i class="fas fa-times-circle" style="color:red"></i>
                    <b>Gallery count:</b> {{ count($gallery) }}. It should be more than 8
                  @endif
                </li>
                <li class="list-group-item">
                  @if (get_post_meta(get_the_ID(),'exp_voyage_original_source',true))
                    <a href="{{ get_post_meta(get_the_ID(),'exp_voyage_original_source',true) }}" class="card-link btn btn-primary btn-sm">Source</a>
                  @else
                    <a href="#" class="card-link btn btn-danger btn-sm disabled">Source</a>
                  @endif
                  @php echo Voyage::media(get_the_ID(),'exp_voyage_panorama_image','Panorama') @endphp
                  @php echo Voyage::media(get_the_ID(),'exp_voyage_portrait_image','Portrait') @endphp
                  @php echo Voyage::media(get_the_ID(),'exp_voyage_flyer','Flyer') @endphp
                </li>
                <li class="list-group-item">
                  <a href="{{ the_permalink() }}" class="btn btn-primary btn-block card-link">Details</a>
                </li>
              </ul>
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
