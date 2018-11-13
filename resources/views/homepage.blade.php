{{--
Template Name: Homepage
--}}

@extends('layouts.full-width')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.page-header')
    @include('partials.content-page')
    <header class="vh-100 bg-light-pink dt w-100">
      <div
      style="background:url(http://mrmrs.github.io/photos/display.jpg) no-repeat center right;background-size: cover;"
      class="dtc v-mid cover ph3 ph4-m ph5-l">
      <h1 class="f2 f-subheadline-l measure lh-title fw9">A Night Taking Photos at San Francisco’s Spooky Ruins of the Sutro Baths</h1>
      <h2 class="f6 fw6 black">A story by Nancy Drew</h2>
    </div>
  </header>
@endwhile
@endsection
