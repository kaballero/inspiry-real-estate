<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://themeforest.net/user/InspiryThemes
 * @since      1.0.0
 *
 * @package    Inspiry_Real_Estate
 * @subpackage Inspiry_Real_Estate/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Inspiry_Real_Estate
 * @subpackage Inspiry_Real_Estate/includes
 * @author     M Saqib Sarwar <saqib@inspirythemes.com>
 */
class Inspiry_Real_Estate {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Inspiry_Real_Estate_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

    /**
     * Contains plugin options value
     *
     * @var mixed|void $plugin_options  Contains plugin options value.
     */
    protected $plugin_options;

    /**
     * Instance variable for singleton pattern
     *
     * @var object class instance
     */
    private static $instance = null;

    /**
     * Return class instance
     *
     * @return Inspiry_Real_Estate|null
     */
    public static function get_instance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	private function __construct() {

		$this->plugin_name = 'inspiry-real-estate';
		$this->version = '1.0.0';
        $this->plugin_options = get_option( 'inspiry_price_format_option' );

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Inspiry_Real_Estate_Loader. Orchestrates the hooks of the plugin.
	 * - Inspiry_Real_Estate_i18n. Defines internationalization functionality.
	 * - Inspiry_Real_Estate_Admin. Defines all hooks for the admin area.
	 * - Inspiry_Real_Estate_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-inspiry-real-estate-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-inspiry-real-estate-i18n.php';

        /**
         * The class responsible for defining property functionality
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-inspiry-property.php';

        /**
         * The class responsible for defining agent functionality
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-inspiry-agent.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-inspiry-real-estate-admin.php';

        /**
         * The class responsible for providing property custom post type and related stuff.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-inspiry-property-post-type.php';

        /**
         * The class responsible for providing agent custom post type and related stuff.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-inspiry-agent-post-type.php';

        /**
         * The class responsible for providing partners custom post type and related stuff.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-inspiry-partner-post-type.php';

        /**
         * The class responsible for providing additional details meta box
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-inspiry-additional-details-meta-box.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-inspiry-real-estate-public.php';

		$this->loader = new Inspiry_Real_Estate_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Inspiry_Real_Estate_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Inspiry_Real_Estate_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Inspiry_Real_Estate_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_real_estate_settings' );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'initialize_real_estate_options' );
        $this->loader->add_filter( 'plugin_action_links_' . INSPIRY_REAL_ESTATE_PLUGIN_BASENAME, $plugin_admin, 'inspiry_real_estate_action_links' );

        // Property Post Type
        $property_post_type = new Inspiry_Property_Post_Type();
        $this->loader->add_action( 'init', $property_post_type, 'register_property_post_type' );
        $this->loader->add_action( 'init', $property_post_type, 'register_property_type_taxonomy' );
        $this->loader->add_action( 'init', $property_post_type, 'register_property_status_taxonomy' );
        $this->loader->add_action( 'init', $property_post_type, 'register_property_city_taxonomy' );
        $this->loader->add_action( 'init', $property_post_type, 'register_property_feature_taxonomy' );
        $this->loader->add_filter( 'rwmb_meta_boxes', $property_post_type, 'register_meta_boxes' );
        $this->loader->add_filter( 'posts_join', $property_post_type, 'join_post_meta_table' );
        $this->loader->add_filter( 'posts_where', $property_post_type, 'add_property_id_in_search' );
        $this->loader->add_filter( 'posts_groupby', $property_post_type, 'group_by_properties' );

        // Agent Post Type
        $agent_post_type = new Inspiry_Agent_Post_Type();
        $this->loader->add_action( 'init', $agent_post_type, 'register_agent_post_type' );
        $this->loader->add_filter( 'rwmb_meta_boxes', $agent_post_type, 'register_meta_boxes' );


        // Partner Post Type
        $partner_post_type = new Inspiry_Partner_Post_Type();
        $this->loader->add_action( 'init', $partner_post_type, 'register_partner_post_type' );
        $this->loader->add_filter( 'rwmb_meta_boxes', $partner_post_type, 'register_meta_boxes' );

        if ( is_admin() ) {
            global $pagenow;

            // property custom columns
            if ( $pagenow == 'edit.php' && isset( $_GET['post_type'] ) && esc_attr( $_GET['post_type'] ) == 'property' ) {
                $this->loader->add_filter( 'manage_edit-property_columns', $property_post_type, 'register_custom_column_titles' );
                $this->loader->add_action( 'manage_pages_custom_column', $property_post_type, 'display_custom_column' );
            }

            // agent custom columns
            if ( $pagenow == 'edit.php' && isset( $_GET['post_type'] ) && esc_attr( $_GET['post_type'] ) == 'agent' ) {
                $this->loader->add_filter( 'manage_edit-agent_columns', $agent_post_type, 'register_custom_column_titles' );
                $this->loader->add_action( 'manage_posts_custom_column', $agent_post_type, 'display_custom_column' );
            }

            // partner custom columns
            if ( $pagenow == 'edit.php' && isset( $_GET['post_type'] ) && esc_attr( $_GET['post_type'] ) == 'partners' ) {
                $this->loader->add_filter( 'manage_edit-partners_columns', $partner_post_type, 'register_custom_column_titles' );
                $this->loader->add_action( 'manage_posts_custom_column', $partner_post_type, 'display_custom_column' );
            }
        }

        // Additional details meta box
        $additional_details_meta_box = Additional_Details_Meta_Box::get_instance();
        $this->loader->add_action( 'add_meta_boxes', $additional_details_meta_box, 'add_additional_details_meta_box' );
        $this->loader->add_action( 'save_post', $additional_details_meta_box, 'save_additional_details' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Inspiry_Real_Estate_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Inspiry_Real_Estate_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

    /**
     * To log any thing for debugging purposes
     *
     * @since   1.0.0
     *
     * @param   mixed   $message    message to be logged
     */
    public static function log( $message ) {
        if( WP_DEBUG === true ){
            if( is_array( $message ) || is_object( $message ) ){
                error_log( print_r( $message, true ) );
            } else {
                error_log( $message );
            }
        }
    }

    public function get_currency_sign() {
        $this->refresh();
        if( isset( $this->plugin_options[ 'currency_sign' ] ) ) {
            return $this->plugin_options[ 'currency_sign' ];
        }
        return '$';
    }

    public function get_currency_position() {
        if( isset( $this->plugin_options[ 'currency_position' ] ) ) {
            return $this->plugin_options[ 'currency_position' ];
        }
        return 'before';
    }

    public function get_thousand_separator() {
        if( isset( $this->plugin_options[ 'thousand_separator' ] ) ) {
            return $this->plugin_options[ 'thousand_separator' ];
        }
        return ',';
    }

    public function get_decimal_separator() {
        if( isset( $this->plugin_options[ 'decimal_separator' ] ) ) {
            return $this->plugin_options[ 'decimal_separator' ];
        }
        return '.';
    }

    public function get_number_of_decimals() {
        if( isset( $this->plugin_options[ 'number_of_decimals' ] ) ) {
            return intval( $this->plugin_options[ 'number_of_decimals' ] );
        }
        return 2;
    }

    public function get_empty_price_text() {
        $this->refresh();
        if( isset( $this->plugin_options[ 'empty_price_text' ] ) ) {
            return $this->plugin_options[ 'empty_price_text' ];
        }
        return null;
    }

    private function refresh(){
        if ( function_exists( 'icl_object_id' ) ) {
            // re-read only for wpml
            $this->plugin_options = get_option( 'inspiry_price_format_option' );
        }
    }

}
