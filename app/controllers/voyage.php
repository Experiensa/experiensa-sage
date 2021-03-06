<?php

namespace App;

use Sober\Controller\Controller;
//use App\Experiensa;

use WP_Query;

class Voyage extends Controller
{

  public function list()
  {
    // WP_Query arguments
    $args = [
      'post_type'       => array( 'exp_voyage' ),
      'posts_per_page'  => -1,
    ];

    // The Query
    $voyages = new WP_Query( $args );
    return $voyages;
  }

  public function price($id)
  {
    return get_post_meta($id, 'exp_voyage_price', true);
  }

  public static function start_date()
  {

  }

  public static function end_date()
  {

  }

  function formatSizeUnits($bytes)
  {
    if ($bytes >= 1073741824)
    {
      $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
      $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
      $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
      $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
      $bytes = $bytes . ' byte';
    }
    else
    {
      $bytes = '0 bytes';
    }

    return $bytes;
  }

  public static function duration($id)
  {
    return get_post_meta($id, 'exp_voyage_number_days', true) . ' days / ' . get_post_meta($id, 'exp_voyage_number_nights', true) .' nights';
  }

  public static function media($id, $field, $title)
  {
    if (get_post_meta(get_the_ID(),$field, true)) {
      $panorama_id = get_post_meta($id, $field, true);
      return '<a class="btn btn-primary btn-sm" href="'.wp_get_attachment_url($panorama_id).'" target="_blank">'.$title.'</a>';
    } else {
      return '<a class="btn btn-danger btn-sm disabled" href="#" target="_blank">'.$title.'</a>';
    }
  }

  public static function display_terms($term, $id, $count = 4)
  {
    $terms = wp_get_post_terms( $id, $term );

    if ( count($terms) > $count ) {
      $display_term = '<i class="fas fa-check-circle" style="color:green"></i>';
    } else {
      $display_term = '<i class="fas fa-times-circle" style="color:red"></i>';
    }
    return $display_term;
  }

  public static function display_icon($var)
  {
    if ($var == 'green') {
      return '<i class="fas fa-check-circle" style="color:green"></i>';
    }
    else {
      return '<i class="fas fa-times-circle" style="color:red"></i>';
    }
  }

  public static function validate_cover_image($id)
  {
    $post_thumbnail_id = get_post_thumbnail_id( $id );
    $img = wp_get_attachment_image_src($post_thumbnail_id, 'full');
    $filesize = filesize( get_attached_file( $post_thumbnail_id ) );
    $formatted_filesize = self::formatSizeUnits($filesize);

    $color= "";
    $msg = "";
    $error = "no";

    if (!has_post_thumbnail($id)) {
      $color = "red";
      $msg = "<li>Cannot be empty</li>";
      $error = "yes";
    }
    if (($img[1] < 1919) || ($img[1] > 1921)) {
      $color = "red";
      $msg .= "<li>Width should be 1920</li>";
      $error = "yes";
    }
    if ($img[2] < 1079 || $img[2] > 1081) {
      $color = "red";
      $msg = $msg . "<li>Height should be 1080</li>";
      $error = "yes";
    }
    if ($filesize > 200000) {
      $color = "red";
      $msg .= "<li>Filesize is {$formatted_filesize}. It should be less than 200kb </li>";
      $error = "yes";
    }
    if ($error == "no") {
      $color= "green";
      $msg = "<li>OK</li>";
    }
    return [$color,$msg];
  }

  public static function evaluation($id)
  {
    $post_thumbnail_id = get_post_thumbnail_id( $id );
    $img = wp_get_attachment_image_src($post_thumbnail_id, 'full');
    $filesize = filesize( get_attached_file( $post_thumbnail_id ) );

    $region = wp_get_post_terms( $id, 'exp_region' );
    $country = wp_get_post_terms( $id, 'exp_country' );
    $location = wp_get_post_terms( $id, 'exp_location' );
    $theme = wp_get_post_terms( $id, 'exp_theme' );
    $cat = wp_get_post_terms( $id, 'category' );
    $tags = wp_get_post_terms( $id, 'post_tag' );

    $gallery = get_post_meta(get_the_ID(), 'exp_voyage_gallery');

    if (!has_post_thumbnail($id)) {
      return 'red';
    }
    elseif (($img[1] < 1919) || ($img[1] > 1921)) {
      return 'red';
    }
    elseif ($img[2] < 1079 || $img[2] > 1081) {
      return 'red';
    }
    elseif ($filesize > 200000) {
      return 'red';
    }
    elseif (count($region) < 1) {
      return 'red';
    }
    elseif (count($country) < 1) {
      return 'red';
    }
    elseif (count($location) < 1) {
      return 'red';
    }
    elseif (count($theme) < 2) {
      return 'red';
    }
    elseif (count($cat) < 1) {
      return 'red';
    }
    elseif (count($tags) < 4) {
      return 'red';
    }
    elseif (count($gallery) < 8) {
      return 'red';
    }
    elseif (!get_post_meta(get_the_ID(),'exp_voyage_start_date',true)) {
      return 'red';
    }
    elseif (!get_post_meta(get_the_ID(),'exp_voyage_end_date',true)) {
      return 'red';
    }
    elseif (!get_post_meta($id,'exp_voyage_original_source',true)) {
      return 'red';
    }
    else {
      return 'green';
    }

  }

}
