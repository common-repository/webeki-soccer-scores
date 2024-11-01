<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
class codended_sswidget_shortcode 
{
	public static function soccerstats_shortcode( $atts ) {

		$atts = shortcode_atts(
			array(
				'ranking' => '',
				'lang' => '',
				'type' => '',
				'group' => '',
			),
			$atts
		);

		switch ($atts['type']) {
			case '1':
				$url = 'https://www.soccerstats247.com/RankingsRssWidget.aspx?langId='.esc_html($atts['lang']).'&leagueId='.esc_html($atts['ranking']).'&groupName='.esc_html($atts['group']);
			break;
			case '2':
				$url= 'https://www.soccerstats247.com/RankingsSimplifiedRssWidget.aspx?langId='.esc_html($atts['lang']).'&leagueId='.esc_html($atts['ranking']).'&groupName='.esc_html($atts['group']);
			break;
			case '3':
				$url = 'https://www.soccerstats247.com/RankingswFormRssWidget.aspx?langId='.esc_html($atts['lang']).'&leagueId='.esc_html($atts['ranking']).'&groupName='.esc_html($atts['group']);
			break;
			case '4':
				$url = 'https://www.soccerstats247.com/MatchResultsRssWidget.aspx?langId='.esc_html($atts['lang']).'&leagueId='.esc_html($atts['ranking']);
			break;

			default:
				$url= 0;
			break;
		}

		if($url != 0 ){ ?>
			<style type="text/css">
				<?php if(get_option('customizeSetting')==1){ ?>
					#sswidgetPreview tr:nth-child(odd){background-color:<?= esc_attr(get_option('raodd')); ?>;}
					#sswidgetPreview tr:nth-child(even){background-color:<?= esc_attr(get_option('raeven')); ?>;}
				<?php }?>

				<?php if(get_option('customizeSetting')==2){ ?>
					#sswidgetPreview td:nth-child(odd){background-color:<?= esc_attr(get_option('caodd')); ?>;}
					#sswidgetPreview td:nth-child(even){background-color:<?= esc_attr(get_option('caeven')); ?>;}
				<?php }?>

				<?php if(get_option('customizeSetting')==3){ ?>
					#sswidgetPreview td:nth-child(1){background-color:<?= esc_attr(get_option('fcfrcolumn')); ?>;}
					#sswidgetPreview th { background-color: <?= esc_attr(get_option('fcfrrow')); ?>;} 
				<?php }?>
			</style>
			<div><?php 
			$html = '<div id="sswidgetPreview">'; 
			$xml = simplexml_load_file($url);

			foreach($xml->channel->item as $item){
				$html .= $item->description;$html .= "<hr />";
			} 
			return  $html.'</div>'; ?>
		</div>
	<?php }
	else{
		return 'No Preview Availble';
	}
}
}
