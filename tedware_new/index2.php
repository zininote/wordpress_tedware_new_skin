<?php

// 전역변수 설정
$cat_ids = array();                     // 메뉴에 속한 카테고리들 ID
$cat_list = '';                         // 메뉴에 속한 카테고리 리스트 출력
$post_list = '';                        // 전체 포스트 리스트 출력
$content = '';                          // 현재 포스트의 내용 출력
$current_cat_id = 0;                    // 현재 포스트가 속한 카테고리 ID
$current_post_id = 0;                   // 현재 포스트의 ID
if(!is_front_page() && !is_404()) {     
    $current_cat_id = get_the_category()[0]->term_id;
    $current_post_id = get_the_ID();
}

// $cat_list 출력
$menu = wp_get_nav_menu_items('Menu 1');
if($menu) {
    $is_first = true;
    foreach($menu as $item) {
        if($item->object == 'category') {       // 메뉴에서 카테고리인 것만 담음
            $cat_id = get_post_meta($item->ID, '_menu_item_object_id', true);
            array_push($cat_ids, $cat_id);
            $current = ($cat_id == $current_cat_id) ? 'current' : 'non-current';
            if($is_first && $current_cat_id == 0) { $current = 'current'; $is_first = false; } // 현재 카테고리 ID 가 0 이라면 첫 카테고리를 current 로 설정
            $cat_list .= "<li cat='{$cat_id}' class='cat-item {$current}'><span>{$item->title}</span></li>";
        }
    }
}

// $post_list 출력
foreach($cat_ids as $cat_id) {
    $query = new WP_Query(array('cat' => $cat_id, 'posts_per_page' => -1));        // 각 카테고리에 해당하는 포스트 쿼리 요청
    while ($query->have_posts()) {
        $query->the_post();
        $title = get_the_title();
        $post_id = get_post()->ID;
        $link = esc_url(get_permalink());
        if($post_id == $current_post_id) {
            $post_list .= "<li post='{$post_id}' cat='{$cat_id}' class='post-item off current'>{$title}</li>";
        } else {
            $post_list .= "<li post='{$post_id}' cat='{$cat_id}' class='post-item off non-current'><a href='{$link}'>{$title}</a></li>";
        }
    }
}

// $content 출력
if(have_posts()){
    while(have_posts()) {
		the_post();
		$content .= '<h1 id="content-title">' . get_the_title() . '</h1>';
		$content .= '<div id="content-desc">작성일: ' . get_the_date() . '</div>';
		$content .= str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content()));
		$tags = get_the_tags();
		if($tags) {
			$content .= '<div id="tags"><i class="fa fa-tags"></i> Tags:';
			foreach($tags as $tag) {
				$content .= " <span class='tag'>#{$tag->name}</span>";
			}
			$content .= '</div>';
		}
    } 
} else {
    $content .= '<h1 id="content-title">404 Error : 요청한 페이지를 찾을 수 없습니다.</h1>';
}

// 정리 함수
wp_reset_postdata();

?>

