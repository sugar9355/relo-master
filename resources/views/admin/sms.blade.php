@extends('admin.layout.base')



@section('title', 'Dashboard ')



@section('styles')

<style>
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%; padding:
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 60%;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}
.chat_date{
  padding-right: 10px !important;
}

</style>

@endsection



@section('content')

<div class="row">

    <div class="col-md-12">

        <div class="card">

            <!-- card header -->

            <div class="card-header header-elements-inline">

                <h4 class="card-title">

                    SMS Panel

                </h4>

                <div class="header-elements">

                    <div class="list-icons">

                        <a class="list-icons-item" data-action="collapse"></a>

                        <a class="list-icons-item" data-action="reload"></a>

                    </div>

                </div>

            </div>

            <!-- card body -->

            <div class="card-body">
                <div class="container">
<h3 class=" text-center">Messaging</h3>
<input id="totalcount" hidden value="{{$chat_count[0]->count}}">
<input  id="booking_id" hidden>
<input id="full_name" hidden>
<input  id="phone_number" hidden>
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Recent</h4>
            </div>
            <div class="srch_bar">
              <div class="stylish-input-group">
                <input type="text" class="search-bar"  placeholder="Search" >
                <span class="input-group-addon">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> </div>
            </div>
          </div>
          <div class="inbox_chat">

            @if(count($chat_list)==0)
<div class="chat_list ">
              <div class="chat_people">
                
                <div class="chat_ib">
                  <h5>No Recent Chats</h5>
                </div>
              </div>
            </div>
            @else
            @foreach($chat_list as $chat)
<div class="chat_list  chat_message" data-phone="{{$chat->phone_number}}" data-fullname="{{$chat->full_name}}" data-booking="{{$chat->booking_id}}">
              <div class="chat_people">
                <div class="chat_img"> <img src="{{asset('assets_admin/images/user-profile.png')}}" alt="sunil"> </div>
                <div class="chat_ib">
                  <h5>{{$chat->full_name}}
                    @if($chat->count_msg>0)
                    <span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">{{$chat->count_msg}}</span> 
                    @endif
                    <span class="chat_date">{{$chat->createdat}}</span></h5>
                </div>
              </div>
            </div>
            @endforeach
            @endif

            
          </div>
        </div>
        <div class="mesgs">
          <div class="msg_history">
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" class="write_msg" placeholder="Type a message" />
              <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
      </div>
      

    </div></div>

            </div>

        </div>

    </div>

</div>

<script>
  var sentNexturl = null;
  var recievedMsgesnexturl = null;
  
    function formatDate(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime+ " |  "+ date.getDate() + "-" + (date.getMonth()+1) + "-" +  date.getFullYear();

}

