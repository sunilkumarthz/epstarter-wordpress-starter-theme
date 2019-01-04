<?php
/**
 * Function to display breadcrumbs in our theme
 *
 * @package epstarter
 * @since 1.0.0
 * @version 1.0.0
 */


/* ---------------------------------------------------------------------------
 * Breadcrumbs
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'epstarter_breadcrumbs' ) )
{
  function epstarter_breadcrumbs( $class = false  ){
    global $post;

    $translate['home']    = 'Home';

    $homeLink = home_url();
    $separator = ' <span><i class="fa fa-chevron-right"></i></span>';


    // Plugin | bbPress -----------------------------------
    if( function_exists('is_bbpress') && is_bbpress() ){
      bbp_breadcrumb( array(
                        'before'       => '<ul class="breadcrumbs">',
                        'after'        => '</ul>',
                        'sep'          => '<i class="fa fa-chevron-right"></i>',
                        'crumb_before' => '<li>',
                        'crumb_after'  => '</li>',
                        'home_text'    => $translate['home'],
                      ) );
      return true;
    } // end: bbPress -------------------------------------


    // Default breadcrumbs --------------------------------
    $breadcrumbs = array();

    // Home prefix --------------------------------
    $breadcrumbs[] =  '<a href="'. $homeLink .'">'. $translate['home'] .'</a>';

    // Blog -------------------------------------------
    if( get_post_type() == 'post' ){

      $blogID = false;

      if( get_option( 'page_for_posts' ) ){
        $blogID = get_option( 'page_for_posts' ); // Setings / Reading
      }

      if( $blogID ){

        $blog_post = get_post( $blogID );

        // Blog Page has parent
        if( $blog_post && $blog_post->post_parent ){

          $parent_id  = $blog_post->post_parent;
          $parents = array();

          while( $parent_id ) {
            $page = get_page( $parent_id );
            $parents[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
            $parent_id  = $page->post_parent;
          }
          $parents = array_reverse( $parents );
          $breadcrumbs = array_merge_recursive($breadcrumbs, $parents);

        }

        $breadcrumbs[] = '<a href="'. get_permalink( $blogID ) .'">'. get_the_title( $blogID ) .'</a>';

      }
    }

    if( is_front_page() || is_home() ){

    // do nothing

    // Plugin | Events Calendar -------------------------------------------
    } elseif( function_exists( 'tribe_is_month' ) && ( tribe_is_event_query() || tribe_is_month() || tribe_is_event() || tribe_is_day() || tribe_is_venue() ) ) {

      if( function_exists( 'tribe_get_events_link' ) ){
        $breadcrumbs[] = '<a href="'. tribe_get_events_link() .'">'. tribe_get_events_title() .'</a>';
      }

    // Blog | Tag -------------------------------------
    } elseif( is_tag() ){

      $breadcrumbs[] = '<a href="'. curPageURL() .'">' . single_tag_title('', false) . '</a>';

    // Blog | Category --------------------------------
    } elseif( is_category() ){

      $cat = get_term_by( 'name', single_cat_title('',false), 'category' );
      if( $cat && $cat->parent ){
        $breadcrumbs[] = get_category_parents( $cat->parent, true, $separator );
      }

      $breadcrumbs[] = '<a href="'. curPageURL() .'">' . single_cat_title('', false) . '</a>';

    // Blog | Author ----------------------------------
    } elseif( is_author() ){

      $breadcrumbs[] = '<a href="'. curPageURL() .'">' . get_the_author() . '</a>';

    // Blog | Day -------------------------------------
    } elseif( is_day() ){

      $breadcrumbs[] = '<a href="'. get_year_link( get_the_time('Y') ) . '">'. get_the_time('Y') .'</a>';
      $breadcrumbs[] = '<a href="'. get_month_link( get_the_time('Y'), get_the_time('m') ) .'">'. get_the_time('F') .'</a>';
      $breadcrumbs[] = '<a href="'. curPageURL() .'">'. get_the_time('d') .'</a>';

    // Blog | Month -----------------------------------
    } elseif( is_month() ){

      $breadcrumbs[] = '<a href="' . get_year_link( get_the_time('Y') ) . '">' . get_the_time('Y') . '</a>';
      $breadcrumbs[] = '<a href="'. curPageURL() .'">'. get_the_time('F') .'</a>';

    // Blog | Year ------------------------------------
    } elseif( is_year() ){

      $breadcrumbs[] = '<a href="'. curPageURL() .'">'. get_the_time('Y') .'</a>';

    // Single -----------------------------------------
    } elseif( is_single() && ! is_attachment() ){

      // Custom Post Type -----------------
      if( get_post_type() != 'post' ){

        $post_type      = get_post_type_object(get_post_type());
        $slug         = $post_type->rewrite;

        // Category ----------
        // if( $portfolio_page_id ){
        //
        //   $terms = get_the_terms( get_the_ID(), 'portfolio-types' );
        //   if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        //     $term = $terms[0];
        //     $breadcrumbs[] = '<a href="'. get_term_link( $term ) .'">'. $term->name .'</a>';
        //   }
        //
        // }

        // Single Item --------
        $breadcrumbs[] = '<a href="' . curPageURL() . '">'. get_the_title().'</a>';

      // Blog | Single --------------------
      } else {

        $cat = get_the_category();
        if( ! empty( $cat ) ){
          $breadcrumbs[] = get_category_parents( $cat[0], true, $separator );
        }

        $breadcrumbs[] = '<a href="' . curPageURL() . '">'. get_the_title() .'</a>';

      }

    // Taxonomy ---------------------------------------
    } elseif( ! is_page() && get_post_taxonomies() ){

      // use if you have any taxonomy ------------------------
      $post_type = get_post_type_object( get_post_type() );


      $breadcrumbs[] = '<a href="' . curPageURL() . '">' . single_cat_title('', false) . '</a>';

    // Page with parent -------------------------------
    } elseif( is_page() && $post->post_parent ){

      $parent_id  = $post->post_parent;
      $parents = array();

      while( $parent_id ) {
        $page = get_page( $parent_id );
        $parents[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $parents = array_reverse( $parents );
      $breadcrumbs = array_merge_recursive($breadcrumbs, $parents);

      $breadcrumbs[] = '<a href="' . curPageURL() . '">'. get_the_title( get_the_id() ) .'</a>';

    // Default ----------------------------------------
    } else {

      $breadcrumbs[] = '<a href="' . curPageURL() . '">'. get_the_title( get_the_id() ) .'</a>';

    }

    // PRINT ------------------------------------------------------------------
    echo '<ul class="breadcrumbs '. $class .'">';

      $count = count( $breadcrumbs );
      $i = 1;

      foreach( $breadcrumbs as $bk => $bc ){

        if( strpos( $bc , $separator ) ){

          // Category parents fix
          echo '<li>'. $bc .'</li>';

        } else {

          if( $i == $count ) $separator = '';
          echo '<li>'. $bc . $separator .'</li>';

        }

        $i++;

      }

    echo '</ul>';

  }
}


/* ---------------------------------------------------------------------------
 * Current page URL
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'curPageURL' ) )
{
  function curPageURL(){
    $pageURL = 'http';
    if( is_ssl() ) $pageURL .= "s";
    $pageURL .= "://";
    if( $_SERVER["SERVER_PORT"] != "80" ) {
      $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
      $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
   }
   return $pageURL;
  }
}
