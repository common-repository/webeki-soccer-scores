<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function codended_sswidget_options_page(  ) { 
	global $wpdb;
	$table_name = $wpdb->prefix . 'ce_sswidget_leagues';
	$leagues = $wpdb->get_results ( "SELECT DISTINCT LeagueName , LeagueId,country,isLeague FROM $table_name");
	?>
	<form method='post' id="sswidget-generator">

		<h2>Generate Soccer Widget Shortcode</h2>

		<select name="sswidget_language" id="sswidgetlanguage">
			<option value="0">Select Language</option>
			<option value="1">English</option>
			<option value="2">Romanian</option>
			<option value="3">Spanish</option>
			<option value="4">German</option>
			<option value="5">French</option>
			<option value="6">Dutch</option>
			<option value="7">Italian</option>
			<option value="8">Swedish</option>
			<option value="9">Norwegian</option>
			<option value="10">Danish</option>
			<option value="11">Finnish</option>
			<option value="12">Portuguese</option>
			<option value="13">Polish</option>
			<option value="14">Hungarian</option>
			<option value="15">Czech</option>
			<option value="16">Greek</option>
		</select>

		<select name="sswidget_data_type" id="sswidgetdatatype">
			<option value="0">Select Data Type</option>
			<option value="1">Rankings</option>
			<option value="2">Rankings Simplified</option>
			<option value="3">Rankings with Team Form</option>
			<option value="4">Matches & Results</option>
		</select>

		<select name="sswidget_tournament" id="sswidgettournament">
			<option value="0">Select Tournament</option>
			<?php
				if (isset($leagues)) {
					foreach($leagues as $league){
						echo '<option class="isLeague'.esc_html($league->isLeague).'" value="'.esc_html($league->LeagueId).'">'.esc_html($league->country).' , '.esc_html($league->LeagueName).'</option>';
					}
				}
			?>
		</select>	
		<select name="sswidget_group" id="sswidgetgroup">
			<option value="0">Select Group</option>
		</select>

		<h2>Use Shortcode</h2>
		<code id="ShortcodePrev">Please Select The Required Fields</code>
		<h2>Preview</h2>
		<div id="sswidgetPreviewDemo"></div>
		<p><strong>Advice:</strong> We do not recommend the implementation of multiple such snippets in a single article as
		it may slow down the load of your page given there will be more data to be transmitted.</p>
		<p><i>Note: Data provided by SoccerStats247.com. More widget possibilities like team stats, squad, results
		or match probabilities can be generated on the official website in the Widgets Page.</i></p>
		
	</form>
	<?php

}
?>