<?php
/**
 * Contact Form Shortcode
 *
 * Displays a contact form.
 *
 * @package Crux Assistant
 * @subpackage Crux
 */

function crux_contact_form_sc() {
	$nameError         = __( 'Please enter your name.', 'crux-assistant' );
	$emailError        = __( 'Please enter your email address.', 'crux-assistant' );
	$emailInvalidError = __( 'You entered an invalid email address.', 'crux-assistant' );
	$commentError      = __( 'Please enter a message.', 'crux-assistant' );

	$errorMessages = array();

	if ( isset( $_POST['submitted'] ) ) {
		if ( '' === trim( $_POST['contactName'] ) ) {
			$errorMessages['nameError'] = $nameError;
			$hasError                   = true;
		} else {
			$name = trim( $_POST['contactName'] );
		}

		if ( '' === trim( $_POST['email'] ) ) {
			$errorMessages['emailError'] = $emailError;
			$hasError                    = true;
		} elseif ( ! is_email( trim( $_POST['email'] ) ) ) {
			$errorMessages['emailInvalidError'] = $emailInvalidError;
			$hasError                           = true;
		} else {
			$email = trim( $_POST['email'] );
		}

		if ( '' === trim( $_POST['comments'] ) ) {
			$errorMessages['commentError'] = $commentError;
			$hasError                      = true;
		} else {
			if ( function_exists( 'stripslashes' ) ) {
				$comments = stripslashes( trim( $_POST['comments'] ) );
			} else {
				$comments = trim( $_POST['comments'] );
			}
		}

		if ( ! isset( $hasError ) ) {
			$emailTo = stag_theme_mod( 'general_settings', 'general_contact_email' );
			if ( ! isset( $emailTo ) || ( $emailTo == '' ) ) {
				$emailTo = get_option( 'admin_email' );
			}
			$subject = __( '[Contact Form] From ', 'crux-assistant' ) . $name;

			$body  = "Name: $name \n\nEmail: $email \n\nMessage: $comments \n\n";
			$body .= "--\n";
			$body .= __( 'This mail is sent via contact form on ', 'crux-assistant' ) . get_bloginfo( 'name' ) . "\n";
			$body .= home_url();

			$headers = __( 'From: ', 'crux-assistant' ) . $name . ' <' . $email . '>' . "\r\n" . __( 'Reply-To: ', 'crux-assistant' ) . $email;

			wp_mail( $emailTo, $subject, $body, $headers );
			$emailSent = true;
		}
	}
	?>
	<div class="contact-form-wrapper">
		<?php if ( isset( $emailSent ) && $emailSent == true ) : ?>

			<div class="stag-alert stag-alert--green">
				<p><?php esc_html_e( 'Thanks, your email was sent successfully.', 'crux-assistant' ); ?></p>
			</div>

		<?php else : ?>

			<form action="<?php the_permalink(); ?>" id="contactForm" class="contact-form" method="post">
				<h2><?php esc_html_e( 'Send a Direct Message', 'crux-assistant' ); ?></h2>

				<div class="grids">
					<p class="grid-6">
						<label for="contactName"><?php esc_html_e( 'Name', 'crux-assistant' ); ?></label>
						<input type="text" name="contactName" id="contactName" value="
						<?php
						if ( isset( $_POST['contactName'] ) ) {
							echo $_POST['contactName'];}
						?>
						">
						<?php if ( isset( $errorMessages['nameError'] ) ) { ?>
							<span class="error"><?php echo esc_html( $errorMessages['nameError'] ); ?></span>
						<?php } ?>
					</p>

					<p class="grid-6">
						<label for="email"><?php esc_html_e( 'Email', 'crux-assistant' ); ?></label>
						<input type="email" name="email" id="email" value="
						<?php
						if ( isset( $_POST['email'] ) ) {
							echo $_POST['email'];}
						?>
						">
						<?php if ( isset( $errorMessages['emailError'] ) ) { ?>
							<span class="error"><?php echo esc_html( $errorMessages['emailError'] ); ?></span>
						<?php } ?>
						<?php if ( isset( $errorMessages['emailInvalidError'] ) ) { ?>
							<span class="error"><?php echo esc_html( $errorMessages['emailInvalidError'] ); ?></span>
						<?php } ?>
					</p>
				</div>

				<p class="commentsText">
					<label for="commentsText"><?php esc_html_e( 'Comment', 'crux-assistant' ); ?></label>
					<textarea rows="8" name="comments" id="commentsText" >
					<?php
					if ( isset( $_POST['comments'] ) ) {
						if ( function_exists( 'stripslashes' ) ) {
							echo stripslashes( $_POST['comments'] );
						} else {
							echo $_POST['comments']; }
					}
					?>
					</textarea>
					<?php if ( isset( $errorMessages['commentError'] ) ) { ?>
						<span class="error"><?php echo esc_html( $errorMessages['commentError'] ); ?></span>
					<?php } ?>
				</p>

				<p class="buttons">
					<input type="submit" id="submitted" class="contact-form-button" name="submitted" value="<?php esc_html_e( 'Send Message', 'crux-assistant' ); ?>">
				</p>
			</form>

		<?php endif; ?>
	</div>
	<?php
}
add_shortcode( 'crux_contact_form', 'crux_contact_form_sc' );
