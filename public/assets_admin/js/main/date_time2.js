$(".slider-range").slider({
range: true,
min: 360,
max: 1080,
step: 15,
values: [360, 360],
slide: function (e, ui) {
	//console.log(ui);
	var hours1 = Math.floor(ui.values[0] / 60);
	var minutes1 = ui.values[0] - (hours1 * 60);

	if (hours1.length == 1) hours1 = '0' + hours1;
	if (minutes1.length == 1) minutes1 = '0' + minutes1;
	if (minutes1 == 0) minutes1 = '00';
	if (hours1 >= 12) {
		if (hours1 == 12) {
			hours1 = hours1;
			minutes1 = minutes1 + " PM $$$";
		} else {
			hours1 = hours1 - 12;
			minutes1 = minutes1 + " PM $$$";
		}
	} else {
		hours1 = hours1;
		minutes1 = minutes1 + " AM";
	}
	if (hours1 == 0) {
		hours1 = 12;
		minutes1 = minutes1;
	}


		$("#start_"+e.target.id).html(hours1 + ':' + minutes1);
		

		var hours2 = Math.floor(ui.values[1] / 60);
		var minutes2 = ui.values[1] - (hours2 * 60);

		if (hours2.length == 1) hours2 = '0' + hours2;
		if (minutes2.length == 1) minutes2 = '0' + minutes2;
		if (minutes2 == 0) minutes2 = '00';
		if (hours2 >= 12) {
			if (hours2 == 12) {
				hours2 = hours2;
				minutes2 = minutes2 + " PM";
			} else if (hours2 == 24) {
				hours2 = 11;
				minutes2 = "59 PM";
			} else {
				hours2 = hours2 - 12;
				minutes2 = minutes2 + " PM";
			}
		} else {
			hours2 = hours2;
			minutes2 = minutes2 + " AM";
		}

		$("#end_"+e.target.id).html(hours2 + ':' + minutes2 + ' <font color="red">$$$$</font>');
		
		limit = ui.values[1] - ui.values[0];
		
		if(limit >= 60)
		{
			$("#end_"+e.target.id).html(hours2 + ':' + minutes2 + ' <font color="red">$$$</font>');
		}
		if(limit >= 120)
		{
			$("#end_"+e.target.id).html(hours2 + ':' + minutes2 + ' <font color="red">$$</font>');
		}
		if(limit >= 180)
		{
			$("#end_"+e.target.id).html(hours2 + ':' + minutes2 + ' <font color="red">$</font>');
		}
		if(limit >= 240)
		{
			$("#end_"+e.target.id).html(hours2 + ':' + minutes2);
		}
		
		
		
	
	
}
});


function select_time(day,mon,month)
{
$('#td_'+mon+'_'+day).toggleClass('bg-dark text-white');

var h = $('#h_'+mon+'_'+day).val();

if(h == 0)
{
	
	$('#h_'+mon+'_'+day).val(mon+'-'+day);

	for (i = 0; i <=10; i++) 
	{
		if($('#input_slider_'+i).val() == '')
		{	
			$('#slider_'+i).show();
			$('#c'+i).empty();
			$('#m_'+i).empty();
			$('#c'+i).append(day);
			$('#m_'+i).append(month);
			$('#input_slider_'+i).val(day);
			break;
		}
	}
}
else
{
	$('#h_'+mon+'_'+day).val(0);
	
	for (i = 0; i <=10; i++) 
	{
		if($('#input_slider_'+i).val() == day)
		{	
			$('#slider_'+i).hide();
			$('#input_slider_'+i).val('');
			break;
		}
	}
}

}

function show_month(step,month)
{
if(step == '>')
{
	next = parseInt(month)+1;
	$("#month_"+month).hide();
	$("#month_"+next).show();
}
if(step == '<')
{
	last = parseInt(month)-1;
	$("#month_"+month).hide();
	$("#month_"+last).show();
}
}