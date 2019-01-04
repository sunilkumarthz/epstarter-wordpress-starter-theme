<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package easeblog
 * @since 1.0.0
 * @version 1.0.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div class="row">
	

<div class="col-md-12">
	<div class="comments-area" id="comments">
	<?php 
		if ( comments_open()  ) :
			echo '<h3 class="comment-title">';
			comments_number( esc_html__('No Comments','easeblog'), esc_html__('( 1 Comment )','easeblog'), esc_html__('Comments( % )','easeblog') );
			echo '</h3>';
		endif;

		echo "<div class='comments comment-list'><ol>";
		
		wp_list_comments( array(
			'avatar_size' => 60,
			'style'       => 'ol',
			'short_ping'  => true,
			'callback'    => 'ept_comments',
			'type'        => 'all'
		) );

				
		echo "</ol></div>";

		echo "<div id='comments_pagination'>";

		paginate_comments_links(array('prev_text' => '&laquo;', 'next_text' => '&raquo;'));

		echo "</div>";
		echo '</div>'; //#comments -->

		$custom_comment_field = '<div class="form-group comment-form-comment col-md-12"><textarea class="form-control" id="comment" name="comment" cols="45" rows="6" aria-required="true"></textarea></div>';  //label removed for cleaner layout
		$aria_req = '';

		$args =  array(

					  'author' =>
						' <div class="inputGroup">
							<div class="form-group comment-form-author col-md-4 col-xs-12"><input id="author" class="form-control" placeholder="'. esc_html__('Name', 'easeblog') .'" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .'" size="30"' . $aria_req . ' /></div>',

					  'email' =>
						'<div class="form-group comment-form-email col-md-4 col-xs-12"><input id="email" class="form-control" placeholder="'. esc_html__('Email', 'easeblog') .'" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .'" size="30"' . $aria_req . ' /></div>',

					  'url' =>
						'<div class="form-group comment-form-email col-md-4 col-xs-12"><input id="url" placeholder="'. esc_html__('Website', 'easeblog') .'" name="url" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author_url'] ) .'" size="30" /></div></div>',
					);	

		comment_form(array(
						'comment_field'        => $custom_comment_field,
						'comment_notes_after'  => '',
						'logged_in_as'         => '',
						'comment_notes_before' => '',
						'title_reply'          => esc_html__( 'Leave a Reply', 'easeblog' ),
						'cancel_reply_link'    => esc_html__( 'Cancel Reply', 'easeblog' ),
						'label_submit'         => esc_html__( 'Post Comment', 'easeblog' ),
						'class_submit'         =>'btn-dark',
						'fields'               => $args,
		));
	 ?>
	
</div><!-- #col-md-12 -->
</div>
<!-- /.row -->
