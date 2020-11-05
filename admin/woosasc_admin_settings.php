<?php

if (!defined('ABSPATH'))
    exit;

if (!class_exists('WOOSASC_settings')) {

    class WOOSASC_settings {

        protected static $WOOSASC_instance;
        
        function WOOSASC_create_posttype() {

            $labels = array(
                'name'                  => _x( 'Saved Carts', 'Post type general name', 'woosasc' ),
                'singular_name'         => _x( 'Saved Cart', 'Post type singular name', 'woosasc' ),
                'menu_name'             => _x( 'Saved Carts', 'Admin Menu text', 'woosasc' ),
                'name_admin_bar'        => _x( 'Saved Carts', 'Add New on Toolbar', 'woosasc' ),
                'add_new'               => __( 'Add New', 'woosasc' ),
                'add_new_item'          => __( 'Add New Saved Cart', 'woosasc' ),
                'new_item'              => __( 'New Saved Cart', 'woosasc' ),
                'edit_item'             => __( 'Edit Saved Cart', 'woosasc' ),
                'view_item'             => __( 'View Saved Cart', 'woosasc' ),
                'all_items'             => __( 'All Saved Carts', 'woosasc' ),
                'search_items'          => __( 'Search Saved Carts', 'woosasc' ),
                'parent_item_colon'     => __( 'Parent Saved Carts:', 'woosasc' ),
                'not_found'             => __( 'No carts found.', 'woosasc' ),
                'not_found_in_trash'    => __( 'No carts found in Trash.', 'woosasc' ),
                'archives'              => _x( 'Saved Carts archives', 'woosasc' )
            );

            $args = array(
                        'labels'             => $labels,
                        'public'             => false,
                        'publicly_queryable' => true,
                        'show_ui'            => true,
                        'show_in_menu'       => true,
                        'query_var'          => true,
                        'rewrite'            => array( 'slug' => 'woosasc_cart' ),
                        'capability_type'    => 'post',
                        'has_archive'        => false,
                        'hierarchical'       => false,
                        'menu_position'      => null,
                        'supports'           => array( 'title', 'author', 'custom-fields' ),
                    );

            register_post_type( 'woosasc_cart', $args );
            flush_rewrite_rules();
        }
        

        function WOOSASC_options_page() {
                add_submenu_page( 'woocommerce', 'Save and Share Cart', 'Save and Share Cart', 'manage_options', 'woosasc-save-share-cart',array($this, 'WOOSASC_options_page_callback'));
        }

        function WOOSASC_options_page_callback() {
        ?>    
            <div class="wrap">
                
                <div class="wrap woocommerce">
                    <form method="post">
                          <?php 
                          wp_nonce_field( 'woosasc_nonce_action', 'woosasc_nonce_field' );
                          $woosasc_btnpos = get_option( 'woosasc_btnpos' );
                          ?>
                        <h3>Cart Share Settings</h3>
                        <table class="form-table">
                            <tbody>
                                <tr valign="top" class="woosasc_btnpos_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_btnpos">Share button position <span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-select">
                                        <select name="woosasc_btnpos" id="woosasc_btnpos" style="min-width: 350px;" class="" tabindex="-1" aria-hidden="true">
                                            <option value="sel_btn_post" <?php if($woosasc_btnpos == 'sel_btn_post') { echo 'selected'; } ?>>Select Button Position</option>
                                            <option value="before_cart_table" <?php if($woosasc_btnpos == 'before_cart_table') { echo 'selected'; } ?>>Before Cart Table</option>
                                            <option value="after_cart_table" <?php if($woosasc_btnpos == 'after_cart_table') { echo 'selected'; } ?>>After Cart Table</option>
                                            <option value="before_cart" <?php if($woosasc_btnpos == 'before_cart') { echo 'selected'; } ?>>Before Cart</option>
                                            <option value="after_cart" <?php if($woosasc_btnpos == 'after_cart') { echo 'selected'; } ?>>After Cart</option>
                                            <option value="beside_update_cart" <?php if($woosasc_btnpos == 'beside_update_cart') { echo 'selected'; } ?>>Beside Update Cart Button</option>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_scbtext_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_scbtext">Share cart button text<span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <input name="woosasc_scbtext" id="woosasc_scbtext" type="text" style="" class="" placeholder="Get Quote" value="<?php if(!empty(get_option( 'woosasc_scbtext' ))){ echo get_option( 'woosasc_scbtext' ); } else { echo 'Share cart'; } ?>">
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_scptitle_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_scptitle">Share cart page title<span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <input name="woosasc_scptitle" id="woosasc_scptitle" type="text" style="" class="" placeholder="Get Quote" value="<?php if(!empty(get_option( 'woosasc_scptitle' ))){ echo get_option( 'woosasc_scptitle' ); } else { echo 'Cart'; } ?>">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h3>Enable social media for sharing</h3>
                        <table class="form-table">
                            <tbody>
                                <tr valign="top" class="woosasc_sofb_field">
                                    <th scope="row" class="titledesc">Facebook</th>
                                    <td class="forminp forminp-checkbox">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span>Facebook</span></legend>
                                                <label for="woosasc_sofb">
                                                    <input name="woosasc_sofb" id="woosasc_sofb" type="checkbox" class="" value="1" <?php if(!empty(get_option( 'woosasc_sofb' )) && get_option( 'woosasc_sofb' ) == 1){ echo 'checked'; } ?>> Enable Facebook
                                                </label>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_sott_field">
                                    <th scope="row" class="titledesc">Twitter</th>
                                    <td class="forminp forminp-checkbox">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span>Twitter</span></legend>
                                                <label for="woosasc_sott">
                                                    <input name="woosasc_sott" id="woosasc_sott" type="checkbox" class="" value="1" <?php if(!empty(get_option( 'woosasc_sott' )) && get_option( 'woosasc_sott' ) == 1){ echo 'checked'; } ?>> Enable Twitter
                                                </label>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_sowa_field">
                                    <th scope="row" class="titledesc">Whatsapp</th>
                                    <td class="forminp forminp-checkbox">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span>Whatsapp</span></legend>
                                                <label for="woosasc_sowa">
                                                    <input name="woosasc_sowa" id="woosasc_sowa" type="checkbox" class="" value="1" <?php if(!empty(get_option( 'woosasc_sowa' )) && get_option( 'woosasc_sowa' ) == 1){ echo 'checked'; } ?>> Enable Whatsapp
                                                </label>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_soskp_field">
                                    <th scope="row" class="titledesc">Skype</th>
                                    <td class="forminp forminp-checkbox">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span>Skype</span></legend>
                                                <label for="woosasc_soskp">
                                                    <input name="woosasc_soskp" id="woosasc_soskp" type="checkbox" class="" value="1" <?php if(!empty(get_option( 'woosasc_soskp' )) && get_option( 'woosasc_soskp' ) == 1){ echo 'checked'; } ?>> Enable Skype
                                                </label>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_email_field">
                                    <th scope="row" class="titledesc">Email</th>
                                    <td class="forminp forminp-checkbox">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span>Email</span></legend>
                                                <label for="woosasc_email">
                                                    <input name="woosasc_email" id="woosasc_email" type="checkbox" class="" value="1" <?php if(!empty(get_option( 'woosasc_email' )) && get_option( 'woosasc_email' ) == 1){ echo 'checked'; } ?>> Enable Email
                                                </label>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_ctc_field">
                                    <th scope="row" class="titledesc">Copy to clipboard</th>
                                    <td class="forminp forminp-checkbox">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span>Copy to clipboard</span></legend>
                                                <label for="woosasc_ctc">
                                                    <input name="woosasc_ctc" id="woosasc_ctc" type="checkbox" class="" value="1" <?php if(!empty(get_option( 'woosasc_ctc' )) && get_option( 'woosasc_ctc' ) == 1){ echo 'checked'; } ?>> Enable Copy to clipboard
                                                </label>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_save_field">
                                    <th scope="row" class="titledesc">Save</th>
                                    <td class="forminp forminp-checkbox">
                                        <fieldset>
                                            <legend class="screen-reader-text"><span>Save</span></legend>
                                                <label for="woosasc_save">
                                                    <input name="woosasc_save" id="woosasc_save" type="checkbox" class="" value="1" <?php if(!empty(get_option( 'woosasc_save' )) && get_option( 'woosasc_save' ) == 1){ echo 'checked'; } ?>> Enable Save
                                                </label>
                                        </fieldset>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h3>Email Cart Settings</h3>
                        <table class="form-table">
                            <tbody>
                                <tr valign="top" class="woosasc_emailfaddress_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_emailfaddress">Email from address<span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-email">
                                        <input name="woosasc_emailfaddress" id="woosasc_emailfaddress" type="text" style="" class="" placeholder="" value="<?php if(!empty(get_option( 'woosasc_emailfaddress' ))){ echo get_option( 'woosasc_emailfaddress' ); } ?>">
                                        <p class="description">Enter address from which email will be sent</p>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_emailfname_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_emailfname">Email from name<span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <input name="woosasc_emailfname" id="woosasc_emailfname" type="text" style="" class="" placeholder="" value="<?php if(!empty(get_option( 'woosasc_emailfname' ))){ echo get_option( 'woosasc_emailfname' ); } ?>">
                                        <p class="description">Enter name from which email will be sent</p>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_emailsub_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_emailsub">Email subject<span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <input name="woosasc_emailsub" id="woosasc_emailsub" type="text" style="" class="" placeholder="" value="<?php if(!empty(get_option( 'woosasc_emailsub' ))){ echo get_option( 'woosasc_emailsub' ); } ?>">
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_emailbody_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_emailbody">Email Body<span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <textarea rows="9" cols="60" name="woosasc_emailbody" id="woosasc_emailbody"><?php if(!empty(get_option( 'woosasc_emailbody' ))){ echo get_option( 'woosasc_emailbody' ); } ?></textarea>
                                        <p class="description">Use placeholder {ct_link} for cart link, {wsc_blogname} for blogname and {wsc_siteurl} for website url.</p>
                                    </td>
                                </tr> 
                            </tbody>
                        </table>
                        <h3>Save Cart Settings</h3>
                        <table class="form-table">
                            <tbody>
                                <tr valign="top" class="woosasc_savedctitle_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_scbtext">Saved cart title<span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <input name="woosasc_savedctitle" id="woosasc_savedctitle" type="text" style="" class="" placeholder="" value="<?php if(!empty(get_option( 'woosasc_savedctitle' ))){ echo get_option( 'woosasc_savedctitle' ); } else { echo 'Saved carts'; } ?>">
                                        <p class="description">This would be visible in my account section.</p>
                                    </td>
                                </tr>
                                <tr valign="top" class="woosasc_savedclable_field">
                                    <th scope="row" class="titledesc">
                                        <label for="woosasc_savedclable">Enter name for saved cart label<span class="woocommerce-help-tip"></span></label>
                                    </th>
                                    <td class="forminp forminp-text">
                                        <input name="woosasc_savedclable" id="woosasc_savedclable" type="text" style="" class="" placeholder="" value="<?php if(!empty(get_option( 'woosasc_savedclable' ))){ echo get_option( 'woosasc_savedclable' ); } else { echo 'Enter name for saved cart'; } ?>">
                                        <p class="description">This would be visible while user would be saving cart on front-end.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="action" value="woosasc_save_option">
                            <input type="submit" value="Save Changes" name="submit" class="button-primary" id="woosasc-btn-space">
                    </form>
                </div>
            </div>
        <?php
        }
            
        function WOOSASC_save_options(){
            if( current_user_can('administrator') ) { 
                if(isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'woosasc_save_option'){
                    if(!isset( $_POST['woosasc_nonce_field'] ) || !wp_verify_nonce( $_POST['woosasc_nonce_field'], 'woosasc_nonce_action' ) ){
                        print 'Sorry, your nonce did not verify.';
                        exit;
                    } else {


                        if(isset($_REQUEST['woosasc_sofb']) && !empty($_REQUEST['woosasc_sofb'])) {
                            $woosasc_sofb = sanitize_text_field( $_REQUEST['woosasc_sofb'] );
                        } else {
                            $woosasc_sofb = '';
                        }

                        if(isset($_REQUEST['woosasc_sott']) && !empty($_REQUEST['woosasc_sott'])) {
                            $woosasc_sott = sanitize_text_field( $_REQUEST['woosasc_sott'] );
                        } else {
                            $woosasc_sott = '';
                        }

                        if(isset($_REQUEST['woosasc_sowa']) && !empty($_REQUEST['woosasc_sowa'])) {
                            $woosasc_sowa = sanitize_text_field( $_REQUEST['woosasc_sowa'] );
                        } else {
                            $woosasc_sowa = '';
                        }

                        if(isset($_REQUEST['woosasc_soskp']) && !empty($_REQUEST['woosasc_soskp'])) {
                            $woosasc_soskp = sanitize_text_field( $_REQUEST['woosasc_soskp'] );
                        } else {
                            $woosasc_soskp = '';
                        }

                        if(isset($_REQUEST['woosasc_email']) && !empty($_REQUEST['woosasc_email'])) {
                            $woosasc_email = sanitize_text_field( $_REQUEST['woosasc_email'] );
                        } else {
                            $woosasc_email = '';
                        }

                        if(isset($_REQUEST['woosasc_ctc']) && !empty($_REQUEST['woosasc_ctc'])) {
                            $woosasc_ctc = sanitize_text_field( $_REQUEST['woosasc_ctc'] );
                        } else {
                            $woosasc_ctc = '';
                        }

                        if(isset($_REQUEST['woosasc_save']) && !empty($_REQUEST['woosasc_save'])) {
                            $woosasc_save = sanitize_text_field( $_REQUEST['woosasc_save'] );
                        } else {
                            $woosasc_save = '';
                        }


                        update_option('woosasc_btnpos', sanitize_text_field( $_REQUEST['woosasc_btnpos'] ), 'yes');
                        update_option('woosasc_scbtext', sanitize_text_field( $_REQUEST['woosasc_scbtext'] ), 'yes');
                        update_option('woosasc_scptitle',  sanitize_text_field( $_REQUEST['woosasc_scptitle'] ), 'yes');
                        update_option('woosasc_sofb', $woosasc_sofb, 'yes');
                        update_option('woosasc_sott', $woosasc_sott, 'yes');
                        update_option('woosasc_sowa', $woosasc_sowa, 'yes');
                        update_option('woosasc_soskp', $woosasc_soskp, 'yes');
                        update_option('woosasc_email', $woosasc_email, 'yes');
                        update_option('woosasc_ctc', $woosasc_ctc, 'yes');
                        update_option('woosasc_save', $woosasc_save, 'yes');
                        update_option('woosasc_emailfaddress',sanitize_text_field( $_REQUEST['woosasc_emailfaddress']),'yes');
                        update_option('woosasc_emailfname',sanitize_text_field( $_REQUEST['woosasc_emailfname']),'yes');
                        update_option('woosasc_emailsub',sanitize_text_field( $_REQUEST['woosasc_emailsub']),'yes');
                        update_option('woosasc_emailbody', sanitize_textarea_field( $_REQUEST['woosasc_emailbody'] ));
                        update_option('woosasc_savedctitle',sanitize_text_field( $_REQUEST['woosasc_savedctitle']),'yes');
                        update_option('woosasc_savedclable',sanitize_text_field( $_REQUEST['woosasc_savedclable']),'yes');
                    }
                }
            }
        }

        function recursive_sanitize_text_field($array) {
            foreach ( $array as $key => &$value ) {
                if ( is_array( $value ) ) {
                    $value = $this->recursive_sanitize_text_field($value);
                }else{
                    $value = sanitize_text_field( $value );
                }
            }
            return $array;
        }

        function init() {
            add_action( 'init', array($this, 'WOOSASC_create_posttype'));
            add_action( 'admin_menu',  array($this, 'WOOSASC_options_page'));
            add_action( 'init',  array($this, 'WOOSASC_save_options'));
        }

        public static function WOOSASC_instance() {
            if (!isset(self::$WOOSASC_instance)) {
                self::$WOOSASC_instance = new self();
                self::$WOOSASC_instance->init();
            }
            return self::$WOOSASC_instance;
        }
    }
    WOOSASC_settings::WOOSASC_instance();
}


