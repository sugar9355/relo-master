function add_item(id)
{
    var postData = $("#frm_add_items"+id).serializeArray();
    var formURL = $("#frm_add_items"+id).attr("action");
    
    $.ajax(
    {
        url : formURL,
        type: "POST",
        data : postData,
        success:function(data, textStatus, jqXHR) 
        {
            // location.href=location.href;
            $("#item_search").val(null)
            $("#selected_items").empty();
            $("#selected_items").append(data);
            
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            //if fails      
        }
    });

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/show_selected_items/"+booking_id,
        type: 'POST',
        success: function(data) {
            $('#items_container').empty()
            $('#items_container').append(data)
        }
    })

     return false;
}

function delete_item(booking_id,booking_item_id)
{
    $.ajax(
    {
        url : "/delete_item/"+booking_id+"/"+booking_item_id,
        type: "GET",
        success:function(data, textStatus, jqXHR) 
        {            
            // location.href=location.href;
            $("#selected_items").empty();
            $("#selected_items").append(data);
            
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            //if fails      
        }
    });

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/show_selected_items/"+booking_id,
        type: 'POST',
        success: function(data) {
            $('#items_container').empty()
            $('#items_container').append(data)
        }
    })

    return false;
}

//callback handler for form submit
function quantity_update(id,action)
{
    //event.preventDefault(); //STOP default action
    //event.unbind(); //unbind. to stop multiple form submit.
    $("#action"+id).val(action);
    
    $("#div_quantity"+id).empty();
    $("#quantity_"+id).val();
    $("#div_quantity"+id).append("<h3></h3>");

    var postData = $("#ajaxform"+id).serializeArray();
    var formURL = $("#ajaxform"+id).attr("action");
    
    // console.log(postData);
    // return;
    $.ajax(
    {
        url : formURL,
        type: "POST",
        data : postData,
        success:function(data, textStatus, jqXHR) 
        {
            
            // location.href=location.href;
            $("#selected_items").empty();
            $("#selected_items").append(data);
            $("#quantity-"+id).text($("#quantity_"+id).val());
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
            //if fails      
        }
    });

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "/show_selected_items/"+booking_id,
        type: 'POST',
        success: function(data) {
            $('#items_container').empty()
            $('#items_container').append(data)
        }
    })

    return false;
}

//callback handler for form submit
function add_packaging(id,action)
{
    //var pkg = $('#'+id+'pkg').val();

    var postData = $("#ajaxpkg"+id).serializeArray();
    var formURL = $("#ajaxpkg"+id).attr("action");
    
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
    
     return false;
}

function add_accuracy(id)
{

    $("#accuracy").val(id);

    // var postData = $("#accuracyform").serializeArray();
    // var formURL = $("#accuracyform").attr("action");

    $('#accuracyform').submit();
    
    // $.ajax(
    // {
    //     url : formURL,
    //     type: "POST",
    //     data : postData,
    //     success:function(data, textStatus, jqXHR) 
    //     {
    //         $( "div[id*='div_']" ).removeClass('alert-success');
    //         $("#div_"+id).addClass('alert-success');
    //         $('#modalPoll-1').modal('show');
    //     },
    //     error: function(jqXHR, textStatus, errorThrown) 
    //     {
    //         //if fails      
    //     }
    // });
    
     return false;
}