<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function codended_sswidget_customization_page(  ) { 
	global $wpdb;
	$table_name = $wpdb->prefix . 'ce_sswidget_leagues';
	$leagues = $wpdb->get_results ( "SELECT DISTINCT LeagueName , LeagueId FROM $table_name");
	?>
	<form method='post' id="sswidget-customizer" action="options.php">
		<?php wp_nonce_field('sswidget-customizeoptions'); ?>
		<?php settings_fields( 'ssw-ce-customizesetting' ); ?>
		<h2>Customization Settings for Soccer Widgets</h2>
		
		<select name="customizeSetting" id="customizeSetting">

			<option <?= (get_option('customizeSetting')==1)?('selected'):(''); ?> value="1">Row Alternate Colors</option>
			<option <?= (get_option('customizeSetting')==2)?('selected'):(''); ?> value="2">Columns Alternate Colors</option>
			<option <?= (get_option('customizeSetting')==3)?('selected'):(''); ?> value="3">First Row/Column Colors</option>
		</select>
		<div id="rowAlternateColor">
			<br>
			<label>Even Row
				<input value="<?= esc_attr(get_option('raeven')); ?>" type="color" name="raeven">
			</label><br><br>
			<label>Odd Row
				<input value="<?= esc_attr(get_option('raodd')); ?>" type="color" name="raodd">
			</label>
		</div>
		<div id="columnAlternateColor">
			<br>
			<label>Even Row
				<input value="<?= esc_attr(get_option('caeven')); ?>" type="color" name="caeven">
			</label><br><br>
			<label>Odd Row
				<input value="<?= esc_attr(get_option('caodd')); ?>" type="color" name="caodd">
			</label>
		</div>
		<div id="fcfr">
			<br>
			<label>First Column
				<input value="<?= esc_attr(get_option('fcfrcolumn')); ?>" type="color" name="fcfrcolumn">
			</label><br><br>
			<label>First Row&nbsp; &nbsp; &nbsp;
				<input value="<?= esc_attr(get_option('fcfrrow')); ?>" type="color" name="fcfrrow">
			</label><br><br>

		</div><br><br>
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		<h2>Preview (hit Save above for preview load)</h2>
		<style type="text/css">
			<?php if(esc_attr(get_option('customizeSetting'))==1){ ?>
				#sswidgetPreview tr:nth-child(odd){background-color:<?= esc_attr(get_option('raodd')); ?>;}
				#sswidgetPreview tr:nth-child(even){background-color:<?= esc_attr(get_option('raeven')); ?>;}
			<?php }?>

			<?php if(esc_attr(get_option('customizeSetting'))==2){ ?>
				#sswidgetPreview td:nth-child(odd){background-color:<?= esc_attr(get_option('caodd')); ?>;}
				#sswidgetPreview td:nth-child(even){background-color:<?= esc_attr(get_option('caeven')); ?>;}
			<?php }?>

			<?php if(esc_attr(get_option('customizeSetting'))==3){ ?>
				#sswidgetPreview td:nth-child(1){background-color:<?= esc_attr(get_option('fcfrcolumn')); ?>;}
				#sswidgetPreview th { background-color: <?= esc_attr(get_option('fcfrrow')); ?>;} 
			<?php }?>
		</style>
		<div id="sswidgetPreview">
			<div><table border="1" width="100%"><tbody><tr><th colspan="2"></th><th>P</th><th>W</th><th>D</th><th>L</th><th>GF</th><th>GA</th><th>Dif</th><th>Pts</th></tr><tr><td width="7%">1</td><td width="27%"><a target="_blank" href="http://www.soccerstats247.com/teams/albania/skenderbeu-korce/"></a>Skënderbeu Korçë</td><td width="7%"><center>2</center></td><td width="7%"><center>2</center></td><td width="7%"><center>0</center></td><td width="7%"><center>0</center></td><td width="7%"><center>4</center></td><td width="7%"><center>0</center></td><td width="7%"><center>+4</center></td><td width="7%"><center>6</center></td></tr><tr><td width="7%">2</td><td width="27%"><a target="_blank" href="http://www.soccerstats247.com/teams/albania/laci/"></a>Laçi</td><td width="7%"><center>2</center></td><td width="7%"><center>1</center></td><td width="7%"><center>1</center></td><td width="7%"><center>0</center></td><td width="7%"><center>3</center></td><td width="7%"><center>2</center></td><td width="7%"><center>+1</center></td><td width="7%"><center>4</center></td></tr><tr><td width="7%">3</td><td width="27%"><a target="_blank" href="http://www.soccerstats247.com/teams/albania/flamurtari/"></a>Flamurtari</td><td width="7%"><center>2</center></td><td width="7%"><center>1</center></td><td width="7%"><center>1</center></td><td width="7%"><center>0</center></td><td width="7%"><center>1</center></td><td width="7%"><center>0</center></td><td width="7%"><center>+1</center></td><td width="7%"><center>4</center></td></tr><tr><td width="7%">4</td><td width="27%"><a target="_blank" href="http://www.soccerstats247.com/teams/albania/partizani-tirana/"></a>Partizani Tirana</td><td width="7%"><center>2</center></td><td width="7%"><center>1</center></td><td width="7%"><center>0</center></td><td width="7%"><center>1</center></td><td width="7%"><center>1</center></td><td width="7%"><center>1</center></td><td width="7%"><center>+0</center></td><td width="7%"><center>3</center></td></tr><tr><td width="7%">5</td><td width="27%"><a target="_blank" href="http://www.soccerstats247.com/teams/albania/kamza/"></a>Kamza</td><td width="7%"><center>2</center></td><td width="7%"><center>1</center></td><td width="7%"><center>0</center></td><td width="7%"><center>1</center></td><td width="7%"><center>1</center></td><td width="7%"><center>1</center></td><td width="7%"><center>+0</center></td><td width="7%"><center>3</center></td></tr><tr><td width="7%">6</td><td width="27%"><a target="_blank" href="http://www.soccerstats247.com/teams/albania/kastrioti-kruje/"></a>Kastrioti Krujë</td><td width="7%"><center>2</center></td><td width="7%"><center>1</center></td><td width="7%"><center>0</center></td><td width="7%"><center>1</center></td><td width="7%"><center>1</center></td><td width="7%"><center>3</center></td><td width="7%"><center>-2</center></td><td width="7%"><center>3</center></td></tr><tr><td width="7%">7</td><td width="27%"><a target="_blank" href="http://www.soccerstats247.com/teams/albania/teuta-durres/"></a>Teuta Durrës</td><td width="7%"><center>2</center></td><td width="7%"><center>0</center></td><td width="7%"><center>2</center></td><td width="7%"><center>0</center></td><td width="7%"><center>0</center></td><td width="7%"><center>0</center></td><td width="7%"><center>+0</center></td><td width="7%"><center>2</center></td></tr><tr><td width="7%">8</td><td width="27%"><a target="_blank" href="http://www.soccerstats247.com/teams/albania/kukesi/"></a>Kukësi</td><td width="7%"><center>2</center></td><td width="7%"><center>0</center></td><td width="7%"><center>1</center></td><td width="7%"><center>1</center></td><td width="7%"><center>1</center></td><td width="7%"><center>2</center></td><td width="7%"><center>-1</center></td><td width="7%"><center>1</center></td></tr><tr><td width="7%">9</td><td width="27%"><a target="_blank" href="http://www.soccerstats247.com/teams/albania/tirana/"></a>Tirana</td><td width="7%"><center>2</center></td><td width="7%"><center>0</center></td><td width="7%"><center>1</center></td><td width="7%"><center>1</center></td><td width="7%"><center>0</center></td><td width="7%"><center>1</center></td><td width="7%"><center>-1</center></td><td width="7%"><center>1</center></td></tr><tr><td width="7%">10</td><td width="27%"><a target="_blank" href="http://www.soccerstats247.com/teams/albania/luftetari-gjirokaster/"></a>Luftëtari Gjirokastër</td><td width="7%"><center>2</center></td><td width="7%"><center>0</center></td><td width="7%"><center>0</center></td><td width="7%"><center>2</center></td><td width="7%"><center>1</center></td><td width="7%"><center>3</center></td><td width="7%"><center>-2</center></td><td width="7%"><center>0</center></td></tr></tbody></table><br><hr></div></div>
			<p><strong>Advice:</strong> We do not recommend the implementation of multiple such snippets in a single article as
			it may slow down the load of your page given there will be more data to be transmitted.</p>
			<p><i>Note: Data provided by SoccerStats247.com. More widget possibilities like team stats, squad, results
			or match probabilities can be generated on the official website in the Widgets Page.</i></p>

		</form>
		<?php

	}

?>