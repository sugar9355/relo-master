<style>

.loader
{
	float:left;
	height: 340px;
    width: 670px;
    
	margin-bottom: 10px;
}

.front
{
	float:left;
	margin-left: 10px;
	margin-bottom: 10px;
	height: 340px;
    width: 150px;
    border: 2px solid grey;
	border-radius: 15px 50px 30px 5px;
}

.window
{
	height: 150px;
    width: 125px;
	background-color:grey;
	margin-top: 10px;
	margin-left: 10px;
	margin-bottom: 4px;
	border-radius: 0px 50px 0px 0px;
}

.window_inner
{
	height: 140px;
    width: 95px;
	background-color:white;
	margin-top: 10px;
	margin-left: 10px;
	margin-bottom: 1px;
	border-radius: 0px 50px 0px 0px;
}

.gate
{
	
	margin-left: 10px;
	height: 150px;
    width: 125px;
    background-color:grey;
	border-radius: 0px 0px 15px 0px;
}

.back_wheel
{
	float:left;
	height: 80px;
	width: 80px;
	background-color: #bbb;
	border-radius: 50%;
	display: inline-block;
}

.front_wheel
{
	float:left;
	height: 80px;
	width: 80px;
	background-color: #bbb;
	border-radius: 50%;
	display: inline-block;
}

.back_bar
{
	float:left;
	margin:8px;
	height: 40px;
	width: 70px;
	background-color: grey;
}

.middle_bar
{
	float:left;
	margin:8px;
	height: 40px;
	width: 490px;
	background-color: grey;
}
.front_bar
{
	float:left;
	margin:8px;
	height: 40px;
	width: 60px;
	background-color: grey;
	border-radius: 15px 15px 30px 5px;
}
</style>
	

		<div style="width:auto; margin-top:10px;">
			<div class="loader">
			@include('booking.includes.loader')
			</div>	
			<div class="front">
			<div class="window"></div>
			<div class="gate"></div>
			</div>	
		</div>	
		<div style="clear:both;"></div>	
		
		<div style="width:auto;">
			<div class="back_bar"></div>	
			<div class="back_wheel"></div>	
			<div class="middle_bar">
			<div class="card-footer bg-white d-flex justify-content-between align-items-center p-0">
		<div class="pace-demo col-md-12 w-auto h-auto p-3 pb-4" style="padding-bottom: 30px;">
				<div class="theme_bar"><div class="pace_progress" data-progress-text="60%" data-progress="60" style="width: 60%;"><i class="icon-truck"></i> 60%</div></div>
			</div>
	
	</div>
			</div>
			<div class="front_wheel"></div>	
			<div class="front_bar"></div>
		</div>	
		<div style="clear:both;"></div>	
	