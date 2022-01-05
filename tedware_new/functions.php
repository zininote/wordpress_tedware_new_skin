<?php
// 피드 링크 추가
function tedware_setup() {
    add_theme_support( 'automatic-feed-links' );
}
add_action( 'after_setup_theme', 'tedware_setup' );

// 메뉴 활성화
register_nav_menus(array(
    'main_menu' => __( '메인 메뉴', 'tedware' ),
));

//이모티콘 강제전환 삭제
add_filter( 'emoji_svg_url', '__return_false' );

function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

// tinymce 모든 태그 허용
function override_mce_options($initArray) {
    $opts = '*[*]';
    $initArray['valid_elements'] = $opts;
    $initArray['extended_valid_elements'] = $opts;
    $initArray[ 'force_p_newlines' ] = true;
    $initArray[ 'remove_linebreaks' ] = FALSE;
    $initArray[ 'force_br_newlines' ] = FALSE;
    $initArray[ 'remove_trailing_nbsp' ] = FALSE;
    $initArray[ 'apply_source_formatting' ] = FALSE;
    $initArray[ 'convert_newlines_to_brs' ] = FALSE;
    $initArray[ 'verify_html' ] = FALSE;
    $initArray[ 'remove_redundant_brs' ] = FALSE;
    $initArray[ 'validate_children' ] = FALSE;
    $initArray[ 'forced_root_block' ]= '';
    $initArray[ 'apply_source_formatting' ]= TRUE;
    
    return $initArray;
}
add_filter('tiny_mce_before_init', 'override_mce_options');

// 자동으로 <p> 태그 삽입 금지
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

// 자동으로 인용부호 바꾸기 금지
foreach( array(
    'bloginfo',
    'the_content',
    'the_excerpt',
    'the_title',
    'comment_text',
    'comment_author',
    'link_name',
    'link_description',
    'link_notes',
    'list_cats',
    'nav_menu_attr_title',
    'nav_menu_description',
    'single_post_title',
    'single_cat_title',
    'single_tag_title',
    'single_month_title',
    'term_description',
    'term_name',
    'widget_title',
    'wp_title'
) as $sQuote_disable_for )
remove_filter( $sQuote_disable_for, 'wptexturize' );

// --------- TinyMce WYSIWYG 가능토록 만드는 코드 조각 -------
function my_editor_style($url) {
 
  if ( !empty($url) )
    $url .= ',';
 
  // Change the path here if using sub-directory
  $url .= trailingslashit( get_stylesheet_directory_uri() ) . 'editor-style.css';
 
  return $url;
}
add_filter('mce_css', 'my_editor_style');

// tinymce 에디터에 아이콘 추가
function my_custom_add_buttons( $buttons ) {
    array_push( $buttons, 'my_normal_button', 'my_h2_button', 'my_info_button', 'my_cap_button', 'my_etc_button','my_pseudo_button','my_excel_button','my_vba_button','my_html_button','my_css_button',
  'my_javascript_button','my_python_button');
    return $buttons;
}
add_filter( 'mce_buttons', 'my_custom_add_buttons' );
function mce_button_js( $plugin_array ) {
    //   $plugin_array['my_buttons'] = trailingslashit( get_template_directory_uri() ) . 'editor-plugin.js';
        $plugin_array['my_tinymce_plugin'] = trailingslashit( get_stylesheet_directory_uri() ) . 'editor-style.js'; //get_template_directory_uri() . '/js/tinymce.js';

  return $plugin_array;
}
add_filter( 'mce_external_plugins', 'mce_button_js' );

// 메인 Style 연결
/*
function tedware_scripts() {
    wp_enqueue_style( 'tedware_css', get_theme_file_uri( '/style.css' ) );
}
add_action( 'wp_enqueue_scripts', 'tedware_scripts' );
*/

// 카테고리를 첫번째 포스트로 강제이동
/*
function my_redirect_to_post() {
    if (is_category()) {
        $category = get_the_category();
        
        //global $wp_query;
        $wp_query = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 1,
            'cat' => $category[0]->cat_ID,
            'tag__in' => get_term_by('name', '_공지', 'post_tag')->term_id,
        ));
        if($wp_query->have_posts()) :
            wp_redirect(get_permalink($wp_query->post->ID));
            return;
        endif;
        $posts = query_posts('showposts=1&cat='.$category[0]->cat_ID);
        wp_redirect(get_permalink($post->ID));
    }
}
add_action( 'template_redirect', 'my_redirect_to_post' );
*/

