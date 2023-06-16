<?php
	if ( ! defined( 'ABSPATH' ) ) {
		die;
	} // Cannot access pages directly.
	if ( ! class_exists('TTBM_Settings_General') ) {
		class TTBM_Settings_General {
			public function __construct() {
				add_action('add_ttbm_settings_tab_content', [$this, 'general_settings']);
				add_action('ttbm_settings_save', [$this, 'save_general_settings']);
				//********Location************//
				add_action('wp_ajax_load_ttbm_location_form', [$this, 'load_ttbm_location_form']);
				add_action('wp_ajax_nopriv_load_ttbm_location_form', [$this, 'load_ttbm_location_form']);
				add_action('wp_ajax_ttbm_reload_location_list', [$this, 'ttbm_reload_location_list']);
				add_action('wp_ajax_nopriv_ttbm_reload_location_list', [$this, 'ttbm_reload_location_list']);
				/************add New location save********************/
				add_action('wp_ajax_ttbm_new_location_save', [$this, 'ttbm_new_location_save']);
				add_action('wp_ajax_nopriv_ttbm_new_location_save', [$this, 'ttbm_new_location_save']);
			}
			public function general_settings($tour_id) {
				?>
				<div class="tabsItem ttbm_settings_general" data-tabs="#ttbm_general_info">
					<h5><?php esc_html_e('General Information Settings', 'tour-booking-manager'); ?></h5>
					<div class="divider"></div>
					<table class="layoutFixed">
						<tbody>
						<?php $this->duration($tour_id); ?>
						<?php $this->start_price($tour_id); ?>
						<?php $this->max_people($tour_id); ?>
						<?php $this->age_range($tour_id); ?>
						<?php $this->start_place($tour_id); ?>
						<?php $this->location($tour_id); ?>
						<?php $this->full_location($tour_id); ?>
						<?php $this->short_des($tour_id); ?>
						</tbody>
					</table>
				</div>
				<?php
			}
			public function duration($tour_id) {
				$value_name = 'ttbm_travel_duration';
				$value = TTBM_Function::get_post_info($tour_id, $value_name);
				$duration_type = TTBM_Function::get_post_info($tour_id, 'ttbm_travel_duration_type', 'day');
				$placeholder = esc_html__('Ex: 3', 'tour-booking-manager');
				$display_name = 'ttbm_display_duration_night';
				$display = TTBM_Function::get_post_info($tour_id, $display_name, 'off');
				$checked = $display == 'off' ? '' : 'checked';
				$active = $display == 'off' ? '' : 'mActive';
				?>
				<tr>
					<th colspan="3" rowspan="2">
						<?php esc_html_e('Tour Duration', 'tour-booking-manager'); ?>
						<?php TTBM_Settings::des_p('duration'); ?>
					</th>
					<td colspan="2">
						<label>
							<input class="formControl" name="<?php echo esc_attr($value_name); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr($placeholder); ?>"/>
						</label>
					</td>
					<td colspan="2">
						<label>
							<select class="formControl" name="ttbm_travel_duration_type">
								<option value="day" <?php echo esc_attr($duration_type == 'day' ? 'selected' : ''); ?>><?php esc_html_e('Days', 'tour-booking-manager'); ?></option>
								<option value="hour" <?php echo esc_attr($duration_type == 'hour' ? 'selected' : ''); ?>><?php esc_html_e('Hours', 'tour-booking-manager'); ?></option>
								<option value="min" <?php echo esc_attr($duration_type == 'min' ? 'selected' : ''); ?>><?php esc_html_e('Minutes', 'tour-booking-manager'); ?> </option>
							</select>
						</label>
					</td>
				</tr>
				<tr>
					<th colspan="2">
						<div class="dFlex">
							<h5 class="mR_xs"><?php esc_html_e('Night:', 'tour-booking-manager'); ?></h5>
							<?php MP_Custom_Layout::switch_button($display_name, $checked); ?>
						</div>
					</th>
					<td colspan="2">
						<div class="<?php echo esc_attr($active); ?>" data-collapse="#<?php echo esc_attr($display_name); ?>">
							<label>
								<input class="formControl" name="ttbm_travel_duration_night" value="<?php echo TTBM_Function::get_post_info($tour_id, 'ttbm_travel_duration_night'); ?>" placeholder="<?php echo esc_attr($placeholder); ?>"/>
							</label>
						</div>
					</td>
				</tr>
				<?php
			}
			public function start_price($tour_id) {
				$display_name = 'ttbm_display_price_start';
				$display = TTBM_Function::get_post_info($tour_id, $display_name, 'on');
				$value_name = 'ttbm_travel_start_price';
				$value = TTBM_Function::get_post_info($tour_id, $value_name);
				$placeholder = esc_html__('Type Start Price', 'tour-booking-manager');
				$checked = $display == 'off' ? '' : 'checked';
				$active = $display == 'off' ? '' : 'mActive';
				?>
				<tr>
					<th colspan="3"><?php esc_html_e('Tour Start Price', 'tour-booking-manager'); ?></th>
					<td><?php MP_Custom_Layout::switch_button($display_name, $checked); ?></td>
					<td colspan="3">
						<label data-collapse="#<?php echo esc_attr($display_name); ?>" class="<?php echo esc_attr($active); ?>">
							<input class="formControl" name="<?php echo esc_attr($value_name); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr($placeholder); ?>"/>
						</label>
					</td>
				</tr>
				<tr>
					<td colspan="7"><?php TTBM_Settings::des_p('start_price'); ?></td>
				</tr>
				<?php
			}
			public function max_people($tour_id) {
				$display_name = 'ttbm_display_max_people';
				$display = TTBM_Function::get_post_info($tour_id, $display_name, 'on');
				$value_name = 'ttbm_travel_max_people_allow';
				$value = TTBM_Function::get_post_info($tour_id, $value_name);
				$placeholder = esc_html__('50', 'tour-booking-manager');
				$checked = $display == 'off' ? '' : 'checked';
				$active = $display == 'off' ? '' : 'mActive';
				?>
				<tr>
					<th colspan="3"><?php esc_html_e('Max People Allow', 'tour-booking-manager'); ?></th>
					<td><?php MP_Custom_Layout::switch_button($display_name, $checked); ?></td>
					<td colspan="3">
						<label data-collapse="#<?php echo esc_attr($display_name); ?>" class="<?php echo esc_attr($active); ?>">
							<input class="formControl" name="<?php echo esc_attr($value_name); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr($placeholder); ?>"/>
						</label>
					</td>
				</tr>
				<tr>
					<td colspan="7"><?php TTBM_Settings::des_p('max_people'); ?></td>
				</tr>
				<?php
			}
			public function age_range($tour_id) {
				$display_name = 'ttbm_display_min_age';
				$display = TTBM_Function::get_post_info($tour_id, $display_name, 'on');
				$value_name = 'ttbm_travel_min_age';
				$value = TTBM_Function::get_post_info($tour_id, $value_name);
				$placeholder = esc_html__('Ex: 5 - 50 Years', 'tour-booking-manager');
				$checked = $display == 'off' ? '' : 'checked';
				$active = $display == 'off' ? '' : 'mActive';
				?>
				<tr>
					<th colspan="3"><?php esc_html_e('Age Range', 'tour-booking-manager'); ?></th>
					<td><?php MP_Custom_Layout::switch_button($display_name, $checked); ?></td>
					<td colspan="3">
						<label data-collapse="#<?php echo esc_attr($display_name); ?>" class="<?php echo esc_attr($active); ?>">
							<input class="formControl" name="<?php echo esc_attr($value_name); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr($placeholder); ?>"/>
						</label>
					</td>
				</tr>

				<tr>
					<td colspan="7"><?php TTBM_Settings::des_p('age_range'); ?></td>
				</tr>
				<?php
			}
			public function start_place($tour_id) {
				$display_name = 'ttbm_display_start_location';
				$display = TTBM_Function::get_post_info($tour_id, $display_name, 'on');
				$value_name = 'ttbm_travel_start_place';
				$value = TTBM_Function::get_post_info($tour_id, $value_name);
				$placeholder = esc_html__('Type Start Place...', 'tour-booking-manager');
				$checked = $display == 'off' ? '' : 'checked';
				$active = $display == 'off' ? '' : 'mActive';
				?>
				<tr>
					<th colspan="3"><?php esc_html_e('Start Place', 'tour-booking-manager'); ?></th>
					<td><?php MP_Custom_Layout::switch_button($display_name, $checked); ?></td>
					<td colspan="3">
						<label data-collapse="#<?php echo esc_attr($display_name); ?>" class="<?php echo esc_attr($active); ?>">
							<input class="formControl" name="<?php echo esc_attr($value_name); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr($placeholder); ?>"/>
						</label>
					</td>
				</tr>
				<tr>
					<td colspan="7"><?php TTBM_Settings::des_p('start_place'); ?></td>
				</tr>
				<?php
			}
			public function full_location($tour_id) {
				$display_name = 'ttbm_display_map';
				$display = TTBM_Function::get_post_info($tour_id, $display_name, 'on');
				$value_name = 'ttbm_full_location_name';
				$value = TTBM_Function::get_post_info($tour_id, $value_name);
				$placeholder = esc_html__('Please type Full address location...', 'tour-booking-manager');
				$checked = $display == 'off' ? '' : 'checked';
				$active = $display == 'off' ? '' : 'mActive';
				?>
				<tr>
					<th colspan="3"><?php esc_html_e('Full Location for Map ', 'tour-booking-manager'); ?></th>
					<td><?php MP_Custom_Layout::switch_button($display_name, $checked); ?></td>
					<td colspan="3">
						<label data-collapse="#<?php echo esc_attr($display_name); ?>" class="<?php echo esc_attr($active); ?>">
							<textarea class="formControl" name="<?php echo esc_attr($value_name); ?>" rows="4" placeholder="<?php echo esc_attr($placeholder); ?>"><?php echo esc_attr($value); ?></textarea>
						</label>
					</td>
				</tr>
				<tr>
					<td colspan="7"><?php TTBM_Settings::des_p('full_location'); ?></td>
				</tr>
				<?php
			}
			public function short_des($tour_id) {
				$display_name = 'ttbm_display_description';
				$display = TTBM_Function::get_post_info($tour_id, $display_name, 'on');
				$value_name = 'ttbm_short_description';
				$value = TTBM_Function::get_post_info($tour_id, $value_name);
				$placeholder = esc_html__('Please Type Short Description...', 'tour-booking-manager');
				$checked = $display == 'off' ? '' : 'checked';
				$active = $display == 'off' ? '' : 'mActive';
				?>
				<tr>
					<th colspan="3"><?php esc_html_e('Short Description', 'tour-booking-manager'); ?></th>
					<td><?php MP_Custom_Layout::switch_button($display_name, $checked); ?></td>
					<td colspan="3">
						<label data-collapse="#<?php echo esc_attr($display_name); ?>" class="<?php echo esc_attr($active); ?>">
							<textarea class="formControl" name="<?php echo esc_attr($value_name); ?>" rows="4" placeholder="<?php echo esc_attr($placeholder); ?>"><?php echo esc_attr($value); ?></textarea>
						</label>
					</td>
				</tr>
				<tr>
					<td colspan="7"><?php TTBM_Settings::des_p('short_des'); ?></td>
				</tr>
				<?php
			}
			
			//************************//
			public function location($tour_id) {
				$display_name = 'ttbm_display_location';
				$display = TTBM_Function::get_post_info($tour_id, $display_name, 'on');
				$checked = $display == 'off' ? '' : 'checked';
				?>
				<tr>
					<th colspan="3">
						<?php esc_html_e('Tour Location', 'tour-booking-manager'); ?>
						<?php MP_Custom_Layout::popup_button_xs('add_new_location_popup', esc_html__('Create New Location', 'tour-booking-manager')); ?>
					</th>
					<td><?php MP_Custom_Layout::switch_button($display_name, $checked); ?></td>
					<td colspan="3" class="ttbm_location_select_area"><?php self::location_select($tour_id); ?></td>
				</tr>
				<tr>
					<td colspan="7"><?php TTBM_Settings::des_p('location'); ?></td>
				</tr>
				<?php
				self::add_new_location_popup();
			}
			public static function location_select($tour_id) {
				if (get_post_type($tour_id) == TTBM_Function::get_cpt_name()) {
					$location_key = 'ttbm_location_name';
				} else {
					$location_key = 'ttbm_hotel_location';
				}
				$value = TTBM_Function::get_post_info($tour_id, $location_key, array());
				$all_location = TTBM_Function::get_all_location();
				?>
				<label>
					<select class="formControl ttbm_select2" name="<?php echo esc_attr($location_key); ?>">
						<?php foreach ($all_location as $key => $location) { ?>
							<option value="<?php echo esc_attr($key); ?>" <?php echo esc_attr($key == $value ? 'selected' : ''); ?>><?php echo esc_html($location); ?></option>
						<?php } ?>
					</select>
				</label>
				<?php
			}
			public static function add_new_location_popup() {
				?>
				<div class="mpPopup" data-popup="add_new_location_popup">
					<div class="popupMainArea">
						<div class="popupHeader">
							<h4>
								<?php esc_html_e('Add New Location', 'tour-booking-manager'); ?>
								<p class="_textSuccess_ml_dNone ttbm_success_info">
									<span class="fas fa-check-circle mR_xs"></span>
									<?php esc_html_e('Location is added successfully.', 'tour-booking-manager') ?>
								</p>
							</h4>
							<span class="fas fa-times popupClose"></span>
						</div>
						<div class="popupBody ttbm_location_form_area">
						</div>
						<div class="popupFooter">
							<div class="buttonGroup">
								<button class="_themeButton ttbm_new_location_save" type="button"><?php esc_html_e('Save', 'tour-booking-manager'); ?></button>
								<button class="_warningButton ttbm_new_location_save_close" type="button"><?php esc_html_e('Save & Close', 'tour-booking-manager'); ?></button>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
			public function load_ttbm_location_form() {
				$all_countries = ttbm_get_coutnry_arr();
				?>
				<label class="flexEqual">
					<span><?php esc_html_e('Location Name : ', 'tour-booking-manager'); ?><sup class="textRequired">*</sup></span>
					<input type="text" name="ttbm_new_location_name" class="formControl" required>
				</label>
				<p class="textRequired" data-required="ttbm_new_location_name">
					<span class="fas fa-info-circle"></span>
					<?php esc_html_e('Location name is required!', 'tour-booking-manager'); ?>
				</p>
				<?php TTBM_Settings::des_p('ttbm_new_location_name'); ?>
				<div class="divider"></div>
				<label class="flexEqual">
					<span><?php esc_html_e('Location Description : ', 'tour-booking-manager'); ?></span>
					<textarea name="ttbm_location_description" class="formControl" rows="3"></textarea>
				</label>
				<?php TTBM_Settings::des_p('ttbm_location_description'); ?>
				<div class="divider"></div>
				<label class="flexEqual">
					<span><?php esc_html_e('Location Address : ', 'tour-booking-manager'); ?></span>
					<textarea name="ttbm_location_address" class="formControl" rows="3"></textarea>
				</label>
				<?php TTBM_Settings::des_p('ttbm_location_address'); ?>
				<div class="divider"></div>
				<label class="flexEqual">
					<span><?php esc_html_e('Location Country : ', 'tour-booking-manager'); ?></span>
					<select class="formControl" name="ttbm_location_country>">
						<?php foreach ($all_countries as $key => $country) { ?>
							<option value="<?php echo esc_attr($key); ?>"><?php echo esc_html($country); ?></option>
						<?php } ?>
					</select>
				</label>
				<?php TTBM_Settings::des_p('ttbm_location_country'); ?>
				<div class="divider"></div>
				<div class="flexEqual">
					<span><?php esc_html_e('Location Image : ', 'tour-booking-manager'); ?><sup class="textRequired">*</sup></span>
					<?php TTBM_Layout::single_image_button('ttbm_location_image'); ?>
				</div>
				<p class="textRequired" data-required="ttbm_location_image">
					<span class="fas fa-info-circle"></span>
					<?php esc_html_e('Location image is required!', 'tour-booking-manager'); ?>
				</p>
				<?php TTBM_Settings::des_p('ttbm_location_image'); ?>
				<?php
				die();
			}
			public function ttbm_reload_location_list() {
				$ttbm_id = TTBM_Function::data_sanitize($_POST['ttbm_id']);
				self::location_select($ttbm_id);
				die();
			}
			//*****************//
			public function save_general_settings($tour_id) {
				if (get_post_type($tour_id) == TTBM_Function::get_cpt_name()) {
					/***************/
					$ttbm_travel_duration = TTBM_Function::get_submit_info('ttbm_travel_duration');
					$ttbm_travel_duration_type = TTBM_Function::get_submit_info('ttbm_travel_duration_type', 'day');
					update_post_meta($tour_id, 'ttbm_travel_duration', $ttbm_travel_duration);
					update_post_meta($tour_id, 'ttbm_travel_duration_type', $ttbm_travel_duration_type);
					$ttbm_display_duration = TTBM_Function::get_submit_info('ttbm_display_duration_night') ? 'on' : 'off';
					$ttbm_travel_duration_night = TTBM_Function::get_submit_info('ttbm_travel_duration_night');
					update_post_meta($tour_id, 'ttbm_travel_duration_night', $ttbm_travel_duration_night);
					update_post_meta($tour_id, 'ttbm_display_duration_night', $ttbm_display_duration);
					/***************/
					$ttbm_display_price_start = TTBM_Function::get_submit_info('ttbm_display_price_start') ? 'on' : 'off';
					$ttbm_travel_start_price = TTBM_Function::get_submit_info('ttbm_travel_start_price');
					update_post_meta($tour_id, 'ttbm_display_price_start', $ttbm_display_price_start);
					update_post_meta($tour_id, 'ttbm_travel_start_price', $ttbm_travel_start_price);
					/***************/
					$ttbm_display_max_people = TTBM_Function::get_submit_info('ttbm_display_max_people') ? 'on' : 'off';
					$ttbm_travel_max_people_allow = TTBM_Function::get_submit_info('ttbm_travel_max_people_allow');
					update_post_meta($tour_id, 'ttbm_display_max_people', $ttbm_display_max_people);
					update_post_meta($tour_id, 'ttbm_travel_max_people_allow', $ttbm_travel_max_people_allow);
					/***************/
					$ttbm_display_min_age = TTBM_Function::get_submit_info('ttbm_display_min_age') ? 'on' : 'off';
					$ttbm_travel_min_age = TTBM_Function::get_submit_info('ttbm_travel_min_age');
					update_post_meta($tour_id, 'ttbm_display_min_age', $ttbm_display_min_age);
					update_post_meta($tour_id, 'ttbm_travel_min_age', $ttbm_travel_min_age);
					/***************/
					$visible_start_location = TTBM_Function::get_submit_info('ttbm_display_start_location') ? 'on' : 'off';
					$start_location = TTBM_Function::get_submit_info('ttbm_travel_start_place');
					update_post_meta($tour_id, 'ttbm_display_start_location', $visible_start_location);
					update_post_meta($tour_id, 'ttbm_travel_start_place', $start_location);
					/***************/
					$ttbm_display_location = TTBM_Function::get_submit_info('ttbm_display_location') ? 'on' : 'off';
					$ttbm_location_name = TTBM_Function::get_submit_info('ttbm_location_name');
					update_post_meta($tour_id, 'ttbm_display_location', $ttbm_display_location);
					update_post_meta($tour_id, 'ttbm_location_name', $ttbm_location_name);
					/***************/
					$ttbm_display_map = TTBM_Function::get_submit_info('ttbm_display_map') ? 'on' : 'off';
					$ttbm_full_location_name = TTBM_Function::get_submit_info('ttbm_full_location_name');
					update_post_meta($tour_id, 'ttbm_display_map', $ttbm_display_map);
					update_post_meta($tour_id, 'ttbm_full_location_name', $ttbm_full_location_name);
					/***************/
					$visible_description = TTBM_Function::get_submit_info('ttbm_display_description') ? 'on' : 'off';
					$description = TTBM_Function::get_submit_info('ttbm_short_description');
					update_post_meta($tour_id, 'ttbm_display_description', $visible_description);
					update_post_meta($tour_id, 'ttbm_short_description', $description);
					/***************/
				}
			}
			public function ttbm_new_location_save() {
				$name = TTBM_Function::data_sanitize($_POST['name']);
				$description = TTBM_Function::data_sanitize($_POST['description']);
				$address = TTBM_Function::data_sanitize($_POST['address']);
				$country = TTBM_Function::data_sanitize($_POST['country']);
				$image = TTBM_Function::data_sanitize($_POST['image']);
				$query = wp_insert_term($name,   // the term
					'ttbm_tour_location', // the taxonomy
					array('description' => $description));
				if (is_array($query) && $query['term_id'] != '') {
					$term_id = $query['term_id'];
					update_term_meta($term_id, 'ttbm_location_address', $address);
					update_term_meta($term_id, 'ttbm_country_location', $country);
					update_term_meta($term_id, 'ttbm_location_image', $image);
				}
				die();
			}
		}
		new TTBM_Settings_General();
	}