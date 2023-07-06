<table>
    <tr class="text-center">
        <th></th>
        <th>Flight 0</th>
        <th>Flight 1</th>
        <th>Flight 2</th>
        <th>Flight 3</th>
        <th>Flight 4</th>
        <th>Flight 5</th>
        <th>Flight 6</th>
    </tr>
    <tr>
        <td><strong>MIN</strong></td>
        @if ($extra_min_times != [])
        <td><input class="form-control" min=0 type="number" name="w_time_0_min[{{$i}}]" id="w_time_0_min_{{$i}}"
                value="{{$extra_min_times[0][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_1_min[{{$i}}]" id="w_time_1_min_{{$i}}"
                value="{{$extra_min_times[1][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_2_min[{{$i}}]" id="w_time_2_min_{{$i}}"
                value="{{$extra_min_times[2][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_3_min[{{$i}}]" id="w_time_3_min_{{$i}}"
                value="{{$extra_min_times[3][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_4_min[{{$i}}]" id="w_time_4_min_{{$i}}"
                value="{{$extra_min_times[4][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_5_min[{{$i}}]" id="w_time_5_min_{{$i}}"
                value="{{$extra_min_times[5][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_6_min[{{$i}}]" id="w_time_6_min_{{$i}}"
                value="{{$extra_min_times[6][$i]}}" step="0.01"></td>
        @else
        <td><input class="form-control" min=0 type="number" name="w_time_0_min[{{$i}}]" id="w_time_0_min_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_1_min[{{$i}}]" id="w_time_1_min_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_2_min[{{$i}}]" id="w_time_2_min_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_3_min[{{$i}}]" id="w_time_3_min_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_4_min[{{$i}}]" id="w_time_4_min_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_5_min[{{$i}}]" id="w_time_5_min_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_6_min[{{$i}}]" id="w_time_6_min_{{$i}}"
                value="0" step="0.01"></td>
        @endif
    </tr>
    <tr>
        <td><strong>MED</strong></td>
        @if ($extra_med_times != [])
        <td><input class="form-control" min=0 type="number" name="w_time_0_med[{{$i}}]" id="w_time_0_med_{{$i}}"
                value="{{$extra_med_times[0][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_1_med[{{$i}}]" id="w_time_1_med_{{$i}}"
                value="{{$extra_med_times[1][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_2_med[{{$i}}]" id="w_time_2_med_{{$i}}"
                value="{{$extra_med_times[2][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_3_med[{{$i}}]" id="w_time_3_med_{{$i}}"
                value="{{$extra_med_times[3][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_4_med[{{$i}}]" id="w_time_4_med_{{$i}}"
                value="{{$extra_med_times[4][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_5_med[{{$i}}]" id="w_time_5_med_{{$i}}"
                value="{{$extra_med_times[5][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_6_med[{{$i}}]" id="w_time_6_med_{{$i}}"
                value="{{$extra_med_times[6][$i]}}" step="0.01"></td>
        @else
        <td><input class="form-control" min=0 type="number" name="w_time_0_med[{{$i}}]" id="w_time_0_med_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_1_med[{{$i}}]" id="w_time_1_med_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_2_med[{{$i}}]" id="w_time_2_med_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_3_med[{{$i}}]" id="w_time_3_med_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_4_med[{{$i}}]" id="w_time_4_med_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_5_med[{{$i}}]" id="w_time_5_med_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_6_med[{{$i}}]" id="w_time_6_med_{{$i}}"
                value="0" step="0.01"></td>
        @endif
        </tr>
    <tr>
        <td><strong>MAX</strong></td>
        @if ($extra_max_times != [])
        <td><input class="form-control" min=0 type="number" name="w_time_0_max[{{$i}}]" id="w_time_0_max_{{$i}}"
                value="{{$extra_max_times[0][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_1_max[{{$i}}]" id="w_time_1_max_{{$i}}"
                value="{{$extra_max_times[1][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_2_max[{{$i}}]" id="w_time_2_max_{{$i}}"
                value="{{$extra_max_times[2][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_3_max[{{$i}}]" id="w_time_3_max_{{$i}}"
                value="{{$extra_max_times[3][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_4_max[{{$i}}]" id="w_time_4_max_{{$i}}"
                value="{{$extra_max_times[4][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_5_max[{{$i}}]" id="w_time_5_max_{{$i}}"
                value="{{$extra_max_times[5][$i]}}" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_6_max[{{$i}}]" id="w_time_6_max_{{$i}}"
                value="{{$extra_max_times[6][$i]}}" step="0.01"></td>
        @else
        <td><input class="form-control" min=0 type="number" name="w_time_0_max[{{$i}}]" id="w_time_0_max_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_1_max[{{$i}}]" id="w_time_1_max_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_2_max[{{$i}}]" id="w_time_2_max_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_3_max[{{$i}}]" id="w_time_3_max_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_4_max[{{$i}}]" id="w_time_4_max_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_5_max[{{$i}}]" id="w_time_5_max_{{$i}}"
                value="0" step="0.01"></td>
        <td><input class="form-control" min=0 type="number" name="w_time_6_max[{{$i}}]" id="w_time_6_max_{{$i}}"
                value="0" step="0.01"></td>
        @endif
    </tr>
</table>