<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width"/>
        <meta name="google-site-verification" content="VSLqZ4jMVCNL1v0UxrxMMF2fsgSfZyON7gDiwfTSmKQ" />
        <meta name="naver-site-verification" content="c77f7bb9521f009e415eb40a774953aeebbd2fe8"/>
        <meta property="og:title" content="<?php bloginfo('name'); ?>"/>
        <meta property="og:url" content="<?php echo esc_url( home_url( '/' ) ); ?>"/>
        <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/images/profile.png"/>
        <meta property="og:description" content="<?php bloginfo('description'); ?>"/>
        <title><?php wp_title(); ?></title>
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"/>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/default.css"/>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/style.css"/>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/editor-style.css"/>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <div id="layout-outer">
			<div id="layout-left">
				<div id="sidebar">
					<div id="header">
						<div id="header-title"><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></div>
					</div>
					<div id="category">
						<div id="category-title" class="cp-title">카테고리</div>
						<div id="category-list" class="cp-list"><ul><?php echo $cat_list; ?></ul></div>
					</div>
					<div id="post">
						<div id="post-title" class="cp-title"><span id="selected"></span> 포스팅 <span id="count"></span> 개</div>
						<div id="post-list" class="cp-list"><ul><?php echo $post_list; ?></ul></div>
					</div>
					<div id="search">
						<input type="text" placeholder="글 제목 검색" onfocus="this.placeholder = '';" onblur="this.placeholder = '글 제목 검색';"/>
					</div>
                    <div id="ad-sidebar">
						<div>
							<!-- desktop -->
							<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
							<ins class="adsbygoogle small-size"
								style="display:inline-block"
								data-ad-client="ca-pub-4898902051853153"
								data-ad-slot="2403754228"></ins>
							<script>
								(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</div>
					</div>
					<div id="ad-sidebar2">
						<div>
							<ins class="kakao_ad_area" style="display:none;" 
							 data-ad-unit    = "DAN-r1ddho4buw6b" 
							 data-ad-width   = "300" 
							 data-ad-height  = "250"></ins> 
							<script type="text/javascript" src="//t1.daumcdn.net/kas/static/ba.min.js" async></script>
						</div>
					</div>
				</div>
			</div>
			<div id="layout-right">
				<div id="ad-top">
					<div>
						<!-- desktop -->
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<ins class="adsbygoogle responsive-size"
							style="display:inline-block"
							data-ad-client="ca-pub-4898902051853153"
							data-ad-slot="2403754228"></ins>
						<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
						</script>
					</div>
				</div>
				<div id="main">
					<div id="tinymce">					
						<?php echo $content; ?>
					</div>
				</div>
				<div id="ad-bottom">
					<div>
						<!-- desktop -->
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<ins class="adsbygoogle responsive-size"
							style="display:inline-block"
							data-ad-client="ca-pub-4898902051853153"
							data-ad-slot="2403754228"></ins>
						<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
						</script>
					</div>
				</div>
				<div id="reply">
					<div id="disqus_thread"></div>
					<script>

					/**
					*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
					*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
					/*
					var disqus_config = function () {
					this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
					this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
					};
					*/
					(function() { // DON'T EDIT BELOW THIS LINE
					var d = document, s = d.createElement('script');
					s.src = 'https://tedware.disqus.com/embed.js';
					s.setAttribute('data-timestamp', +new Date());
					(d.head || d.body).appendChild(s);
					})();
					</script>
					<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
				</div>
				<div id="footer">
					<div id="footer-msg">This blog is powered by Wordpress, and disigned by Ted.</div>
				</div>
			</div>
			<div id="menu-button">
				<span></span><span></span><span></span>
			</div>
        </div>
        <!-- scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/highlight.pack.js"></script>
        <script>
            'use strict';

            function search_click() {
                var q = $('#search input').val();
                if(q.trim() != '') {
                    $('.cat-item.current').removeClass('current').addClass('non-current');
                    $('.post-item').removeClass('on').addClass('off');
                    $('.post-item').each(function(index) {
                        if($(this).text().toLowerCase().indexOf(q.toLowerCase()) > -1) {
                            $(this).removeClass('off').addClass('on');
                        }
                    });
                    $('#selected').text(q);
                    $('#count').text($('.post-item.on').length);
                    set_current_post_center();
                }
                $('#search input').val('');
            }

            function category_click(e) {
                if(e != undefined) {
                    $('.cat-item.current').removeClass('current').addClass('non-current');
                    $(this).parent().removeClass('non-current').addClass('current');
                }
                $('#search input').val('');
                $('.post-item').removeClass('on').addClass('off');
                $('.post-item[cat="' + $('.cat-item.current').attr('cat') + '"]').removeClass('off').addClass('on');
                $('#selected').text($('.cat-item.current').text());
                $('#count').text($('.post-item.on').length);
				set_current_post_center();
            }

            function set_current_post_center() {
				var cur = $('#post-list li.current');
				if(cur.length) {
					cur.parent()[0].scrollTop = 0;
					var target = cur[0].offsetTop - cur.parent()[0].offsetTop - 120; // 30 * 4 = 120
					if(cur.length) {
						cur.parent().animate({scrollTop: target}, 'fast');
					}
				}
            }

            $('.cat-item span').click(category_click);
            $('#search input').keypress(function(e) {
                if(e.which == 13) { search_click(); }
            });
			$('#menu-button').click(function() {
				// var toggle = $('#layout-left').width() > 0 ? '0' : '100%';
				// $('#layout-left').animate({width: toggle}, 'fast');
				$(this).toggleClass('open');
				$('html #layout-left').toggleClass('open');
			});
			
			category_click();
			hljs.initHighlightingOnLoad();
			// $('#tinymce p > code').each(function(i, block) {
			// 	hljs.highlightBlock(block);
			// });

        </script>
        <?php wp_footer(); ?>
    
        <script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
        <script type="text/javascript">
            if(!wcs_add) var wcs_add = {};
            wcs_add["wa"] = "ff6379f43c634";
            wcs_do();
        </script>
    
    </body>
</html>
