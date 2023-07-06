<div id="ranking_item" class="card">
	<div class="card-header bg-dark text-white header-elements-inline">
		<h6 class="card-title">Tools Required to Move item</h6>
		<div class="header-elements">
			<div class="list-icons">
				<div class="form-check form-check-switch form-check-switch-left">
					<label class="form-check-label d-flex align-items-center">
						<input name="disassembly" type="checkbox" data-action="collapse" data-on-color="success"
							data-off-color="danger" data-on-text="Enable" data-off-text="Disable"
							class="form-check-input-switch" checked>
					</label>
				</div>
			</div>
		</div>
	</div>

	<div class="card-body">



		<div class="form-group">

			<table>
				<tr class="text-center">
					<label for="" class="col-form-label">Ranking for disassembly on the inventory level</label>
				</tr>
				<tr class="text-center">
					<label for="" class="col-form-label">Time Required for disassembly on the selected inventory level ?
					</label>
				</tr>

				@if(isset($ranking) && !empty($ranking))

				@foreach($ranking as $key => $val)
				<tr>
					<th class="text-left">{{$val->alphabet}} - {{$val->ranking_name}}</th>
					<td><input class="form-control" type="number" name="R_{{$val->alphabet}}"
							id="R_{{$val->alphabet}}" placeholder="" value="" step="0.01"></td>
				</tr>
				@endforeach

				@endif

			</table>

		</div>



	</div>
</div>
@foreach ($categories as $category)
<div id="ranking_{{$category->id}}" class="card" style="display: none;">
	<div class="card-header bg-dark text-white header-elements-inline">
		<h6 class="card-title">Tools Required to Move item</h6>
		<div class="header-elements">
			<div class="list-icons">
				<div class="form-check form-check-switch form-check-switch-left">
					<label class="form-check-label d-flex align-items-center">
						<input name="disassembly" type="checkbox" data-action="collapse" data-on-color="success"
							data-off-color="danger" data-on-text="Enable" data-off-text="Disable"
							class="form-check-input-switch" checked>
					</label>
				</div>
			</div>
		</div>
	</div>

	<div class="card-body">
		<div class="form-group">

			<table>
				<tr class="text-center">
					<label for="" class="col-form-label">Ranking for disassembly on the inventory level</label>
				</tr>
				<tr class="text-center">
					<label for="" class="col-form-label">Time Required for disassembly on the selected inventory level ?
					</label>
				</tr>

				@if(isset($ranking) && !empty($ranking))

				@foreach($ranking as $key => $val)
				<tr>
					<th class="text-left">{{$val->alphabet}} - {{$val->ranking_name}}</th>
				<td><input class="form-control" type="number" name="R_{{$val->alphabet}}[{{$category->id}}]" id="R_{{$val->alphabet}}" placeholder="" value="{{json_decode(json_encode($category), true)['R_' . $val->alphabet]}}" step="0.01"></td>
				</tr>
				@endforeach

				@endif

			</table>

		</div>



	</div>
</div>

@endforeach

@for ($i = 2; $i <= 4; $i++)
<div id="ranking_item_{{$i}}" style="display: none">
	<div class="card-header bg-dark text-white header-elements-inline">
		<h6 class="card-title">Tools Required to Move item</h6>
		<div class="header-elements">
			<div class="list-icons">
				<div class="form-check form-check-switch form-check-switch-left">
					<label class="form-check-label d-flex align-items-center">
						<input name="disassembly" type="checkbox" data-action="collapse" data-on-color="success" data-off-color="danger" data-on-text="Enable" data-off-text="Disable" class="form-check-input-switch" checked>
					</label>
				</div>
			</div>
		</div>
	</div>

	<div class="card-body">
		<div class="form-group">
			<table>
				<tr class="text-center">
					<label for="" class="col-form-label">Ranking for disassembly on the inventory level</label>
				</tr>
				<tr class="text-center">
					<label for="" class="col-form-label">Time Required for disassembly on the selected inventory level ?</label>
				</tr>
				@if(isset($ranking) && !empty($ranking))
				@foreach($ranking as $key => $val)
				<tr>
					<th class="text-left">{{$val->alphabet}} - {{$val->ranking_name}}</th>
					<td><input class="form-control" type="number" name="w_R_{{$val->alphabet}}[{{$i}}]" id="R_{{$val->alphabet}}_{{$i}}" placeholder="" value="0" step="0.01"></td>
				</tr>
				@endforeach
				@endif
			</table>
		</div>
	</div>
</div>
@endfor