// 랜덤으로 암호화 이름짓기
/*
function custom_unique_post_slug( $slug, $post_ID, $post_status, $post_type ) {
//    if ( $custom_post_type == $post_type ) {
        $post = get_post($post_ID);
        if ( empty($post->post_name) || $slug != $post->post_name ) {
            $slug = md5( time() );
        }
//    }
    return $slug;
}
add_filter( 'wp_unique_post_slug', 'custom_unique_post_slug', 10, 4 );
*/





// 포스트 제목만 검색
/*
function wpse_11826_search_by_title( $search, $wp_query ) {
    if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) {
        global $wpdb;

        $q = $wp_query->query_vars;
        $n = ! empty( $q['exact'] ) ? '' : '%';

        $search = array();

        foreach ( ( array ) $q['search_terms'] as $term )
            $search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );

        if ( ! is_user_logged_in() )
            $search[] = "$wpdb->posts.post_password = ''";

        $search = ' AND ' . implode( ' AND ', $search );
    }
    return $search;
}
add_filter( 'posts_search', 'wpse_11826_search_by_title', 10, 2 );
*/

// 메인 쿼리 컨트롤러
/*
function my_modify_main_query( $query ) {
	
    global $tw_custom_query;
    if( $tw_custom_query == 1 ) {
        global $category_slug;
        switch($category_slug) {
            case 'xxxx':
                $query->query_vars['orderby'] = 'date';
                $query->query_vars['order'] = 'ASC';
            break;
            default:
            break;           
        }
    }
	
    if( $query->is_main_query() && ! is_admin() && $query->is_search() ) {

        // Change the query parameters
        $query->query_vars['posts_per_page'] = 10;

    }
}
add_action( 'pre_get_posts', 'my_modify_main_query' );
*/




// ---------------- TinyMce 스타일 드랍 다운 메뉴 ----------------
/*
add_filter( 'tiny_mce_before_init', 'fb_mce_before_init' );

function fb_mce_before_init( $settings ) {

    $style_formats = array(
        array(
            'title' => 'site link',
            'selector' => 'p,ul',
            'classes' => 'link'
        ),
        array(
            'title' => 'file link',
            'selector' => 'p,ul',
            'classes' => 'file'
        ),
        array(
            'title' => 'ref',
            'selector' => 'p,ul',
            'classes' => 'ref'
        ),
        array(
            'title' => 'img',
            'selector' => 'p,ul',
            'classes' => 'img'
        ),
        array(
            'title' => 'warn',
            'selector' => 'p,ul',
            'classes' => 'warn'
        ),
        array(
            'title' => 'caption',
            'selector' => 'p,ul',
            'classes' => 'caption'
        ),
		array(
            'title' => 'quote',
            'selector' => 'p,ul',
            'classes' => 'q',
        ),
        array(
            'title' => 'pre',
            'block' => 'div',
            'wrapper' => true,
            'classes' => 'pre',
        ),
    );

    $settings['style_formats'] = json_encode( $style_formats );
	$settings['block_formats'] = 'Paragraph=p;Heading 2=h2;Pre=pre';

    return $settings;

}
*/


// ---------------- TinyMce 바로가기 키 ----------------------





// function my_custom_add_plugin( $plugin_array ) {
    
//     return $plugin_array;
// }
// add_filter( 'mce_external_plugins', 'my_custom_add_plugin' );

// >
// function add_pages_to_dropdown( $pages, $r ){
//     if ( ! isset( $r[ 'name' ] ) )
//         return $pages;

//     if ( 'page_on_front' == $r[ 'name' ] ) {
//         $args = array(
//             'post_type' => 'portfolio'
//         );

//         $portfolios = get_posts( $args );
//         $pages = array_merge( $pages, $portfolios );
//     }

//     return $pages;
// }
// add_filter( 'get_pages', 'add_pages_to_dropdown', 10, 2 );



?>