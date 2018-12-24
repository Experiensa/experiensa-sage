<article @php post_class() @endphp>
  @php $id = get_the_ID() @endphp
  @php $gallery = get_post_meta(get_the_ID(), 'exp_voyage_gallery'); @endphp
  <div class="row">
    <div class="col-12 col-sm-4 col-md-4 col-lg-4">
      <h2 class="entry-title">{{ get_the_title() }}</h2>
      <img src="{{ get_the_post_thumbnail_url() }}" alt="" class="img-fluid mb-2">

      @if ( get_the_post_thumbnail_url(get_the_ID(), 'full') )
        <a href="{{ get_the_post_thumbnail_url(get_the_ID(), 'full') }}" data-fancybox="group" class="btn btn-sm btn-light">
          <i class="far fa-images"></i> Gallery
        </a>
      @endif

      @php
      $flyer =  get_post_meta(get_the_ID(), 'exp_voyage_flyer', true);
      $panorama = get_post_meta(get_the_ID(), 'exp_voyage_panorama_image', true);
      $portrait = get_post_meta(get_the_ID(), 'exp_voyage_portrait_image', true);
      @endphp
      @if (get_post_meta(get_the_ID(), 'exp_voyage_flyer', true))
        <a href="{{ wp_get_attachment_url( $flyer ) }}" class="btn btn-sm btn-light" target="_blank">Flyer</a>
      @endif
      @if (get_post_meta(get_the_ID(), 'exp_voyage_panorama_image', true))
        <a href="{{ wp_get_attachment_url( $panorama ) }}" class="btn btn-sm btn-light" target="_blank">Panorama</a>
      @endif
      @if (get_post_meta(get_the_ID(), 'exp_voyage_portrait_image', true))
        <a href="{{ wp_get_attachment_url( $portrait ) }}" class="btn btn-sm btn-light" target="_blank">Protrait</a>
      @endif

      <br>
      <br>
      <table class="table">
        <tr>
          <td width="40%" class="b">Price</td><td>{{ Voyage::price($id) }}</td>
        </tr>
        <tr>
          <td class="b">Discount</td><td>{{ get_post_meta($id,'exp_voyage_discount',true) }}</td>
        </tr>
        <tr>
          <td class="b">Duration</td><td>{{ Voyage::duration($id) }}</td>
        </tr>
        <tr>
          @php $cover_image = Voyage::validate_cover_image($id) @endphp
          <td class="b">@php echo Voyage::display_icon($cover_image[0]) @endphp Cover img</td>
          <td>
            @if ($cover_image[0] == 'red')
              <ul class="pa0">
                {!!$cover_image[1]!!}
              </ul>
            @else
              {!!$cover_image[1]!!}
            @endif
          </td>
        </tr>
        <tr>
          @php
          $start_date = get_post_meta(get_the_ID(),'exp_voyage_start_date',true);
          // $formatted_start_date = date("d-m-Y", strtotime($start_date));
          @endphp
          @if ($start_date)
            <td class="b"><i class="fas fa-check-circle" style="color:green"></i> Start Date</td>
            <td>{{ $start_date }}</td>
          @else
            <td class="b"><i class="fas fa-times-circle" style="color:red"></i> Start Date</td>
            <td>Obligatory (Set it for today)</td>
          @endif
        </tr>
        <tr>
          @php
          $end_date = get_post_meta(get_the_ID(),'exp_voyage_end_date',true);
          $today = date("Y-m-d");
          @endphp
          @if (get_post_meta(get_the_ID(),'exp_voyage_end_date',true))
            @if ($today >= $end_date)
              <td class="b"><i class="fas fa-times-circle" style="color:red"></i> End date:</td>
              <td>{{ $end_date }} <span class="badge badge-danger">Expired</span></td>
            @else
              <td class="b"><i class="fas fa-check-circle" style="color:green"></i> End date:</td>
              <td>{{ $end_date }}</td>
            @endif
          @else
            <td class="b"><i class="fas fa-times-circle" style="color:red"></i> End date:</td>
            <td>Obligatory (Set it to 6 months from starting date)</td>
          @endif
        </tr>
        <tr>
          <td class="b">@php echo Voyage::display_terms('exp_region', get_the_ID(), 0); @endphp Region</td>
          <td>@php echo get_the_term_list( get_the_ID(), 'exp_region','',', ','' ); @endphp </td>
        </tr>
        <tr>
          <td class="b">@php echo Voyage::display_terms('exp_country', get_the_ID(), 0); @endphp Country</td>
          <td>
            @php echo get_the_term_list( get_the_ID(), 'exp_country','',', ','' ); @endphp
          </td>
        </tr>
        <tr>
          <td class="b">@php echo Voyage::display_terms('exp_location', get_the_ID(), 0); @endphp Destination</td>
          <td>@php echo get_the_term_list( get_the_ID(), 'exp_location','',', ','' ); @endphp</td>
        </tr>
        <tr>
          <td class="b">@php echo Voyage::display_terms('exp_theme', get_the_ID(), 1); @endphp Themes</td>
          <td>@php echo get_the_term_list( get_the_ID(), 'exp_theme','',', ','' ); @endphp</td>
        </tr>
        <tr>
          <td class="b">@php echo Voyage::display_terms('category', get_the_ID(), 0); @endphp Categories</td>
          <td>@php echo get_the_term_list( get_the_ID(), 'category','',', ','' ); @endphp </td>
        </tr>
        <tr>
          <td class="b">@php echo Voyage::display_terms('post_tag', get_the_ID(), 3); @endphp Tags</td>
          <td>@php echo get_the_term_list( get_the_ID(), 'post_tag','',', ','' ); @endphp </td>
        </tr>
        <tr>
          @if ( count($gallery) > 7)
            <td class="b"><i class="fas fa-check-circle" style="color:green"></i> Gallery</td>
            <td>{{ count($gallery) }} images</td>
          @else
            <td class="b"><i class="fas fa-times-circle" style="color:red"></i> Gallery</td>
            <td>{{ count($gallery) }} images. It should be more than 8</td>
          @endif
        </tr>
        <tr>
          @if (get_post_meta(get_the_ID(),'exp_voyage_original_source',true))
            <td class="b"><i class="fas fa-check-circle" style="color:green"></i> Source</td>
            <td><a href="{{ get_post_meta(get_the_ID(),'exp_voyage_original_source',true) }}" target="_blank">Source</a></td>
          @else
            <td class="b"><i class="fas fa-times-circle" style="color:red"></i> Link</td>
            <td>No source found</td>
          @endif
        </tr>
      </table>
    </div>
    <div class="col-12 col-sm-8 col-md-8 col-lg-8">
      <div class="entry-content">
        <h2 class="entry-title">&nbsp;</h2>

        {{ get_post_meta(get_the_ID(), 'exp_voyage_slogan', true) }}
        @php the_content() @endphp
        <br>
        @if (get_post_meta(get_the_ID(), 'exp_voyage_information_conditions', true))
          <h3>More Info</h3>
          @php echo get_post_meta(get_the_ID(), 'exp_voyage_information_conditions', true); @endphp
          <br>
        @endif
        <br>
        <div class="row">
          <div class="col-12 col-sm-6 col-md-6 col-lg-6">
            @php
            echo get_the_term_list( get_the_ID(), 'exp_included','<h3>Included</h3>','<br>','' );
            @endphp
          </div>
          <div class="col-12 col-sm-6 col-md-6 col-lg-6">
            @php
            echo get_the_term_list( get_the_ID(), 'exp_excluded','<h3>Excluded</h3>','<br>','' );
            @endphp
          </div>
        </div>
        <br>
        <br>
        @if ($gallery)
          <div style="display:none;">
            @foreach ($gallery as $key => $value)
              <a href="{{ wp_get_attachment_image_url($value, 'full') }}" data-fancybox="group">
                <img src="{{ wp_get_attachment_url( $value ) }} " class="img-fluid" alt="Fancy image" >
              </a>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
  <br>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
  @php comments_template('/partials/comments.blade.php') @endphp
</article>
