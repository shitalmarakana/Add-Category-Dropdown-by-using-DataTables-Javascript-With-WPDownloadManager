<?php

get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

<div id="main-content">




<?php if ( ! $is_page_builder_used ) : ?>

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( ! $is_page_builder_used ) : ?>

					<h1 class="entry-title main_title"><?php the_title(); ?></h1>
				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_featured_image';
					$titletext = get_the_title();
					$alttext = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
					$thumbnail = get_thumbnail( $width, $height, $classtext, $alttext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					if ( 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) && '' !== $thumb )
						print_thumbnail( $thumb, $thumbnail["use_timthumb"], $alttext, $width, $height );
				?>

				<?php endif; ?>

					<div class="entry-content">
                    
                    <?php

if (is_user_logged_in()) {
     // Display content for logged-in users

	$current_user = wp_get_current_user();
	$currentusername = $current_user->user_login;
	
	//print_r($current_user);
	
	//if( current_user_can( 'administrator' ) ){} // only if administrator
	

	

	//$error_msg = '';
	$_SESSION['error_msg']='';
	if($currentusername == "Test" || in_array( 'administrator', (array) $current_user->roles )){
		
		
		the_content();
	}
	else {
			wp_destroy_current_session();
			session_start();
			$error_msg = "Please enter Correct User Name and Password!";
			$_SESSION['error_msg'] = $error_msg;
			
			header('Location: '.get_site_url().'/library/');
			
		 //echo apply_filters( 'the_content','[wpdm_login_form redirect="'.get_site_url().'/library/"]');
	}
	/*else if($currentusername != "Test"){
		//$error_msg = "Please enter Correct User Name and Password!";
		 wp_destroy_current_session();
			header('Location: '.get_site_url().'/library/');
		//wp_destroy_current_session();
		//wp_die();
	}*/
	
}
else { 
// Display content for non-logged-in users

    echo apply_filters( 'the_content','[wpdm_login_form redirect="'.get_site_url().'/library/"]');

	
}
?>


					
					<?php
						

						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
					?>
					</div>

				<?php
					if ( ! $is_page_builder_used && comments_open() && 'on' === et_get_option( 'divi_show_pagescomments', 'false' ) ) comments_template( '', true );
				?>

				</article>

			<?php endwhile; ?>

<?php if ( ! $is_page_builder_used ) : ?>

			</div>

			<?php get_sidebar(); ?>
		</div>
	</div>

<?php endif; ?>

</div>

<?php

get_footer();
