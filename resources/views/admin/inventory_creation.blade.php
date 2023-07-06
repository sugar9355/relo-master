@extends('admin.layout.base')

@section('title', 'Inventory Creation')

@section('styles')
<style>
    strong {
        font-size: 15px;
        letter-spacing: 0.2px;
    }
</style>
@endsection

@section('content')
<div class="card-group-control card-group-control-right" id="accordion">
    <div class="card border-dark">
        <div class="card-header bg-dark">
            <h6 class="card-title">
                <a data-toggle="collapse" class="text-white" href="#accordion-control">Inventory Item</a>
            </h6>
        </div>

        <div id="accordion-control" class="collapse show" data-parent="#accordion">
            <div class="card-body">
                <form class="form-horizontal" action="{{route('admin.inventory_creation')}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
                <div> 
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group col-md-12">
                      <label><strong>How Heavy is Your Item</strong></label>
                    </div>
                    
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-6">
                         <div class="form-group col-md-12">
                          <label><strong>Min</strong></label>
                        </div>
                         </div>
                    <div class="col-md-6">
                       <div class="form-group col-md-12">
                      <label><strong>Max</strong></label>
                    </div>
                    </div>
                    </div>
                    
                    
                  </div>
                  <div class="col-md-4">
                    <div class="form-group col-md-12">
                      <label><strong>Category</strong></label>
                    </div>
                  </div>
                </div>
                @foreach ($item_wieght as $weight)
                <div class="row">
                  <div class="col-md-4">
                    <input hidden name="weightid[]" value="{{$weight->id}}">
                     <div class="form-group col-md-12">
                            <input class="form-control" name="item_name[]"  type="" value="{{$weight->name}}" />
                        </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-6">
                         <div class="form-group col-md-12">
                            <input class="form-control" name="min[]"  type="number" value="{{$weight->min}}" />
                        </div>
                      </div>
                    <div class="col-md-6">
                       <div class="form-group col-md-12">
                            <input class="form-control" name="max[]"  type="number" value="{{$weight->max}}"/>
                        </div>
                    </div>
                    </div>
                     </div>
                  <div class="col-md-4">
                    <select name="categories[{{$weight->id}}][]" required id="wcategories{{$weight->id}}" class="form-control select" multiple >
                                @foreach ($categories as $p)
                                <option value="{{$p->id}}">{{$p->name}}</option>
                                @endforeach
                            </select>
                  </div>
                </div>
                @endforeach
                </div>

                <!-- how big it is -->
                <hr>
                <div> 
                <div class="row">
                  <div class=" form-group col-md-4">
                     <div class="form-group col-md-12">
                    <label><strong>How Big is Your Item</strong></label>
                  </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="form-group col-md-6">
                         <div class="form-group col-md-12"><label><strong>Min Volume</strong></label>
                         </div></div>
                    <div class="form-group col-md-6">
                       <div class="form-group col-md-12"><label><strong>Max Volume</strong></label>
                       </div></div>
                    </div>
                    
                    
                  </div>
                  <div class="col-md-4">
                    
                  </div>
                </div>
                @foreach ($item_dimension as $dimension)
                <div class="row">
                  <div class="col-md-4">
                    <input hidden  name="dimensionid[]" value="{{$dimension->id}}">
                     <div class="form-group col-md-12">
                            <input class="form-control" name="item_name_big[]"  type="" value="{{$dimension->name}}" />
                        </div>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-6">
                         <div class="form-group col-md-12">
                            <input class="form-control" name="length[]"  type="number" value="{{$dimension->length}}" />
                        </div>
                      </div>
                    <div class="col-md-6">
                       <div class="form-group col-md-12">
                            <input class="form-control" name="height[]"  type="number" value="{{$dimension->height}}" />
                        </div>
                    </div>
                    </div>
                     </div>
                  <div class="col-md-4">
                    <select name="categories_big[{{$dimension->id}}][]" required id="categoriesbig{{$dimension->id}}" class="form-control select" multiple >
                                @foreach ($categories as $p)
                                <option value="{{$p->id}}">{{$p->name}}</option>
                                @endforeach
                            </select>
                  </div>
                </div>
                @endforeach
                </div>
                <div class="form-group">
                    <div class="col-md-10">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<!-- Theme JS files -->    
<script src="{{asset('assets_admin/js/demo_pages/form_select2.js')}}"></script>

<!-- /theme JS files -->
 @foreach ($item_dimension as $dimension)
<script>
  $('#categoriesbig{{$dimension->id}}').select2({});
  var dimensions = "{{$dimension->category_json}}";
  console.log(dimensions.replace(/&quot;/g,'"'));
  $("#categoriesbig{{$dimension->id}}").val(JSON.parse(dimensions.replace(/&quot;/g,'"')));
</script>
@endforeach

@foreach ($item_wieght as $weight)
<script>
 $('#wcategories{{$weight->id}}').select2({});
  var weightcate = "{{$weight->category_json}}";
  console.log(weightcate.replace(/&quot;/g,'"'));
  $("#wcategories{{$weight->id}}").val(JSON.parse(weightcate.replace(/&quot;/g,'"')));
</script>
@endforeach
@endsection
