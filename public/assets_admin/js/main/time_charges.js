
	var currentTime = new Date();
	var year = currentTime.getFullYear();
	
	$(".slider-range").slider({
		range: true,
		min: 360,
		max: 1440,
		step: 30,
		values: [360, 360],
		slide: function (e, ui) {
		
		console.log(ui.value);
		
			
			
			var hours1 = Math.floor(ui.values[0] / 60);
			var minutes1 = ui.values[0] - (hours1 * 60);
			
			$('#digit_start_'+e.target.id).val(ui.values[0]);
			

			if (hours1.length == 1) hours1 = '0' + hours1;
			if (minutes1.length == 1) minutes1 = '0' + minutes1;
			if (minutes1 == 0) minutes1 = '00';
			if (hours1 >= 12) {
				if (hours1 == 12) {
					hours1 = hours1;
					minutes1 = minutes1 + " PM ";
				} else {
					hours1 = hours1 - 12;
					minutes1 = minutes1 + " PM ";
				}
			} else {
				hours1 = hours1;
				minutes1 = minutes1 + " AM ";
			}
			if (hours1 == 0) {
				hours1 = 12;
				minutes1 = minutes1;
			}
			
			$("#start_span_"+e.target.id).html(hours1 + ':' + minutes1);
			$("#start_"+e.target.id).val(hours1 + ':' + minutes1);
			
			var hours2 = Math.floor(ui.values[1] / 60);
			var minutes2 = ui.values[1] - (hours2 * 60);
			
			$('#digit_end_'+e.target.id).val(ui.values[1]);

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
	
			$("#end_span_"+e.target.id).html(hours2 + ':' + minutes2);
			
			limit = ui.values[1] - ui.values[0];
			
			$("#end_"+e.target.id).val(hours2 + ':' + minutes2);
			
			
		}
	});
	
	function select_date(date)
	{
		var d = date.split("-");

		var day   = d[2];
		var month = d[1];
		var year  = d[0];
		
		//console.log($(this).hasClass('bg-dark'));
		console.log(date);
		//console.log($("#h"+month).html());
		
		if ($("#td_"+date).hasClass("bg-dark")) 
		{
			$("#td_"+date).removeClass('bg-dark text-white');
			for (i = 0; i <=10; i++) 
			{
				//console.log($('#date_'+i).val()+' '+date);
				if($('#date_'+i).val() == date)
				{	
					$('#slider_'+i).hide();
					$('#date_'+i).val('');
					$('#start_time_'+i).val('');
					$('#end_time_'+i).val('');
					break;
				}
			}
		}
		else
		{
			$("#td_"+date).addClass('bg-dark text-white');
			for (i = 0; i <=10; i++) 
			{
			
				if($('#date_'+i).val() == '')
				{	
					$('#slider_'+i).show();
					$('#c'+i).empty();
					$('#m_'+i).empty();
					$('#c'+i).append(day);
					$('#m_'+i).append($("#h"+month).html());
					$('#date_'+i).val(date);
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
	
	