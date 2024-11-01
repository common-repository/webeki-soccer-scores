<?php
/*
Plugin Name: WidgetLab Soccer Widgets: Football Results & Rankings
Plugin URI: https://www.widgetlab.net/wordpress-plugins/
Description: Soccer Widgets plugin allows Wordpress users to quickly implement soccer data like various table rankings and match results by competition into their WP posts and pages by using simple shortcodes.
Version: 1.3
Author: WidgetLab.net
Author URI: www.widgetlab.net
*/
if ( ! defined( 'ABSPATH' ) ) exit;
class Codended_sswidget
{
	function install()
	{
		$this->setupTables();
		$this->importCSVLeague();
	}
	function deactivate()
	{
		global $wpdb;
		$table_name = $wpdb->prefix . 'ce_sswidget_leagues';
    	$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
	}

	private static function importCSVLeague(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'ce_sswidget_leagues';
		$file_path = plugin_dir_path( __FILE__ ).'Leagues.csv';
		$handle = fopen($file_path, 'r');
		$data = fgetcsv($handle, 1000, ',');
		while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {		
			$inserted = $wpdb->insert($table_name, array(
   		 	'country' => (isset($data[0]) ? $data[0] : ''),
   		 	'LeagueName' => (isset($data[1]) ? $data[1] : ''),
  		 	'LeagueId' => (isset($data[2]) ? $data[2] : ''),
  		 	'isLeague' => (isset($data[3]) ? $data[3] : ''),
  		 	'groupNameUrl' => (isset($data[4]) ? $data[4] : '')
		));
		}
	}

	private function setupTables(){
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'ce_sswidget_leagues';
		if($wpdb->get_var("show tables like '$table_name'") != $table_name) 
		{
			$sql = "CREATE TABLE `$table_name` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`country` varchar(60) NOT NULL,
				`LeagueName` varchar(60) NOT NULL,
				`LeagueId` varchar(20) NOT NULL,
				`isLeague` varchar(200) NOT NULL,
				`groupNameUrl` varchar(200) NOT NULL,
				primary key (id)
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
	}

	public static function onPluginReady(){
		//do_action('temp_warning',  array('Codended_sswidget_cronjob','temp_warning' ));
	}

	public function init(){
		$this->load_dependency();
		$this->load_actions();	
		$this->load_shortcodes();	
	}
	private function load_shortcodes(){
		add_shortcode( 'soccerstats', array('codended_sswidget_shortcode','soccerstats_shortcode'));
	}

	private function load_actions(){
		add_action( 'admin_menu', array($this,'codended_sswidget_add_admin_menu' ));
		add_action( 'admin_enqueue_scripts', array($this,'admin_enqueue_scripts') );
		add_action( 'admin_enqueue_scripts', array($this,'admin_enqueue_styles') );

		add_action( 'wp_enqueue_scripts', array($this,'frontend_enqueue_script') );

		add_action( 'admin_init', array($this,'register_settings') );
		add_action( 'wp_ajax_ce_ssw_fetchGroup', array($this,'my_ajax_fetchGroup_handler') );
		add_action( 'wp_ajax_ce_ssw_processPreview', array($this,'my_ajax_processPreview_handler') );
	}
	public function frontend_enqueue_script(){
		wp_enqueue_style('ce_ss_widget_css_front', plugins_url('frontend/css/style.css',__FILE__ ));
	}
	public static function register_settings (){
		register_setting( 'ssw-ce-customizesetting', 'raeven' );
		register_setting( 'ssw-ce-customizesetting', 'raodd' );
		register_setting( 'ssw-ce-customizesetting', 'caeven' );
		register_setting( 'ssw-ce-customizesetting', 'caodd' );
		register_setting( 'ssw-ce-customizesetting', 'fcfrcolumn' );
		register_setting( 'ssw-ce-customizesetting', 'fcfrrow' );
		register_setting( 'ssw-ce-customizesetting', 'customizeSetting' );
	}
	public static function my_ajax_processPreview_handler(){
		$lang = sanitize_text_field((isset($_POST['Language']) && is_string($_POST['Language']) ? $_POST['Language'] : ''));
		$datatype = sanitize_text_field((isset($_POST['DataType']) && is_numeric($_POST['DataType']) ? $_POST['DataType'] : ''));
		$tournment = sanitize_text_field((isset($_POST['Tournment']) && is_string($_POST['Tournment']) ? $_POST['Tournment'] : ''));
		$group = (empty($_POST['Group'])) ? ('') : ('group='.(sanitize_text_field($_POST['Group'])));

		echo do_shortcode('[soccerstats type='.$datatype.' lang='.$lang.' ranking='.$tournment.' '.$group.']');

		wp_die();
	}

	public static function my_ajax_fetchGroup_handler(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'ce_sswidget_leagues';
		$LeagueId = sanitize_text_field((isset($_POST['leagueID']) && is_numeric($_POST['leagueID']) ? $_POST['leagueID'] : ''));
		$groups = $wpdb->get_results ( "SELECT * FROM $table_name WHERE LeagueId = $LeagueId");
		$count = 0;
		foreach ($groups as $group) {
			if(empty($group->groupNameUrl)){
				continue;
			}
			echo '<option>'.esc_html($group->groupNameUrl).'</option>';
		}
		wp_die();
	}

	public static function admin_enqueue_scripts($hook){
		wp_enqueue_script( 'ce_ss_widget_js', plugin_dir_url( __FILE__ ) . 'admin/js/script.js', array(), '1.0' );
	}
	
	public static function admin_enqueue_styles($hook){
		wp_enqueue_style('ce_ss_widget_css', plugins_url('admin/css/style.css',__FILE__ ));
	}
	
	private function load_dependency(){
		require_once('admin/settings.php');
		require_once('admin/customization.php');
		require_once('shortcode/main.php');
	}

	public static function codended_sswidget_add_admin_menu(  ) { 
	add_menu_page( 'Soccer Scores', 'Soccer Widgets', 'manage_options', 'soccer-scores-widget', 'codended_sswidget_options_page' , plugins_url( 'images/icon.png' , __FILE__ ) );
	add_submenu_page('soccer-scores-widget', 'Customization', 'Customization', 'manage_options', 'ss-widget-customize','codended_sswidget_customization_page' );

}
}
$Codended_sswidget = new Codended_sswidget();
register_activation_hook( __FILE__, array( $Codended_sswidget, 'install' ) );
register_deactivation_hook( __FILE__, array( $Codended_sswidget, 'deactivate' ) );
$Codended_sswidget->init();