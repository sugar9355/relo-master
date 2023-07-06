@extends('admin.layout.base')

@section('title', 'Backend Users ')

@section('content')
<div class="card">
<div class="card-header"><h3 class="mb-1 mr-2 border-bottom pb-2">@lang('admin.users.Users') Schedule</h3></div>

<style>

	.job-time-box{
		min-height:50px;
	}
	
	.morning{

background: rgba(73,155,234,1);
background: -moz-linear-gradient(left, rgba(73,155,234,1) 0%, rgba(32,124,229,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(73,155,234,1)), color-stop(100%, rgba(32,124,229,1)));
background: -webkit-linear-gradient(left, rgba(73,155,234,1) 0%, rgba(32,124,229,1) 100%);
background: -o-linear-gradient(left, rgba(73,155,234,1) 0%, rgba(32,124,229,1) 100%);
background: -ms-linear-gradient(left, rgba(73,155,234,1) 0%, rgba(32,124,229,1) 100%);
background: linear-gradient(to right, rgba(73,155,234,1) 0%, rgba(32,124,229,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#499bea', endColorstr='#207ce5', GradientType=1 );
	}

.evening{

background: rgba(255,175,75,1);
background: -moz-linear-gradient(left, rgba(255,175,75,1) 0%, rgba(255,146,10,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(255,175,75,1)), color-stop(100%, rgba(255,146,10,1)));
background: -webkit-linear-gradient(left, rgba(255,175,75,1) 0%, rgba(255,146,10,1) 100%);
background: -o-linear-gradient(left, rgba(255,175,75,1) 0%, rgba(255,146,10,1) 100%);
background: -ms-linear-gradient(left, rgba(255,175,75,1) 0%, rgba(255,146,10,1) 100%);
background: linear-gradient(to right, rgba(255,175,75,1) 0%, rgba(255,146,10,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffaf4b', endColorstr='#ff920a', GradientType=1 );

}
.night{


background: rgba(0,12,99,1);
background: -moz-linear-gradient(-45deg, rgba(0,12,99,1) 0%, rgba(0,99,148,1) 100%);
background: -webkit-gradient(left top, right bottom, color-stop(0%, rgba(0,12,99,1)), color-stop(100%, rgba(0,99,148,1)));
background: -webkit-linear-gradient(-45deg, rgba(0,12,99,1) 0%, rgba(0,99,148,1) 100%);
background: -o-linear-gradient(-45deg, rgba(0,12,99,1) 0%, rgba(0,99,148,1) 100%);
background: -ms-linear-gradient(-45deg, rgba(0,12,99,1) 0%, rgba(0,99,148,1) 100%);
background: linear-gradient(135deg, rgba(0,12,99,1) 0%, rgba(0,99,148,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000c63', endColorstr='#006394', GradientType=1 );


}

</style>

<div class="card-body">

	<table class="table w-100">
	
	<?php 
	
	$hours = array('6'=>1,'7'=>2,'8'=>3,'9'=>4,'10'=>5,'11'=>6,'12'=>7,'1'=>8,'2'=>9,'3'=>10,'4'=>11,'5'=>12);
	$mode = array('6'=>'AM','7'=>'AM','8'=>'AM','9'=>'AM','10'=>'AM','11'=>'AM','12'=>'AM','1'=>'AM','2'=>'AM','3'=>'AM','4'=>'AM','5'=>'AM');
	$dhours  = array_flip($hours);
	
	// echo '<pre>';
	// print_r($slote);
	// echo '</pre>';
	
	foreach($slote as $key => $v) 
	{
		if($v['d'] != '')
		{
		echo '<tr>';
		echo '<td width="100" class="border-right">'.($v['d']).' '.ucwords($v['w']).'</td>';
		
		echo '<td style="width:780px;" class="p-1"><div class="job-time-box bg-dark text-slate-800 m-1 p-2 d-flex rounded">';
		
		$vs = explode(',',$v['s']);
		
		if(isset($v['n']))
		{
			$vn = explode(',',$v['n']);
			foreach($vs as $s_k => $s)
			{
				$segs = explode('-',$vn[$s_k]);
				
				$per = ($segs[1]-$segs[0]);
				
				if(isset($vn[$s_k+1]))
				{
					$next_segs = explode('-',$vn[$s_k+1]);
				}
				
				if($s_k == 0 && $segs[0] > 60)
				{
					
					echo '<span class="d-inline-block border-left border-right border-light"><span class="w-100 px-2 py-2 d-block morning"></span><span class="px-2">6:00 AM <span class="px-2">-</span>'.explode('-',$s)[0].'</span></span>';
				}
				
				echo '<span class="d-inline-block border-left border-right border-light"><span class="w-100 px-2 py-2 d-block bg-success"></span><span class="px-2">'.$s.'</span></span>';
				
				if(isset($segs[1]) && isset($next_segs[0]) && $segs[1] != 60)
				{
					$first_seg = $dhours[floor(($segs[1]+1) / 60)].':'.($segs[1]+1) % 60;
					$first_seg = explode(':',$first_seg);
					if($first_seg[1] == 0)
					{
						$first_seg[1] = '00';
					}
					$min_time = $first_seg[0].':'.$first_seg[1].' '.$mode[$first_seg[0]];
					
					$second_seg = $dhours[floor(($next_segs[0]-1) / 60)].':'.($next_segs[0]-1) % 60;
					$second_seg = explode(':',$second_seg);
					if($second_seg[1] == 0)
					{
						$second_seg[1] = '00';
					}
					
					$max_time = $second_seg[0].':'.$second_seg[1].' '.$mode[$second_seg[0]];
					
					echo '<span class="d-inline-block border-left border-right border-light"><span class="w-100 px-2 py-2 d-block evening"></span><span class="px-2">'.$min_time.'<span class="px-2">-</span>'.$max_time.'</span></span>';
				}
				
				if($s_k == count($vs)-1 && $segs[1] > 60)
				{
					echo '<span class="d-inline-block border-left border-right border-light"><span class="w-100 px-2 py-2 d-block night"></span><span class="px-2">'.explode('-',$s)[1].'<span class="px-2">-</span>6:00 PM</span></span>';
				}
			}
		}
		
		echo '</div></td>';
		
		echo '</tr>';

		}
	}
	
	?>
	
	</table>
	

</div>


</div>
@endsection