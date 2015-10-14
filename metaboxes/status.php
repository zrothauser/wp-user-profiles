<?php

/**
 * User Profile Status Metabox
 * 
 * @package User/Profiles/Metaboxes/Status
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Render the primary metabox for user profile screen
 *
 * @since 0.1.0
 *
 * @param WP_User $user The WP_User object to be edited.
 */
function wp_user_profiles_status_metabox( $user = null ) {

	// Bail if no user id or if the user has not activated their account yet
	if ( empty( $user->ID ) ) {
		return;
	}

	// Bail if user has not been activated yet (how did you get here?)
	if ( isset( $user->user_status ) && ( 2 == $user->user_status ) ) : ?>

		<p class="not-activated"><?php esc_html_e( 'User account has not yet been activated', 'wp-user-profiles' ); ?></p>

		<?php return;

	endif; ?>

	<div class="submitbox">
		<div id="minor-publishing">
			<div id="misc-publishing-actions">
				<?php

				// Get the spam status once here to compare against below
				if ( IS_PROFILE_PAGE && ( ! in_array( $user->user_login, get_super_admins() ) ) ) : ?>

					<div class="misc-pub-section" id="comment-status-radio">
						<label class="approved"><input type="radio" name="user_status" value="ham" <?php checked( $user->user_status, 2 ); ?>><?php esc_html_e( 'Active', 'wp-user-profiles' ); ?></label><br>
						<label class="spam"><input type="radio" name="user_status" value="spam" <?php checked( $user->user_status, 0 ); ?>><?php esc_html_e( 'Spammer', 'wp-user-profiles' ); ?></label>
					</div>

				<?php endif ;?>

				<div class="misc-pub-section curtime misc-pub-section-last">
					<?php

					// translators: Publish box date format, see http://php.net/date
					$datef = esc_html__( 'M j, Y @ G:i', 'wp-user-profiles' );
					$date  = date_i18n( $datef, strtotime( $user->user_registered ) ); ?>

					<span id="timestamp"><?php printf( esc_html__( 'Registered on: %1$s', 'wp-user-profiles' ), '<strong>' . $date . '</strong>' ); ?></span>
				</div>
			</div>

			<div class="clear"></div>
		</div>

		<div id="major-publishing-actions">
			<div id="publishing-action">
				<a class="button" href="<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>" target="_blank"><?php esc_html_e( 'View User', 'wp-user-profiles' ); ?></a>
				<?php submit_button( esc_html__( 'Update', 'wp-user-profiles' ), 'primary', 'save', false ); ?>
				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $user->ID ); ?>" />
			</div>
			<div class="clear"></div>
		</div>
	</div>

	<?php
}
