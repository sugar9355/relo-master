
    <!-- Modal content-->
    <div class="modal-content  modal-lg">
      <div class="modal-header">
      <h4 class="modal-title">@if(isset($employee->role_name)) {{$employee->role_name}} @endif Badges Details</h4>
      </div>
      <div class="modal-body">
      {{--
        <table class="table table-bordered" >
        <thead> <tr>
            
            <td><strong>Badges</strong></td>
            <td><strong>level</strong></td>
            <td><strong>hours</strong></td>
        </tr></thead>
        <tbody>
    
            <tr>
                <td>@if(isset($badges->name)) {{$badges->name}} @endif</td>
                <td>@if(isset($employee_level)) {{$employee_level}} @endif</td>
                <td>@if(isset($hours)) {{$hours}} hours @endif</td>
                
            </tr>
            
        </tbody>
        </table>
      --}}
        <table class="table table-bordered" >
        <thead> <tr>
            <th class="text-center" ><strong>No</strong></th>
            <th class="text-center" ><strong>Badges</strong></th>
            <th class="text-center" ><strong>Assigned</strong></th>
            <th class="text-center" ><strong>Bonus</strong></th>
            <th class="text-center" ><strong>level</strong></th>
            <th class="text-center" ><strong>hours</strong></th>
            <th class="text-center" width="30%"><strong>Assign Badge</strong></th>
        </tr></thead>
        <tbody>
        @if(!empty($level))
        @foreach($available_badges as $k => $lvl)
            <tr>
                <td class="text-center" >{{$k+1}}</td>
                <td> 
                    <a href="#" data-toggle="tooltip" data-placement="right" title="{{isset($lvl->description) ? $lvl->description : null}}">{{$lvl->name}}</a>
                </td>
                <td class="text-center" >
                    @if(!empty($my_badges))
                        @foreach($my_badges as $my_badge)
                            @if($my_badge->badge_name == $lvl->name) 
                                <font color="green" size="3"> ( &#x2714; )</font>
                            @endif 
                        @endforeach
                    @endif
                </td>
                <td class="text-center" >{{$lvl->bouns }}</td>
                <td class="text-center" >
                {{-- @if(!empty($lvl->level))
                    {{$lvl->level}} 
                    @foreach($my_badges as $my_badge)
                        @if($my_badge->level == $lvl->level) 
                            <font color="green" size="3"> ( &#x2714; )</font>
                        @endif 
                    @endforeach
                    
                @else
                    <font color="red">---</font>
                @endif
                </td> --}}
                </td>
                <td></td>
                {{-- <td class="text-center" >
                @if(!empty($lvl->hours))
                    {{$lvl->hours}} 
                @else
                    <font color="red">---</font>
                @endif
                </td> --}}
                <td class="text-center" width="30%">
                
                    <form class="form-horizontal" action="{{route('admin.provider.update', $employee->id )}}" method="POST" enctype="multipart/form-data" role="form">
                    
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="id" value="{{$lvl->id}} ">
                        <button type="submit" name="update_badge" class="btn btn-success" value="true">Assign</button>
                        <button type="submit" name="delete_badge" class="btn btn-danger" value="true">UnAssign</button>
                        
                    </form>
                    
                </td>
                
            </tr>
        @endforeach
        @endif
        </tbody>
        </table>
      </div>
    
    </div>

<script type="text/javascript">

    @if(isset($model_open) && $model_open == true) 
        $(function () {$("#badges").modal("show");});
    @endif
    
</script>