<?php

/**
 * User Profile Roles Metabox
 * 
 * @package User/Profiles/Metaboxes/Roles
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Render the capabilities metabox for user profile screen
 *
 * @since 0.1.0
 *
 * @param WP_User $user The WP_User object to be edited.
 */
function wp_user_profiles_roles_metabox( $user = null ) {

	// Get the roles global
	$sites = get_blogs_of_user( $user->ID, true ); ?>

	<table class="form-table">

		<?php foreach ( $sites as $site_id => $site ) :

			// Switch to this site
			if ( is_multisite() ) {

				// Skip if user cannot manage
				if ( ( get_current_blog_id() !== $site_id ) && ! current_user_can( 'manage_sites' ) ) {
					continue;
				}

				switch_to_blog( $site_id );
			} ?>

			<tr class="user-role-wrap">
				<th>
					<label for="role[<?php echo $site_id; ?>]">
						<?php echo $site->blogname; ?><br>
						<span class="description"><?php echo $site->siteurl; ?></span>
					</label>
				</th>
				<td><select name="role[<?php echo $site_id; ?>]" id="role[<?php echo $site_id; ?>]" <?php disabled( ! IS_PROFILE_PAGE && ! is_network_admin(), false ); ?>>
						<?php

						// Compare user role against currently editable roles
						$user_roles = array_intersect( array_values( $user->roles ), array_keys( get_editable_roles() ) );
						$user_role  = reset( $user_roles );

						// Print the full list of roles
						wp_dropdown_roles( $user_role );

						// print the 'no role' option. Make it selected if the user has no role yet.
						if ( $user_role ) : ?>

							<option value=""><?php esc_html_e( '&mdash; No role for this site &mdash;', 'wp-user-profiles' ); ?></option>

						<?php else : ?>

							<option value="" selected="selected"><?php esc_html_e( '&mdash; No role for this site &mdash;', 'wp-user-profiles' ); ?></option>

						<?php endif; ?>

					</select>
				</td>
			</tr>

		<?php

		// Switch back to this site
		if ( is_multisite() ) {
			restore_current_blog();
		}

		endforeach; ?>

	</table>

<?php
}
