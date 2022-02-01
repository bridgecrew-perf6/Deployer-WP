<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
  public function __construct() {
    $GLOBALS['options'] = $this->options();
    $GLOBALS['navigation'] = $this->menu();
  }

  public static function formSubmit() {
    return isset($_REQUEST['gform_submit']) ? 'formsubmit-' . $_REQUEST['gform_submit'] : null;
  }

  public static function menu() {
    $dataHeader = [];

    $menuLocations = get_nav_menu_locations();
    $headerMenuId = isset($menuLocations['primary_navigation']) ? $menuLocations['primary_navigation'] : null;
    // $footerMenuId = isset($menuLocations['footer_navigation']) ? $menuLocations['footer_navigation'] : null;

    if ($headerMenuId) {
      $headerMenuNav = wp_get_nav_menu_items($headerMenuId);

      foreach($headerMenuNav as $item) {
        $dataHeader[] = [
          'id' => $item->object_id,
          'title' => $item->title,
          'url' => $item->url,
          'target' => $item->target
        ];
      }
    }

    // if ($footerMenuId) {
    //   $footerMenuNav = wp_get_nav_menu_items($footerMenuId);

    //   foreach($footerMenuNav as $item) {
    //     $dataFooter[] = [
    //         'id' => $item->object_id,
    //         'title' => $item->title,
    //         'url' => $item->url,
    //         'target' => $item->target
    //     ];
    //   }
    // }

    return [
      'header' => $dataHeader,
      // 'footer' => $dataFooter
    ];
  }

  public static function options() {
    $options = get_fields('options');

    return [
      'gtm' => $options['google_tag_manager'],
      'analytics' => $options['google_analytics_key']
    ];
  }

  public static function getPosts($limit = -1, $post_type = 'post', $exclude = [], $new_args = NULL) {
    $args = [
      'post_type' => $post_type,
      'posts_per_page' => $limit,
      'post__not_in' => $exclude
    ];

    if ($new_args) {
      foreach($new_args as $key => $value) {
        $args[$key] = $value;
      }
    }

    return new WP_Query($args);
  }

  public static function getMainTaxonomy($post_id, $taxonomy = 'category') {
    $terms = get_the_terms($post_id, $taxonomy);
    $main_category = yoast_get_primary_term_id($taxonomy, $post_id);
    $category = count($terms) > 1 ? get_term($main_category) : get_the_terms($post_id, $taxonomy)[0];

    return $category;
  }

}
