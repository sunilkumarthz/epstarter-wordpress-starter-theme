<?php get_header(); ?>


<section id="primary" class="content-area">
	<main id="main" class="site-main">

		<div class="container">
		  <div class="row">
		    <div class="col text-center pt-3">

						<?php
						if ( have_posts() ) {

							// Load posts loop.
							while ( have_posts() ) {
								the_post();
								get_template_part( 'template-parts/content/content' );
							}

							// Previous/next page navigation.
							epstarter_the_posts_navigation();

						} else {

							// If no content, include the "No posts found" template.
							get_template_part( 'template-parts/content/content', 'none' );

						}
						?>

		    </div>
		    <!-- /.col-md-12 -->
		  </div>
		  <!-- /.row -->
		</div>
		<!-- /.container -->

	</main><!-- .site-main -->
</section><!-- .content-area -->


<?php get_footer(); ?>