function chatAppend(phoneNumber){
     var phonesnumbers = phoneNumber;
    var messages_value = '';
  //sent mesages
               var sent = {
  "url": "https://api.twilio.com/2010-04-01/Accounts/AC23ed296c1d0c93698f68cd55cc252798/Messages.json?PageSize=20&To="+phonesnumbers+"&From={{env('TWILIO_NUMBER')}}",
  "method": "GET",
  "timeout": 0,
  "headers": {
    "Authorization": "Basic {{env('TWILIO_AUTH')}}"
  },
};

   var recievedMsges = {
  "url": "https://api.twilio.com/2010-04-01/Accounts/AC23ed296c1d0c93698f68cd55cc252798/Messages.json?PageSize=20&To={{env('TWILIO_NUMBER')}}&From="+phonesnumbers,
  "method": "GET",
  "timeout": 0,
  "headers": {
    "Authorization": "Basic {{env('TWILIO_AUTH')}}"
  },
};

$.ajax(sent).done(function (response) {
    var sentMessage = response.messages;
    sentNexturl = response.next_page_uri;
  $.ajax(recievedMsges).done(function (recievedMsgList) {
    var allmessages = sentMessage.concat(recievedMsgList.messages);
    recievedMsgesnexturl = recievedMsgList.next_page_uri;

    allmessages.sort((a, b) => (new Date(a.date_created).valueOf() > new Date(b.date_created).valueOf()) ? 1 : -1)
    // console.log(allmessages);
     $.each(allmessages,function(index,value){
    var d = new Date(value.date_created);
var time_formats = formatDate(d);

    if(value.direction==='inbound'){
            messages_value +='<div class="incoming_msg"><div class="received_msg"><div class="received_withd_msg"><p>'+value.body+'</p><span class="time_date"> '+time_formats+'</span></div></div></div>'
    }
    else{
messages_value += '<div class="outgoing_msg"><div class="sent_msg"><p>'+value.body+'</p><span class="time_date">'+time_formats+'</span> </div></div>'
    }
  })
  $('.msg_history').html(messages_value);
  $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
});
});

}

  jQuery(document).ready(function() {
   
   $(document).on('click','.chat_message',function(e){
  var phone  = $(this).data('phone');
  var full_name = $(this).data('fullname');
  var booking_id = $(this).data('booking');
  $('#phone_number').val(phone);
  $('#full_name').val(full_name)
  $('#booking_id').val(booking_id)
  $('.chat_message').removeClass('active_chat');
  $(this).addClass('active_chat');
  chatAppend(phone);
})

$('.msg_send_btn').click(function(event){
    if($('.write_msg').val()!=''){
       $.ajax({
           type: "POST",
           url: "/admin/send_messages",
           data: {'message':$('.write_msg').val(),'booking_id':$('#booking_id').val(),'phone_number':$('#phone_number').val(),'full_name':$('#full_name').val()},
            // beforeSend: function(xhr){xhr.setRequestHeader('X-Test-Header', 'test-value');},
            headers:{
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
           success: function(data)
           {
            if(data.status==200){
                var time = new Date();
                var time_formats = formatDate(time);
                var new_message = '<div class="outgoing_msg"><div class="sent_msg"><p>'+data.message+'</p><span class="time_date">'+time_formats+'</span> </div></div>';
                 $('.msg_history').append(new_message);
                $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
                $('.write_msg').val('');
            }
           }
         });  
    }
   
})





$('.search-bar').keyup(function(event){
  var images ="{{asset('assets_admin/images/user-profile.png')}}";
  var userui  ='';
       $.ajax({
           type: "POST",
           url: "/admin/user_search",
           data: {'user_name':$('.search-bar').val()},
            // beforeSend: function(xhr){xhr.setRequestHeader('X-Test-Header', 'test-value');},
            headers:{
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
           success: function(data)
           {
            if(data.status==200){
              $('.inbox_chat').html('');
              $('.msg_history').html('');
                var userlist = data.users;
                if(userlist.length>0){
                   $.each(userlist,function(index,value){
                userui += '<div class="chat_list  chat_message" data-phone="'+value.phone_number+'" data-fullname="'+value.full_name+'" data-booking="'+value.booking_id+'"><div class="chat_people"> <div class="chat_img"> <img src="'+images+'" alt="sunil"> </div><div class="chat_ib"> <h5>'+value.full_name;
                if(value.count_msg>0){
                    userui +='<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">'+value.count_msg+'</span>'; 
                    }
                userui +=' <span class="chat_date">'+value.createdat+'</span></h5></div> </div></div>'
                })            
            $('.inbox_chat').html(userui);
                }else{
                   $('.inbox_chat').html('<div class="chat_list "><div class="chat_people"><div class="chat_ib"><h5>No Recent Chats</h5></div></div></div>');
                  
                }
               

            }
           }
         });  

   
})

    $('.inbox_chat').scroll(function(event){
  var offset  =0;
  var images ="{{asset('assets_admin/images/user-profile.png')}}";
  var total_count = $('#totalcount').val()*1;
  var display_user = $('.chat_message').length*1;
  var userui  ='';
  if((total_count>display_user) && ($(this).scrollTop() + $(this).innerHeight()>=$(this)[0].scrollHeight)){
    offset++;
      $.ajax({
           type: "POST",
           url: "/admin/user_search",
           data: {'offset':offset*1},
            // beforeSend: function(xhr){xhr.setRequestHeader('X-Test-Header', 'test-value');},
            headers:{
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
           success: function(data)
           {
            if(data.status==200){
                var userlist = data.users;
                   $.each(userlist,function(index,value){
                 userui += '<div class="chat_list  chat_message" data-phone="'+value.phone_number+'" data-fullname="'+value.full_name+'" data-booking="'+value.booking_id+'"><div class="chat_people"> <div class="chat_img"> <img src="'+images+'" alt="sunil"> </div><div class="chat_ib"> <h5>'+value.full_name;
                if(value.count_msg>0){
                    userui +='<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">'+value.count_msg+'</span>'; 
                    }
                userui +=' <span class="chat_date">'+value.createdat+'</span></h5></div> </div></div>'
                })            
            $('.inbox_chat').append(userui);
                
               

            }
           }
         });
  }
       

   
})


  $('.msg_history').scroll(function(event){
    if($(this).scrollTop()==0){
      
  chatAppendNew(sentNexturl,recievedMsgesnexturl);
    }
    

  })




  })

function chatAppendNew(sentUrl,RecivedUrl){
  if(sentUrl!=null && RecivedUrl!=null){
//sent mesages
               var sent = {
  "url": "https://api.twilio.com"+sentUrl,
  "method": "GET",
  "timeout": 0,
  "headers": {
    "Authorization": "Basic {{env('TWILIO_AUTH')}}"
  },
};

   var recievedMsges = {
  "url": "https://api.twilio.com"+RecivedUrl,
  "method": "GET",
  "timeout": 0,
  "headers": {
    "Authorization": "Basic {{env('TWILIO_AUTH')}}"
  },
};

$.ajax(sent).done(function (response) {
    var sentMessage = response.messages;
    sentNexturl = response.next_page_uri;
  $.ajax(recievedMsges).done(function (recievedMsgList) {
    var allmessages = sentMessage.concat(recievedMsgList.messages);
    recievedMsgesnexturl = recievedMsgList.next_page_uri;

    allmessages.sort((a, b) => (new Date(a.date_created).valueOf() > new Date(b.date_created).valueOf()) ? 1 : -1)
    // console.log(allmessages);
     $.each(allmessages,function(index,value){
    var d = new Date(value.date_created);
var time_formats = formatDate(d);

    if(value.direction==='inbound'){
            messages_value +='<div class="incoming_msg"><div class="received_msg"><div class="received_withd_msg"><p>'+value.body+'</p><span class="time_date"> '+time_formats+'</span></div></div></div>'
    }
    else{
messages_value += '<div class="outgoing_msg"><div class="sent_msg"><p>'+value.body+'</p><span class="time_date">'+time_formats+'</span> </div></div>'
    }
  })
  $('.msg_history').prepend(messages_value);
});
});
  }
  else if(sentUrl!=null && RecivedUrl==null){
                var sent = {
  "url": "https://api.twilio.com"+sentUrl,
  "method": "GET",
  "timeout": 0,
  "headers": {
    "Authorization": "Basic {{env('TWILIO_AUTH')}}"
  },
};
$.ajax(sent).done(function (response) {
    var sentMessage = response.messages;
    sentNexturl = response.next_page_uri;
    recievedMsgesnexturl = null;
      sentMessage.sort((a, b) => (new Date(a.date_created).valueOf() > new Date(b.date_created).valueOf()) ? 1 : -1)
      var new_messages = '';
    // console.log(allmessages);
     $.each(sentMessage,function(index,value){
    var d = new Date(value.date_created);
var time_formats = formatDate(d);

    if(value.direction==='inbound'){
            new_messages +='<div class="incoming_msg"><div class="received_msg"><div class="received_withd_msg"><p>'+value.body+'</p><span class="time_date"> '+time_formats+'</span></div></div></div>'
    }
    else{
new_messages += '<div class="outgoing_msg"><div class="sent_msg"><p>'+value.body+'</p><span class="time_date">'+time_formats+'</span> </div></div>'
    }
  })
  $('.msg_history').prepend(new_messages);

  })


  }
  else if(sentUrl==null && RecivedUrl!=null) {
     var recievedMsges = {
  "url": "https://api.twilio.com"+RecivedUrl,
  "method": "GET",
  "timeout": 0,
  "headers": {
    "Authorization": "Basic {{env('TWILIO_AUTH')}}"
  },
};
$.ajax(recievedMsges).done(function (response) {
    var sentMessage = response.messages;
    recievedMsgesnexturl = response.next_page_uri;
   sentNexturl = null;

   sentMessage.sort((a, b) => (new Date(a.date_created).valueOf() > new Date(b.date_created).valueOf()) ? 1 : -1)
      var new_messages = '';
    // console.log(allmessages);
     $.each(sentMessage,function(index,value){
    var d = new Date(value.date_created);
var time_formats = formatDate(d);

    if(value.direction==='inbound'){
            new_messages +='<div class="incoming_msg"><div class="received_msg"><div class="received_withd_msg"><p>'+value.body+'</p><span class="time_date"> '+time_formats+'</span></div></div></div>'
    }
    else{
new_messages += '<div class="outgoing_msg"><div class="sent_msg"><p>'+value.body+'</p><span class="time_date">'+time_formats+'</span> </div></div>'
    }
  })
  $('.msg_history').prepend(new_messages);
  })
  }
}

</script>

@endsection


