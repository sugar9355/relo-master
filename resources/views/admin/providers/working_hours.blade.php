<div class="modal-content  modal-lg">

    <div class="modal-header">
        <h4 class="modal-title">Working Hours</h4>
    </div>
      
    <div class="modal-body">
        <div class="form-group">
        
            <label>Hourly Rate : </label>
            
            <form id="hourlyRateForm" action="{{route('admin.employee_rate.update',$employee->id)}}" method="post" enctype="multipart/form-data">
        
                {{ csrf_field() }}
                
                <input type="hidden" name="_method" value="PATCH">
                
                <div class="form-inline">
                <input type="text" name="hourly_rate" class="form-control col-md-2" value="@if(isset($employee->hourly_rate)){{$employee->hourly_rate}}@endif" placeholder="$">
                {{-- @foreach ($demand_types as $demand)
                <div class="col-md-3">
                    <label for="" class="col-md-12 col-form-label">{{$demand->demand_name}} Rate</label>
                    <div class="col-md-10">
                        <input class="form-control demand_rate" type="text" value="{{$demand->rate}}" required data-id="{{$demand->id}}">
                    </div>
                </div>
                @endforeach
                <input type="hidden" name="demand_rates" id="demand_rates" />
                <hr> --}}
                <button type="submit" name="update_hourly_rate" value="true" class="btn bg-indigo-400"><i class="icon-checkmark3 mr-2"></i> Save</button>
                </div>
            </form>
        </div>

        {{-- <div class="form-group">
            <label>Total Working Hours</label>
                @if(isset($hours)) {{$hours}} <i>hours</i> @endif
                @if(isset($minutes)) {{$minutes}} <i>mins</i> @endif
        </div>

        <div class="form-group">
            <label>Total Amount</label>
            @if(isset($total_amount)) {{$total_amount}} <strong>$</strong> @endif
            @isset($last_claim->payment_recieved)
                @if($last_claim->payment_recieved == $total_amount)
                    <i><font color="green">Payment Recieved </font></i>
                @endif
            @endisset
        </div>

        <div class="form-group">
            <label>Total Working Days</label>
            <table class="table table-bordered" >
                <thead> <tr><td>Shift Start</td><td>Shift End</td><td>Shift Hours</td></tr></thead>
                 <tbody>
                @if(!empty($working_hours))
                @foreach($working_hours as $hours)
                
                    <tr>
                        <td>{{$hours->shift_start}}</td>
                        <td>{{$hours->shift_end}}</td>
                        <td>{{$hours->hours}}</td>
                    </tr>
                    
                @endforeach
                @endif
                 </tbody>
                </table>
        </div>

        <div class="form-group">
            <label>Payment Recieved</label>
            @if(isset($last_claim) && ($last_claim->payment_recieved == null))
                <input type="hidden" name="amount" value="@if(isset($total_amount)) {{$total_amount}} @endif" >
                <button type="submit" name="update_claim" value="true"  class="btn btn-primary">Confirm</button><br>
                
            @else
                <font color="red">User has not Claimed Yet</font>
            @endif
            <span class="text-danger">Note: click on confirm button If Payment is Disbursed</span>
        </div> --}}
        <form action="{{ route('admin.provider.set_time', $employee->id) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class="form-group">
            <label for="name" class="col-md-12 col-form-label">Days for a working</label>
            <select id="days" name="days[]" class="form-control select" data-container-css-class="bg-blue-400" multiple>
                <option value="1" @if (in_array(1, $available_days)) selected @endif>Monday</option>
                <option value="2" @if (in_array(2, $available_days)) selected @endif>Tuesday</option>
                <option value="3" @if (in_array(3, $available_days)) selected @endif>Wednesday</option>
                <option value="4" @if (in_array(4, $available_days)) selected @endif>Thursday</option>
                <option value="5" @if (in_array(5, $available_days)) selected @endif>Friday</option>
                <option value="6" @if (in_array(6, $available_days)) selected @endif>Saturday</option>
                <option value="7" @if (in_array(7, $available_days)) selected @endif>Sunday</option>
            </select>
        </div>

        <div class="form-group">
            <label for="">Start Time</label>
            <input type="time" class="form-control" name="start_time" value="{{$available_start_time}}">
        </div>

        <div class="form-group">
            <label for="">End Time</label>
            <input type="time" class="form-control" name="end_time" value="{{$available_end_time}}">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="icon-database-time2"></i> Submit Time</button>
        </div>
        </form>
    </div>
</div>    


{{-- <script>
var demand_rates = {
@foreach ($demand_types as $c)
    "{{$c->id}}": { "demand_id": "{{ $c->id }}", "rate": "{{ $c->rate }}" }, 
@endforeach
};
$('#demand_rates').val(JSON.stringify(demand_rates))
console.log($('#demand_rates').val())

$('.demand_rate').keyup(function() {
    var demand_id = $(this).data('id');
    demand_rates[demand_id].rate = $(this).val();
    $('#demand_rates').val(JSON.stringify(demand_rates));
})

</script> --}}