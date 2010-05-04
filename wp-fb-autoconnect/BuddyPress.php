<?
/*
 * BuddyPress-specific actions/filters go here.
 */



/*
 * Add a Facebook Login button to the Buddypress sidebar login widget
 * NOTE: If you use this, you mustn't also use the built-in widget - just one or the other!
 */
add_action( 'bp_after_sidebar_login_form', 'jfb_bp_add_fb_login_button' );
function jfb_bp_add_fb_login_button()
{
  if ( !is_user_logged_in() )
  {
      echo "<p></p>";
      jfb_output_facebook_btn();
      jfb_output_facebook_init();
      jfb_output_facebook_callback();
  }
}



/*
 * Modify the userdata for BuddyPress by changing login names from the default FB_xxxxxx
 * to something prettier for BP's social link system
 */
add_filter( 'wpfb_insert_user', 'jbp_bp_modify_userdata', 10, 2 );
function jbp_bp_modify_userdata( $wp_userdata, $fb_userdata )
{
    $counter = 1;
    $name = str_replace( ' ', '', $fb_userdata['name'] );
    if ( username_exists( $name ) )
    {
        do
        {
            $username = $name;
            $counter++;
            $username = $username . $counter;
        } while ( username_exists( $username ) );
    }
    else
    {
        $username = $name;
    }
    $username = strtolower( sanitize_user($username) );

    $wp_userdata['user_login']   = $username;
    $wp_userdata['user_nicename']= $username;
    return $wp_userdata;
}



?>