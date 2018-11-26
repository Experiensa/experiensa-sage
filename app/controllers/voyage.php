<?php

namespace App;

use Sober\Controller\Controller;

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

  public static function duration($id)
  {
    return get_post_meta($id, 'exp_voyage_number_days', true) . ' days / ' . get_post_meta($id, 'exp_voyage_number_nights', true) .' nights';
  }

  public static function media($id, $field, $title)
  {
    if (get_post_meta(get_the_ID(),'exp_voyage_panorama_image', true)) {
      $panorama_id = get_post_meta($id, 'exp_voyage_panorama_image', true);
      return '<a class="btn btn-primary btn-sm" href="'.wp_get_attachment_url($panorama_id).'" target="_blank">'.$title.'</a>';
    } else {
      return '<a class="btn btn-primary btn-sm disabled" href="#" target="_blank">'.$title.'</a>';
    }
  }
}
