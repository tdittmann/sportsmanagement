jQuery(document).ready(function()  {

// neuen wechsel speichern     
//jQuery("#save-new-subst").addEvent('click', save_new_subst);
//document.getElementById('save-new-subst').onclick = save_new_subst();
//jQuery("#ajaxresponse").html('test');
//alert('hallo');
});

// hier sind die funktionen
function save_new_subst(matchid,teamid,projecttime,baseajaxurl)
{
//jQuery("#ajaxresponse").html(matchid);
//jQuery("#ajaxresponse").html('hallo');
//alert(baseajaxurl);

var playerin = jQuery("#in").val();
				var playerout = jQuery("#out").val();
				var position = jQuery("#project_position_id").val();
				var time = jQuery("#in_out_time").val();
				var querystring = '&in=' + playerin + '&out=' + playerout
						+ '&project_position_id=' + position + '&in_out_time='
						+ time + '&teamid=' + teamid + '&matchid=' + matchid
						+  '&projecttime=' + projecttime;
				var url = baseajaxurl + '&task=matches.savesubst&tmpl=component';
jQuery("#ajaxresponse").html(url + querystring);

jQuery.ajax({
  type: 'POST', // type of request either Get or Post
  url: url + querystring, // Url of the page where to post data and receive response 
  //data: data, // data to be post
  dataType:"json",
  success: substsaved //function to be called on successful reply from server
  
}); 


}

function reqsent() 
{
	jQuery("#ajaxresponse").addClass('ajax-loading');
  
	jQuery("#ajaxresponse").text('anfrage gesendet');
}

function reqfailed() 
{
	jQuery("#ajaxresponse").removeClass('ajax-loading');
	jQuery("#ajaxresponse").text(response);
}

function substsaved(response) 
{
	jQuery("#ajaxresponse").removeClass('ajax-loading');
	// first line contains the status, second line contains the new row.
	var resp = response.split('&');
	
	//alert(resp[0]);
	//alert(resp[1]);
	
	if (resp[0] != '0') 
  {
               		
    jQuery("#table-substitutions").last().append('<tr id="sub-' 
    + resp[0] + '"><td>'
    + jQuery("#out option:selected").text() + '</td><td>'  
    + jQuery("#in option:selected").text() + '</td><td>' 
    + jQuery("#project_position_id option:selected").text() + '</td><td>' 
    + jQuery("#in_out_time").val() + '</td><td><input	id="deletesubst-' + resp[0] 
    + '" type="button" class="inputbox button-delete-subst" value="' 
    + str_delete + '"</td></tr>');
		
    jQuery("#ajaxresponse").addClass("ajaxsuccess");
		jQuery("#ajaxresponse").text(resp[1]);
$$(".button-delete-subst").addEvent('click', button_delete_subst);				
	}
   else 
   {
  jQuery("#ajaxresponse").addClass("ajaxerror");
	jQuery("#ajaxresponse").text(resp[1]);
	}
}


