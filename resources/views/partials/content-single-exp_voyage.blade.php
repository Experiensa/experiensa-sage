<article @php post_class() @endphp>
  @php $id = get_the_ID() @endphp
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
      @endphp
      <a href="{{ wp_get_attachment_url( $flyer ) }}" class="btn btn-sm btn-light" target="_blank">Flyer</a>
      <br>
      <br>
      <table class="table">
        <tr>
          <td>Price</td><td>{{ Voyage::price($id) }}</td>
        </tr>
        <tr>
          <td>Discount</td><td>{{ get_post_meta($id,'exp_voyage_discount',true) }}</td>
        </tr>
        <tr>
          <td>Duration</td><td>{{ Voyage::duration($id) }}</td>
        </tr>
        <tr>
          <td>Start Date</td><td>{{ get_post_meta(get_the_ID(), 'exp_voyage_start_date', true) }}</td>
        </tr>
        <tr>
          <td>End Date</td><td>{{ get_post_meta(get_the_ID(), 'exp_voyage_end_date', true) }}</td>
        </tr>
        <tr>
          <td>Region</td>
          <td>@php echo get_the_term_list( get_the_ID(), 'exp_region','',', ','' ); @endphp </td>
        </tr>
        <tr>
          <td>Country</td>
          <td>
            @php echo get_the_term_list( get_the_ID(), 'exp_country','',', ','' ); @endphp
          </td>
        </tr>
        <tr>
          <td>Themes</td>
          <td>@php echo get_the_term_list( get_the_ID(), 'exp_theme','',', ','' ); @endphp</td>
        </tr>
        <tr>
          <td>Categories</td>
          <td>@php echo get_the_term_list( get_the_ID(), 'category','',', ','' ); @endphp </td>
        </tr>
        <tr>
          <td>Tags</td>
          <td>@php echo get_the_term_list( get_the_ID(), 'post_tag','',', ','' ); @endphp </td>
        </tr>
      </table>
    </div>
    <div class="col-12 col-sm-8 col-md-8 col-lg-8">
      <div class="entry-content">
        <h2 class="entry-title">&nbsp;</h2>
        {{ get_post_meta(get_the_ID(), 'exp_voyage_slogan', true) }}
        @php the_content() @endphp
        <br>
        @php
        $gallery = get_post_meta(get_the_ID(), 'exp_voyage_gallery');
        @endphp
        <h3>More Info</h3>
        @php echo get_post_meta(get_the_ID(), 'exp_voyage_information_conditions', true); @endphp
        <br>
        <br>
        @php
        echo get_the_term_list( get_the_ID(), 'exp_included','<h3>Included</h3>','<br>','' );
        @endphp
        <br>
        @php
        echo get_the_term_list( get_the_ID(), 'exp_excluded','<h3>Excluded</h3>','<br>','' );
        @endphp
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
