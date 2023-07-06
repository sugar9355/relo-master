@php $limit_execeed = false; @endphp
    <div class="col-md-12 mt-4">
    
        @foreach($booking_form_truck as $truck)
        
        <div class="row">
            {{-- <div class="col-md-3 pr-0">
                <div class="card bg-transparent">
                
                @php $items_volume = 0; @endphp
                
                @foreach($selected_items as $added_item) 
                    @if($added_item->truck_id == $truck->truck_id)
                    
                    @if($added_item->quantity > 0)
                        @php $items_volume = $items_volume + ($added_item->volume * $added_item->quantity); @endphp 
                    @else
                        @php $items_volume = $items_volume + $added_item->volume; @endphp 
                    @endif
                        
                    @endif
                @endforeach                 
                 
                @if($truck->status == 1 && round(($items_volume/$truck->truck_volume)* 100) > 80)
                    @php $limit_execeed = true; @endphp
                @endif 
                     <div class="card-header">
                        <h6 class="m-0" data-toggle="modal" data-target="#truck_{{$truck->id}}">Truck Capacity    {{$truck->volume}} {{$truck->truck_volume}} - {{$items_volume}}</h6>
                        
                        <!-- Modal -->
                        <div id="truck_{{$truck->id}}" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Modal Header</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                              <table class="table table-striped">
                              
                              <tr><td>Name </td><td> {{$truck->name}}</td></tr>
                              <tr><td>Type </td><td> {{$truck->type}}</td></tr>
                              <tr><td>color </td><td> {{$truck->color}}</td></tr> 
                              <tr><td>fuel_volume </td><td> {{$truck->fuel_volume}}</td></tr>
                              <tr><td>year </td><td> {{$truck->year}}</td></tr>
                              <tr><td>reg_no </td><td> {{$truck->reg_no}}</td></tr>
                              <tr><td>fuel_type </td><td> {{$truck->fuel_type}}</td></tr>
                              <tr><td>weight </td><td> {{$truck->weight}}</td></tr>
                              <tr><td>height </td><td> {{$truck->height}}</td></tr> 
                              <tr><td>breadth </td><td> {{$truck->breadth}}</td></tr> 
                              <tr><td>volume </td><td> {{$truck->volume}}</td></tr> 
                              <tr><td>mileage </td><td> {{$truck->mileage}}</td></tr> 
                              <tr><td>threshold </td><td> {{$truck->threshold}}</td> </tr> 
                              
                                </table>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>

                          </div>
                        </div>
                        
                    </div>
                     <div class="card-body pt-3 border-top mx-1">
                        <div class="row">
                            <div class="col-md-12 pt-2 mt-1 pl-2">                                
                                <div class="progress h-100">
                                  <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark py-3" style="width:{{round(($items_volume/$truck->truck_volume)* 100)}}%;" role="progressbar" aria-valuenow="{{round(($items_volume/$truck->truck_volume)* 100)}}" aria-valuemin="0" aria-valuemax="100">{{round(($items_volume/$truck->truck_volume)* 100)}}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
                
                                
                
            </div> --}}
            <div class="col-md-12 nopad pl-4">
                <div class="card">
                    <div class="card-header form-inline">
                        
                        @if($limit_execeed == true)
                        <h6 class="card-title m-0 col-md-4">Selected Items </h6>
        
                        
                        <div class="col-md-4 text-right">
                            {{-- <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#newtruck">Get New Truck</button> --}}
                            @include('booking.inventory.truck')
                        </div>
                        @else
                        <h6 class="card-title m-0 col-md-10">Selected Items</h6>
                        @endif
                        
                        
                    </div>
                    <div class="card card-body">
                    <ul class="nav nav-pills flex-column category-menu">
            
                <li><a href="#" class="nav-link d-flex align-items-center justify-content-between">Items</a>
                  <ul>
                        @include('booking.inventory.mob_selected_item_grid')
                        </ul>
                       
                  </li>
                  </ul>
                    
                    </div>
                </div>
            </div>            
        </div>
        
        @endforeach
        
    </div>
    