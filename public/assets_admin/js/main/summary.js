function edit_location(id)
{
    $("#btn_edit_location"+id).hide();
    $("#btn_save_location"+id).show();
    $("#btn_cancel_location"+id).show();
    
    $("#loc_1").hide();
    $("#loc_2").hide();
    $("#loc_1_edit").fadeIn();
    $("#loc_2_edit").fadeIn();

}

function update_location(id)
{
    $("#btn_save_location"+id).hide();
    $("#btn_cancel_location"+id).hide();
    $("#btn_edit_location"+id).show();
    
    $("#loc_1_edit").hide();
    $("#loc_2_edit").hide();
    $("#loc_1").fadeIn();
    $("#loc_2").fadeIn();
    
    var postData = $("#frm_save_location").serializeArray();
    var formURL = $("#frm_save_location").attr("action");
    
    $.ajax(
    {
        url : formURL,
        type: "POST",
        data : postData,
        success:function(data, textStatus, jqXHR) 
        {
            console.log(data);
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            //if fails      
        }
    });
    
}

function cancel_location(id)
{
    
    $("#btn_save_location"+id).hide();
    $("#btn_cancel_location"+id).hide();
    $("#btn_edit_location"+id).show();
    
    $("#loc_1_edit").hide();
    $("#loc_2_edit").hide();
    $("#loc_1").fadeIn();
    $("#loc_2").fadeIn();
    
}


function update_date(date)
{

    $(this).addClass("bg-dark");

    $('#date').val(date);
    var flexible = $('#flexible').val()
    // $('#saveDate').submit();
    
    $.ajax(
    {
        url : "/save_date/"+booking_id+"/" + date,
        type: "GET",
        data: {
            date: date,
            flexible: flexible
        },
        success:function(data, textStatus, jqXHR) 
        {
            if(textStatus === 'success')
            {
                // $("#date_time").empty();
                // $("#date_time").append(data);
                location.reload();
            }
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            //console.log(textStatus)
        }
    });
}

function update_crew(crew)
{
    $('#crew').val(crew);
    $('#selCrew').submit();
    // $.ajax(
    // {
    //     url : "/update_crew/"+booking_id+"/"+crew,
    //     type: "Get",
    //     success:function(data, textStatus, jqXHR) 
    //     {
    //         if(textStatus === 'success')
    //         {
    //             $("#pricing_date_time").empty();
    //             $("#pricing_date_time").append(data);
    //         }
    //     },
    //     error: function(jqXHR, textStatus, errorThrown) 
    //     {
    //         //console.log(textStatus)
    //     }
    // });
    
    //  return false;
}

function save_time(start,end)
{
    console.log(start+'-'+end);
    $.ajax(
    {
        url : "/save_time/"+booking_id+"/"+start+"/"+end,
        type: "Get",
        success:function(data, textStatus, jqXHR) 
        {
            if(textStatus === 'success')
            {
            }
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
        }
    });
    
     return false;
}

function update_insurance(amount)
{
    $( "div[id^='insurance_type_']" ).removeClass('bg-warning');
    $( "i[id^='icon_']" ).removeClass('text-dark');
    
    $( "div[id^='amount_']" ).empty();
    $( "div[id^='amount_']" ).append('$'+amount);
    $( "input[id^='item_']" ).val(amount);
    
    //$("#insurance_type_"+amount).removeClass('bg-white');
    $("#insurance_type_"+amount).addClass('bg-warning');
    
    //$("#icon_"+amount).removeClass('text-white');
    $("#icon_"+amount).addClass('text-dark');
    
    $.ajax(
    {
        url : "/update_insurance/"+booking_id+"/"+amount,
        type: "Get",
        success:function(data, textStatus, jqXHR) 
        {
            if(textStatus === 'success')
            {
                $("#accordion-insurance").empty();
                $("#accordion-insurance").append(data);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            //console.log(textStatus)
        }
    });
    
     return false;
}

function update_item_insurance(id)
{
    
    var amount = $("#item_"+id).val();
    $("#amount_"+id).empty();
    $("#amount_"+id).append('$'+amount);
    
    $.ajax(
    {
        url : "/update_item_insurance/"+booking_id+"/"+id+"/"+amount,
        type: "Get",
        success:function(data, textStatus, jqXHR) 
        {
            if(textStatus === 'success')
            {
                $("#accordion-insurance").empty();
                $("#accordion-insurance").append(data);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            //console.log(textStatus)
        }
    });
    
     return false;
}


let s_input = document.getElementById('start');
let d_input = document.getElementById('end');

let autocomplete_source = new google.maps.places.Autocomplete(s_input);
let autocomplete_destination = new google.maps.places.Autocomplete(d_input);

autocomplete_source.addListener('place_changed', function(event) 
{
    let place = autocomplete_source.getPlace();
    $("#lat_1").val(place.geometry.location.lat());
    $("#lng_1").val(place.geometry.location.lng());
});

autocomplete_destination.addListener('place_changed', function(event) 
{
    let place = autocomplete_destination.getPlace();
    $("#lat_2").val(place.geometry.location.lat());
    $("#lng_2").val(place.geometry.location.lng());
    
    getDistanceTime();
    
});

function getVals()
{
  // Get slider values
  var parent = this.parentNode;
  var slides = parent.getElementsByTagName("input");
    var slide1 = parseFloat( slides[0].value );
    var slide2 = parseFloat( slides[1].value );
  // Neither slider will clip the other, so make sure we determine which is larger
  if( slide1 > slide2 ){ var tmp = slide2; slide2 = slide1; slide1 = tmp; }
  
  var displayElement = parent.getElementsByClassName("rangeValues")[0];
      displayElement.innerHTML = slide1 + " - " + slide2;
}

window.onload = function()
{
  // Initialize Sliders
  var sliderSections = document.getElementsByClassName("range-slider");
      for( var x = 0; x < sliderSections.length; x++ ){
        var sliders = sliderSections[x].getElementsByTagName("input");
        for( var y = 0; y < sliders.length; y++ ){
          if( sliders[y].type ==="range" ){
            sliders[y].oninput = getVals;
            // Manually trigger event first time to display values
            sliders[y].oninput();
          }
        }
      }
}

var m_s_t = '6:00 AM';
var m_e_t = '6:00 PM';

$(".slider").slider({
    tooltip: 'always',
    range: true,
    min: 0,
    max: 12,
    step: 1,
    values:[0,12],
    slide: function (e, ui) 
    {
        var week = $("#week_"+e.target.id).val();
        var start = ui.values[0];
        var end = ui.values[1];
        
        if(working_hours[start][week] == 0 || working_hours[end][week] == 0)
        {
            $("#price_"+e.target.id).show();
        }
        else
        {
            $("#price_"+e.target.id).hide();
        }
        
        
        $("#time_"+e.target.id).empty();
        $("#time_"+e.target.id).append('Time Range: '+working_hours[start].time +' - '+ working_hours[end].time);
        
        $("#start_"+e.target.id).val(working_hours[start].time);
        $("#end_"+e.target.id).val(working_hours[end].time);

        m_s_t = working_hours[start].time;
        m_e_t = working_hours[end].time;
}
});

$(".slider").mouseup(function()
{
  $.ajax(
    {
        url : "/save_time/"+booking_id+"/"+m_s_t+"/"+m_e_t,
        type: "Get",
        success:function(data, textStatus, jqXHR) 
        {
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
        }
    });    
});

$('#reload').click(function() {
    location.reload();
})
