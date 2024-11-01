jQuery(document).ready(function($){
	var option = $("#customizeSetting").val();
	changeCustomizeStatus(option);
	$('#customizeSetting').on('change',function(){
		var option = $(this).val();
		changeCustomizeStatus(option);
	});

	function changeCustomizeStatus(option){
		var rac = $('#rowAlternateColor');
		var cac = $('#columnAlternateColor');
		var frfc = $('#fcfr');
		switch(option) {
		case '1':
			rac.show();
			cac.hide();
			frfc.hide();
			break;
		case '2':
			rac.hide();
			cac.show();
			frfc.hide();
			break;
		case '3':
			rac.hide();
			cac.hide();
			frfc.show();
			break;
		default:
			rac.show();
			cac.hide();
			frfc.hide();
			break;
		}
	}

	$('#sswidgettournament').on('change',function(){

		var leagueID = $(this).val();
		if(leagueID){
			$.ajax({
				type:'POST',
				url:ajaxurl,
				data:{action : "ce_ssw_fetchGroup" , leagueID:leagueID},
				success:function(html){
					$('#sswidgetgroup').html(html);
					processChange();
					$("#sswidgetgroup").val($("#sswidgetgroup option:first").val());
				},

			}); 
		}else{
			$('#sswidgetgroup').html('<option value="">Select Group</option>');
		}
	});

	$('#sswidget-generator select').on('change',function(){
		processChange();
	});

	function processChange(){
		var Language = $('#sswidgetlanguage').val();
		var DataType = $('#sswidgetdatatype').val();
		var Tournment = $('#sswidgettournament').val();
		var Group = $('#sswidgetgroup').val();

		if((DataType ==1) || (DataType ==2) || (DataType ==3)){
			$(".isLeagueN").hide();
		}else{
			$(".isLeagueN").show();
		}

		if((DataType == 0) || (Language  == 0) || (Tournment == 0)){
			$('#ShortcodePrev').html('Please Select The Required Fields');
			return;
		}else{
			if((Group == '') || (Group == null) || (Group == 0)){
				grp ='';
			}else{
				var grp = ' group='+Group;
			}

			if ($('#sswidgetgroup option').length == 0) {
				$('#sswidgetgroup').hide();
				$('#sswidgetgroup').val('');
			}else{
				$('#sswidgetgroup').show();
			}

			$('#ShortcodePrev').html('[soccerstats lang='+Language+' type='+DataType+' ranking='+Tournment+''+grp+']');
			processPreview(Language,DataType,Tournment,Group);
		}
	}
	function processPreview(Language,DataType,Tournment,Group){
		$.ajax({
			type:'POST',
			url:ajaxurl,
			data:{action : "ce_ssw_processPreview", Language:Language, DataType:DataType,Tournment:Tournment,Group:Group},
			success:function(html){
                	//html = html.replace('/"/','"');
				html = html.replace(new RegExp('/"/', 'g'), '"');
				$('#sswidgetPreviewDemo').html(html);
			},

		});
	}
});


