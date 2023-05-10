<?php	if ( ! defined( 'ABSPATH' ) ) {		die;	}	$tour_id = $tour_id ?? get_the_id();	$faqs = TTBM_Function::get_faq( $tour_id );	if ( sizeof( $faqs ) > 0 && TTBM_Function::get_post_info( $tour_id, 'ttbm_display_faq', 'on' ) != 'off' ) {		?>		<div class='ttbm_default_widget'>			<?php do_action( 'ttbm_section_title', 'ttbm_string_faq', esc_html__( 'F.A.Q ', 'tour-booking-manager' ) ); ?>			<div class='ttbm_widget_content'>				<?php					foreach ( $faqs as $key => $faq ) {						$day_title = array_key_exists( 'ttbm_faq_title', $faq ) ? html_entity_decode( $faq['ttbm_faq_title'] ) : '';						$day_text = array_key_exists( 'ttbm_faq_content', $faq ) ? html_entity_decode( $faq['ttbm_faq_content'] ) : '';						$day_images = array_key_exists( 'ttbm_faq_img', $faq ) ? html_entity_decode( $faq['ttbm_faq_img'] ) : '';						$images = explode( ',', $day_images );						?>						<div class="ttbm_faq_item">							<h5 class="ttbm_faq_title" data-open-icon="fa-plus" data-close-icon="fa-minus" data-collapse-target="#ttbm_faq_datails_<?php esc_attr_e( $key ); ?>" data-add-class="active">								<span data-icon class="fas fa-plus"></span>								<?php echo esc_html( $day_title ); ?>							</h5>							<div data-collapse="#ttbm_faq_datails_<?php esc_attr_e( $key ); ?>">								<div class="ttbm_faq_content">									<?php										if ( $day_images && sizeof( $images ) > 0 ) {											do_action( 'add_super_slider_only', $images );										}									?>									<?php echo TTBM_Function::esc_html( $day_text ); ?>								</div>							</div>						</div>					<?php } ?>			</div>		</div>		<?php } ?>