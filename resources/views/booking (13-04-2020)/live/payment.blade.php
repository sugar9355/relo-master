@extends('user.layout.app')
@section('content')

<style>

    .profile-box{
      background: rgba(255,193,7,1);
      background: -moz-linear-gradient(top, rgba(255,193,7,1) 0%, rgba(255,146,10,1) 100%);
      background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(255,193,7,1)), color-stop(100%, rgba(255,146,10,1)));
      background: -webkit-linear-gradient(top, rgba(255,193,7,1) 0%, rgba(255,146,10,1) 100%);
      background: -o-linear-gradient(top, rgba(255,193,7,1) 0%, rgba(255,146,10,1) 100%);
      background: -ms-linear-gradient(top, rgba(255,193,7,1) 0%, rgba(255,146,10,1) 100%);
      background: linear-gradient(to bottom, rgba(255,193,7,1) 0%, rgba(255,146,10,1) 100%);
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffc107', endColorstr='#ff920a', GradientType=0 );
    }
    .job-item{
      width: 100%;
    }
    .job-item a{
      color: #333;
      width:100%;
      text-decoration: none;
    }
    .job-item p{
      padding:3px 0 7px 0;
      margin: 0px;
    }
    .job-item p.lead{
      border-bottom: 0px;
    }
    .profile-box a:before{
      background-color: #333;
    }

  </style>

    <div class="container my-5"> 
      <div class="row">
        <div class="col-md-3">
          <div class="card bg-warning profile-box">
            <div class="card-body">
              <div class="p-3 pt-0 text-center"><img src="https://randomuser.me/api/portraits/men/17.jpg" alt="" class="rounded-circle"></div>
              <h5 class="card-title text-center"></h5>
              <p class="text-center">NL</p>
            </div>
            <div class="list-group">
              <a href="#" class="list-group-item list-group-item-action hvr-sweep-to-right"><i class="far fa-clock mr-2"></i> Scheduled Jobs</a>
              <a href="#" class="list-group-item list-group-item-action hvr-sweep-to-right"><i class="fas fa-history mr-2"></i> Job History</a>
              <a href="#" class="list-group-item list-group-item-action hvr-sweep-to-right"><i class="far fa-user-circle mr-2"></i> Profile</a>
              <a href="#" class="list-group-item list-group-item-action hvr-sweep-to-right"><i class="far fa-comment-dots mr-2"></i> Messages</a>
              <a href="#" class="list-group-item list-group-item-action hvr-sweep-to-right"><i class="far fa-bell mr-2"></i> Notifications</a>
            </div>
          </div>
          
        </div>
		
		
		<div class="col-md-9">

          <h1>Payment Info <small class="float-right">16 Jan, 2020</small></h1>
          <hr>

          <div class="card card-body px-4">
            <div class="row">
              <div class="col-md-6 border-bottom py-3">
                <strong>First Name:</strong> Hilal 
              </div>
              <div class="col-md-6 border-bottom py-3">
                <strong>Last Name:</strong> Siddiqui
              </div>
              <div class="col-md-6 border-bottom py-3">
                <strong>Card Number:</strong> 0009875698168
              </div>
              <div class="col-md-6 border-bottom py-3">
                <strong>Card Type:</strong> Credit Card
              </div>
              <div class="col-md-6 border-bottom py-3">
                <strong>Expiration:</strong> 16-03-2020
              </div>
              <div class="col-md-6 border-bottom py-3">
                <strong>CVV:</strong> 569875
              </div>
            </div>
            
            
            
            
            
            
            
          </div>
          
        </div>
		
		
		
		
      </div>

    </div>

@endsection
