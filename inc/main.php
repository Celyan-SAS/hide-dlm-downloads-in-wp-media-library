<?php
/**
 * WordPress WP&Co Hide DLM downloads in WP Media Library main class
*
* @author yann@abc.fr
* @see: https://github.com/Celyan-SAS/hide-dlm-downloads-in-wp-media-library
*
*/
class wpcHideDlm {
	
	/**
	 * Class constructor
	 *
	 */
	public function __construct() {
		
		/** Filter WP Media Manager grid view **/
		add_filter( 'ajax_query_attachments_args', array( $this, 'hide_dlm_media_overlay_view' ) );
		
		/** Filter WP Media Manager list view **/
		add_action( 'pre_get_posts', array( $this, 'hide_dlm_media_list_view' ) );
	}
	
	/**
	 * Hide dlm downloadable files in the WP Media Library (grid view)
	 * @see: https://wordpress.stackexchange.com/questions/271584/can-i-hide-the-attachments-from-media-which-i-uploaded-from-front-end
	 * @see: https://wordpress.stackexchange.com/questions/166029/get-post-ids-from-wp-query
	 * @param array $query_array
	 */
	public function hide_dlm_media_overlay_view( $query_array = array() ) {
		
		if ( ! is_admin() ) {
	        return $query_array;
	    }
	    
	    /**
	     * Solution 1 (unused)
	     *
	    $dlms = new WP_Query( array (
	    	'post_type'			=> array( 'dlm_download', 'dlm_download_version' ),
	    	'posts_per_page'	=> -1,
	    	'fields'			=> 'ids'
		) );
		$excluded_cpt_ids = 
		$query_array['post_parent__not_in'] = $dlms->posts;
		*/
	    
	    /**
	     * Solution 2
	     * 
	     * variant:
	     * $query['meta_key']		= '_wp_attached_file';
	     * $query['meta_value']	= 'dlm_uploads';
	     * $query['meta_compare']	= 'NOT LIKE';
	     */
	    $query_array['meta_query'] = array(
	    	array(
	    		'key'		=> '_wp_attached_file',
	    		'value'		=> 'dlm_uploads',
	    		'compare'	=> 'NOT LIKE'
	    	)
	    );
	    
		return $query_array;
	}
	
	/**
	 * Hide dlm downloadable files in the WP Media Library (list view)
	 * @see: https://wordpress.stackexchange.com/questions/271584/can-i-hide-the-attachments-from-media-which-i-uploaded-from-front-end
	 * @param object $wp_query
	 * @return void
	 */
	public function hide_dlm_media_list_view( $wp_query ) {
		
		if ( ! is_admin() ) {
	        return;
	    }
		
	    if ( ! $wp_query->is_main_query() ) {
        	return;
    	}
    
    	$screen = get_current_screen();
    	if ( ! $screen || 'upload' !== $screen->id || 'attachment' !== $screen->post_type ) {
        	return;
		}
		
		$wp_query->set(
			'meta_query',
			array( array(
	    		'key'		=> '_wp_attached_file',
	    		'value'		=> 'dlm_uploads',
	    		'compare'	=> 'NOT LIKE'
	    	) )
	    );
		
		return;
	}
}
?>