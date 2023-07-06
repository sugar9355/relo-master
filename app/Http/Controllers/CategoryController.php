<?php
namespace App\Http\Controllers;

use DB;
use App\Category;
use App\Helpers\Helper;
use App\Inventory;
use App\Material;
use App\Flag;
use App\ShuffleFee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    public function __construct()
    {
        if (!Helper::authorized('item_categories')){
            return abort(404);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $items = Inventory::get();
        $ranking = Inventory::GetRanking();
        $equipments = Inventory::GetInventoryEquipment();
        $flags_temp = Flag::get();
        $flags = [];
        foreach ($flags_temp as $f) {
            if (in_array('items', explode(',', $f->conditions))) {
                array_push($flags, $f);
            }
        }

        $max_num_flights = 7;
        $max_num_floors = 7;

        $materials = Material::orderBy('created_at', 'desc')->get();

        // Charges per cb ft from shuffle fees
        $charge_cb_ft = ShuffleFee::first()->charge_cb_ft;
        $categories = Category::orderBy('created_at', 'desc')->get();

        return view('admin.category.create', compact('items', 'equipments', 'ranking', 'flags', 'max_num_flights', 'max_num_floors', 'materials', 'charge_cb_ft', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        $category['name'] = $request->get('name');

        $category['hoisting'] = $request->get('hoisting');
        $category['ranking_id'] = $request->get('ranking');
        $category['ranking_time'] = $request->get('ranking_time');
        $category['material'] = $request->get('material');
        $category['storage_price'] = $request->get('storage_price');
        $category['weight_min'] = $request->get('weight_min');
        $category['junk_price_min'] = $request->get('junk_price_min');
        $category['weight_max'] = $request->get('weight_max');
        $category['junk_price_max'] = $request->get('junk_price_max');
        $category['width'] = $request->get('width');
        $category['height'] = $request->get('height');
        $category['breadth'] = $request->get('breadth');
        $category['volume'] = $request->get('volume');
        $category['multiplier'] = $request->get('multiplier');
        $category['packing_volume'] = $request->get('packing_volume');

        $category['wrapping_material'] = $request->get('wrapping_material');
        $category['wrapping_qty'] = $request->get('wrapping_qty');
        $category['wrapping_time'] = $request->get('wrapping_time');
        $category['wrapping_price'] = $request->get('wrapping_price');

        if (isset($request->stackable)) {
            $category['stackable'] = 1;
            $category['stackable_multiplier'] = $request->stackable_multiplier;
        } else {
            $category['stackable'] = 0;
        }

        if (!empty($request->equipment)) {
            $category['equipments'] = implode(',',$request->get('equipment'));
        }

        $category['flag'] = isset($request->flag) ? $request->flag : null;

        $category_id = Category::save_category($category);

        for ($i = 1; $i <= 4; $i++) {
            if (isset($request->check_num_workers[$i])) {
                foreach ($request->flights_min[$i] as $k => $min_times) {
                    foreach ($min_times as $l => $min_time) {
                        DB::table('category_time_flights')->insert([
                            'category_id' => $category_id,
                            'num_worker' => $i,
                            'num_flights' => $k,
                            'location_type' => $l,
                            'time_min' => $min_time,
                            'time_med' => $request->flights_med[$i][$k][$l],
                            'time_max' => $request->flights_max[$i][$k][$l],
                        ]);
                    }
                }
    
                foreach ($request->passenger_time[$i] as $k => $passenger_times) {
                    foreach ($passenger_times as $l => $passenger_time) {
                        DB::table('category_time_elevator')->insert([
                            'category_id' => $category_id,
                            'num_worker' => $i,
                            'num_floor' => $k,
                            'location_type' => $l,
                            'passenger_time' => $passenger_time,
                            'passenger_delay' => $request->passenger_delay[$i][$k][$l],
                        ]);
                    }
                }
    
                foreach ($request->freight_time[$i] as $k => $freight_times) {
                    foreach ($freight_times as $l => $freight_time) {
                        $temp = DB::table('category_time_elevator')->where([
                            'category_id' => $category_id,
                            'num_worker' => $i,
                            'num_floor' => $k,
                            'location_type' => $l
                        ])->get();
                        if ($temp != null) {
                            DB::table('category_time_elevator')->where([
                                'category_id' => $category_id,
                                'num_worker' => $i,
                                'num_floor' => $k,
                                'location_type' => $l
                            ])->update([
                                'freight_time' => $freight_time,
                                'freight_delay' => $request->freight_delay[$i][$k][$l],
                            ]);
                        } else {
                            DB::table('category_time_elevator')->insert([
                                'category_id' => $category_id,
                                'num_worker' => $i,
                                'num_floor' => $k,
                                'location_type' => $l,
                                'freight_time' => $freight_time,
                                'freight_delay' => $request->freight_delay[$i][$k][$l],
                            ]);
                        }
                    }
                }
    
                foreach ($request->rs_freight_time[$i] as $k => $rs_freight_times) {
                    foreach ($rs_freight_times as $l => $rs_freight_time) {
                        $temp = DB::table('category_time_elevator')->where([
                            'category_id' => $category_id,
                            'num_worker' => $i,
                            'num_floor' => $k,
                            'location_type' => $l
                        ])->get();
                        if ($temp != null) {
                            DB::table('category_time_elevator')->where([
                                'category_id' => $category_id,
                                'num_worker' => $i,
                                'num_floor' => $k,
                                'location_type' => $l
                            ])->update([
                                'rs_freight_time' => $rs_freight_time,
                                'rs_freight_delay' => $request->rs_freight_delay[$i][$k][$l],
                            ]);
                        } else {
                            DB::table('category_time_elevator')->insert([
                                'category_id' => $category_id,
                                'num_worker' => $i,
                                'num_floor' => $k,
                                'location_type' => $l,
                                'rs_freight_time' => $rs_freight_time,
                                'rs_freight_delay' => $request->rs_freight_delay[$i][$k][$l],
                            ]);
                        }
                    }
                }
    
                DB::table('category_stair_time_factor')->insert([
                    'category_id' => $category_id,
                    'num_worker' => $i,
                    'windy' => $request->stair_time_windy[$i],
                    'narrow' => $request->stair_time_narrow[$i],
                    'wide' => $request->stair_time_wide[$i],
                    'spiral' => $request->stair_time_spiral[$i],
                ]);
    
                foreach ($request->groundfloor_min[$i] as $k => $groundfloor_mins) {
                    foreach ($groundfloor_mins as $l => $groundfloor_min) {
                        DB::table('category_time_extra')->insert([
                            'category_id' => $category_id,
                            'num_worker' => $i,
                            'num_stairs' => $k,
                            'location_type' => $l,
                            'groundfloor_min' => isset($request->groundfloor_min[$i][$k][$l]) ? $request->groundfloor_min[$i][$k][$l] : 0,
                            'groundfloor_med' => isset($request->groundfloor_med[$i][$k][$l]) ? $request->groundfloor_med[$i][$k][$l] : 0,
                            'groundfloor_max' => isset($request->groundfloor_max[$i][$k][$l]) ? $request->groundfloor_max[$i][$k][$l] : 0,
                            'bulkhead_min' => isset($request->bulkhead_min[$i][$k][$l]) ? $request->bulkhead_min[$i][$k][$l] : 0,
                            'bulkhead_med' => isset($request->bulkhead_med[$i][$k][$l]) ? $request->bulkhead_med[$i][$k][$l] : 0,
                            'bulkhead_max' => isset($request->bulkhead_max[$i][$k][$l]) ? $request->bulkhead_max[$i][$k][$l] : 0,
                            'en_steps_min' => isset($request->en_steps_min[$i][$k][$l]) ? $request->en_steps_min[$i][$k][$l] : 0,
                            'en_steps_med' => isset($request->en_steps_med[$i][$k][$l]) ? $request->en_steps_med[$i][$k][$l] : 0,
                            'en_steps_max' => isset($request->en_steps_max[$i][$k][$l]) ? $request->en_steps_max[$i][$k][$l] : 0,
                        ]);
                    }
                }
            }
        }

        if($request->disassembly == true)
        {
            for ($i = 1; $i <= 4; $i++) {
                if (isset($request->check_num_workers[$i])) {
                    DB::table('category_dis_assembly')->insert([
                        'category_id' => $category_id,
                        'num_worker' => $i,
                        'R_A' => $request->R_A[$i],
                        'R_B' => $request->R_B[$i],
                        'R_C' => $request->R_C[$i],
                        'R_D' => $request->R_D[$i],
                        'R_E' => $request->R_E[$i],
                    ]);
                }
            }
        }

        if (isset($request->flag)) {
            $flag_categories = Flag::where([
                'id' => $request->flag
            ])->select('categories')->first()['categories'];
            $flag_categories .= ',' . $category_id;
            Flag::where([
                'id' => $request->flag
            ])->update([
                'categories' => $flag_categories
            ]);
        }

        if (isset($request->question)) {
            foreach ($request->question as $k => $question) {
                if (isset($request->question_allow[$k])) {
                    $questions[$k]['category_id'] = $category_id;
                    $questions[$k]['title'] = $question;
                    $questions[$k]['allow'] = true;
                } else {
                    $questions[$k]['category_id'] = $category_id;
                    $questions[$k]['title'] = $question;
                    $questions[$k]['allow'] = false;
                }
            }
            Category::AddQuestion($questions);
        }

        if (isset($request->sh_flights)) {
            foreach($request->sh_flights as $l => $sh_flight) {
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'flight',
                    'num_flights' => $l,
                    'location_type' => 0,
                    'mul_value' => $sh_flight[0]
                ));
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'flight',
                    'num_flights' => $l,
                    'location_type' => 1,
                    'mul_value' => $sh_flight[1]
                ));
            }
        }

        if (isset($request->sh_freight)) {
            foreach($request->sh_freight as $l => $sh_freight) {
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'freight',
                    'num_floor' => $l,
                    'location_type' => 0,
                    'mul_value' => $sh_freight[0]
                ));
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'freight',
                    'num_floor' => $l,
                    'location_type' => 1,
                    'mul_value' => $sh_freight[1]
                ));
            }
        }

        if (isset($request->sh_rs_freight)) {
            foreach($request->sh_rs_freight as $l => $sh_rs_freight) {
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'rs_freight',
                    'num_floor' => $l,
                    'location_type' => 0,
                    'mul_value' => $sh_rs_freight[0]
                ));
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'rs_freight',
                    'num_floor' => $l,
                    'location_type' => 1,
                    'mul_value' => $sh_rs_freight[1]
                ));
            }
        }

        if (isset($request->sh_passenger)) {
            foreach($request->sh_passenger as $l => $sh_passenger) {
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'passenger',
                    'num_floor' => $l,
                    'location_type' => 0,
                    'mul_value' => $sh_passenger[0]
                ));
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'passenger',
                    'num_floor' => $l,
                    'location_type' => 1,
                    'mul_value' => $sh_passenger[1]
                ));
            }
        }

        DB::commit();

        return redirect()->to(route('admin.category.index'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function edit(Category $category)
    {
        $category = Category::find($category->id);
        $ranking = Inventory::GetRanking();
        $equipments = Inventory::GetInventoryEquipment();
        $category_questions = Category::GetCategoryQuestion($category->id);
        $flags_temp = Flag::get();
        $flags = [];
        foreach ($flags_temp as $f) {
            if (in_array('items', explode(',', $f->conditions))) {
                array_push($flags, $f);
            }
        }

        $flights_time_temp = DB::table('category_time_flights')->where([
            'category_id' => $category->id
        ])->get();
        $elevator_time_temp = DB::table('category_time_elevator')->where([
            'category_id' => $category->id
        ])->get();
        $dis_assembly_temp = DB::table('category_dis_assembly')->where([
            'category_id' => $category->id
        ])->get();
        $stair_time_temp = DB::table('category_stair_time_factor')->where([
            'category_id' => $category->id
        ])->get();
        $extra_time_temp = DB::table('category_time_extra')->where([
            'category_id' => $category->id
        ])->get();

        $flights_min = array();
        $flights_med = array();
        $flights_max = array();
        $num_flights = DB::table('category_time_flights')->where([
            'category_id' => $category->id
        ])->max('num_flights');
        foreach ($flights_time_temp as $item) {
            $flights_min[$item->num_worker][$item->num_flights][$item->location_type] = $item->time_min;
            $flights_med[$item->num_worker][$item->num_flights][$item->location_type] = $item->time_med;
            $flights_max[$item->num_worker][$item->num_flights][$item->location_type] = $item->time_max;
        }

        $passenger_time = array();
        $passenger_delay = array();
        $freight_time = array();
        $freight_delay = array();
        $rs_freight_time = array();
        $rs_freight_delay = array();
        $num_floors = DB::table('category_time_elevator')->where([
            'category_id' => $category->id
        ])->max('num_floor');
        foreach ($elevator_time_temp as $item) {
            if (isset($item->passenger_time)) {
                $passenger_time[$item->num_worker][$item->num_floor][$item->location_type] = $item->passenger_time;
                $passenger_delay[$item->num_worker][$item->num_floor][$item->location_type] = $item->passenger_delay;
            }
            if (isset($item->freight_time)) {
                $freight_time[$item->num_worker][$item->num_floor][$item->location_type] = $item->freight_time;
                $freight_delay[$item->num_worker][$item->num_floor][$item->location_type] = $item->freight_delay;
            }
            if (isset($item->rs_freight_time)) {
                $rs_freight_time[$item->num_worker][$item->num_floor][$item->location_type] = $item->rs_freight_time;
                $rs_freight_delay[$item->num_worker][$item->num_floor][$item->location_type] = $item->rs_freight_delay;
            }
            
        }

        $groundfloor_min = array();
        $groundfloor_med = array();
        $groundfloor_max = array();
        $bulkhead_min = array();
        $bulkhead_med = array();
        $bulkhead_max = array();
        $en_steps_min = array();
        $en_steps_med = array();
        $en_steps_max = array();
        foreach ($extra_time_temp as $item) {
            $groundfloor_min[$item->num_worker][$item->num_stairs][$item->location_type] = $item->groundfloor_min;
            $groundfloor_med[$item->num_worker][$item->num_stairs][$item->location_type] = $item->groundfloor_med;
            $groundfloor_max[$item->num_worker][$item->num_stairs][$item->location_type] = $item->groundfloor_max;
            $bulkhead_min[$item->num_worker][$item->num_stairs][$item->location_type] = $item->bulkhead_min;
            $bulkhead_med[$item->num_worker][$item->num_stairs][$item->location_type] = $item->bulkhead_med;
            $bulkhead_max[$item->num_worker][$item->num_stairs][$item->location_type] = $item->bulkhead_max;
            $en_steps_min[$item->num_worker][$item->num_stairs][$item->location_type] = $item->en_steps_min;
            $en_steps_med[$item->num_worker][$item->num_stairs][$item->location_type] = $item->en_steps_med;
            $en_steps_max[$item->num_worker][$item->num_stairs][$item->location_type] = $item->en_steps_max;
        }

        $R = array();
        foreach ($dis_assembly_temp as $item) {
            $R['A'][$item->num_worker] = $item->R_A;
            $R['B'][$item->num_worker] = $item->R_B;
            $R['C'][$item->num_worker] = $item->R_C;
            $R['D'][$item->num_worker] = $item->R_D;
            $R['E'][$item->num_worker] = $item->R_E;
        }

        $stair_time_windy = array();
        $stair_time_narrow = array();
        $stair_time_wide = array();
        $stair_time_spiral = array();
        foreach ($stair_time_temp as $item) {
            $stair_time_windy[$item->num_worker] = $item->windy;
            $stair_time_narrow[$item->num_worker] = $item->narrow;
            $stair_time_wide[$item->num_worker] = $item->wide;
            $stair_time_spiral[$item->num_worker] = $item->spiral;
        }
        $max_num_flights = (isset($num_flights)) ? $num_flights : 7;
        $max_num_floors = (isset($num_floors)) ? $num_floors : 7;

        $materials = Material::orderBy('created_at', 'desc')->get();

        // Shuffle Data
        $sh_flights = array();
        $sh_passenger = array();
        $sh_freight = array();
        $sh_rs_freight = array();
        $sh_data_temp = DB::table('category_shuffle_values')->where([
            'category_id' => $category->id
        ])->get();
        foreach($sh_data_temp as $item) {
            if (isset($item->num_flights) && $item->moving_type == 'flight') {
                $sh_flights[$item->num_flights][$item->location_type] = $item->mul_value;
            } elseif (isset($item->num_floor)) {
                if ($item->moving_type == 'passenger') {
                    $sh_passenger[$item->num_floor][$item->location_type] = $item->mul_value;
                } elseif ($item->moving_type == 'freight') {
                    $sh_freight[$item->num_floor][$item->location_type] = $item->mul_value;
                } elseif ($item->moving_type == 'rs_freight') {
                    $sh_rs_freight[$item->num_floor][$item->location_type] = $item->mul_value;
                }
            }
        }

        // Charges per cb ft from shuffle fees
        $charge_cb_ft = ShuffleFee::first()->charge_cb_ft;
        $categories = Category::orderBy('created_at', 'desc')->get();

        return view('admin.category.edit', compact('category', 'ranking', 'equipments', 'category_questions', 'flags', 'flights_min', 'flights_med', 'flights_max', 'passenger_time', 'passenger_delay', 'freight_time', 'freight_delay', 'rs_freight_time', 'rs_freight_delay', 'R', 'stair_time_windy', 'stair_time_narrow', 'stair_time_wide', 'stair_time_spiral', 'max_num_flights', 'max_num_floors', 'bulkhead_min', 'bulkhead_med', 'bulkhead_max', 'en_steps_min', 'en_steps_med', 'en_steps_max', 'groundfloor_min', 'groundfloor_med', 'groundfloor_max', 'materials', 'sh_flights', 'sh_passenger', 'sh_freight', 'sh_rs_freight', 'charge_cb_ft', 'categories'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    public function update(Request $request, Category $category)
    {
        // dd($request->all());
        $update['name'] = $request->get('name');
        
        $update['hoisting'] = $request->get('hoisting');
        $update['ranking_id'] = $request->get('ranking');
        $update['ranking_time'] = $request->get('ranking_time');
        $update['material'] = $request->get('material');
        $update['storage_price'] = $request->get('storage_price');
        $update['weight_min'] = $request->get('weight_min');
        $update['junk_price_min'] = $request->get('junk_price_min');
        $update['weight_max'] = $request->get('weight_max');
        $update['junk_price_max'] = $request->get('junk_price_max');
        $update['width'] = $request->get('width');
        $update['height'] = $request->get('height');
        $update['breadth'] = $request->get('breadth');
        $update['volume'] = $request->get('volume');
        $update['multiplier'] = $request->get('multiplier');
        $update['packing_volume'] = $request->get('packing_volume');

        $update['wrapping_material'] = $request->get('wrapping_material');
        $update['wrapping_qty'] = $request->get('wrapping_qty');
        $update['wrapping_price'] = $request->get('wrapping_price');
        $update['wrapping_time'] = $request->get('wrapping_time');

        if (isset($request->stackable)) {
            $update['stackable'] = 1;
            $update['stackable_multiplier'] = $request->stackable_multiplier;
        } else {
            $update['stackable'] = 0;
        }

        if(!empty($request->get('equipment'))) {
            $update['equipments'] = implode(',',$request->get('equipment'));
        }

        $update['flag'] = isset($request->flag) ? $request->flag : null;

        DB::table('category_time_flights')->where([
            'category_id' => $category->id
        ])->delete();
        DB::table('category_time_elevator')->where([
            'category_id' => $category->id
        ])->delete();
        DB::table('category_stair_time_factor')->where(['category_id' => $category->id])->delete();
        DB::table('category_time_extra')->where(['category_id' => $category->id])->delete();
        DB::table('category_shuffle_values')->where(['category_id' => $category->id])->delete();

        for ($i = 1; $i <= 4; $i++) {
            if (isset($request->check_num_workers[$i])) {
                foreach ($request->flights_min[$i] as $k => $min_times) {
                    foreach ($min_times as $l => $min_time) {
                        DB::table('category_time_flights')->insert([
                            'category_id' => $category->id,
                            'num_worker' => $i,
                            'num_flights' => $k,
                            'location_type' => $l,
                            'time_min' => $min_time,
                            'time_med' => $request->flights_med[$i][$k][$l],
                            'time_max' => $request->flights_max[$i][$k][$l],
                        ]);
                    }
                }
    
                foreach ($request->passenger_time[$i] as $k => $passenger_times) {
                    foreach ($passenger_times as $l => $passenger_time) {
                        DB::table('category_time_elevator')->insert([
                            'category_id' => $category->id,
                            'num_worker' => $i,
                            'num_floor' => $k,
                            'location_type' => $l,
                            'passenger_time' => $passenger_time,
                            'passenger_delay' => $request->passenger_delay[$i][$k][$l],
                        ]);
                    }
                }
    
                foreach ($request->freight_time[$i] as $k => $freight_times) {
                    foreach ($freight_times as $l => $freight_time) {
                        $temp = DB::table('category_time_elevator')->where([
                            'category_id' => $category->id,
                            'num_worker' => $i,
                            'num_floor' => $k,
                            'location_type' => $l
                        ])->get();
                        if ($temp != null) {
                            DB::table('category_time_elevator')->where([
                                'category_id' => $category->id,
                                'num_worker' => $i,
                                'num_floor' => $k,
                                'location_type' => $l
                            ])->update([
                                'freight_time' => $freight_time,
                                'freight_delay' => $request->freight_delay[$i][$k][$l],
                            ]);
                        } else {
                            DB::table('category_time_elevator')->insert([
                                'category_id' => $category->id,
                                'num_worker' => $i,
                                'num_floor' => $k,
                                'location_type' => $l,
                                'freight_time' => $freight_time,
                                'freight_delay' => $request->freight_delay[$i][$k][$l],
                            ]);
                        }
                    }
                }
    
                foreach ($request->rs_freight_time[$i] as $k => $rs_freight_times) {
                    foreach ($rs_freight_times as $l => $rs_freight_time) {
                        $temp = DB::table('category_time_elevator')->where([
                            'category_id' => $category->id,
                            'num_worker' => $i,
                            'num_floor' => $k,
                            'location_type' => $l
                        ])->get();
                        if ($temp != null) {
                            DB::table('category_time_elevator')->where([
                                'category_id' => $category->id,
                                'num_worker' => $i,
                                'num_floor' => $k,
                                'location_type' => $l
                            ])->update([
                                'rs_freight_time' => $rs_freight_time,
                                'rs_freight_delay' => $request->rs_freight_delay[$i][$k][$l],
                            ]);
                        } else {
                            DB::table('category_time_elevator')->insert([
                                'category_id' => $category->id,
                                'num_worker' => $i,
                                'num_floor' => $k,
                                'location_type' => $l,
                                'rs_freight_time' => $rs_freight_time,
                                'rs_freight_delay' => $request->rs_freight_delay[$i][$k][$l],
                            ]);
                        }
                    }
                }
    
                DB::table('category_stair_time_factor')->insert([
                    'category_id' => $category->id,
                    'num_worker' => $i,
                    'windy' => $request->stair_time_windy[$i],
                    'narrow' => $request->stair_time_narrow[$i],
                    'wide' => $request->stair_time_wide[$i],
                    'spiral' => $request->stair_time_spiral[$i],
                ]);
    
                foreach ($request->groundfloor_min[$i] as $k => $groundfloor_mins) {
                    foreach ($groundfloor_mins as $l => $groundfloor_min) {
                        DB::table('category_time_extra')->insert([
                            'category_id' => $category->id,
                            'num_worker' => $i,
                            'num_stairs' => $k,
                            'location_type' => $l,
                            'groundfloor_min' => isset($request->groundfloor_min[$i][$k][$l]) ? $request->groundfloor_min[$i][$k][$l] : 0,
                            'groundfloor_med' => isset($request->groundfloor_med[$i][$k][$l]) ? $request->groundfloor_med[$i][$k][$l] : 0,
                            'groundfloor_max' => isset($request->groundfloor_max[$i][$k][$l]) ? $request->groundfloor_max[$i][$k][$l] : 0,
                            'bulkhead_min' => isset($request->bulkhead_min[$i][$k][$l]) ? $request->bulkhead_min[$i][$k][$l] : 0,
                            'bulkhead_med' => isset($request->bulkhead_med[$i][$k][$l]) ? $request->bulkhead_med[$i][$k][$l] : 0,
                            'bulkhead_max' => isset($request->bulkhead_max[$i][$k][$l]) ? $request->bulkhead_max[$i][$k][$l] : 0,
                            'en_steps_min' => isset($request->en_steps_min[$i][$k][$l]) ? $request->en_steps_min[$i][$k][$l] : 0,
                            'en_steps_med' => isset($request->en_steps_med[$i][$k][$l]) ? $request->en_steps_med[$i][$k][$l] : 0,
                            'en_steps_max' => isset($request->en_steps_max[$i][$k][$l]) ? $request->en_steps_max[$i][$k][$l] : 0,
                        ]);
                    }
                }
            }
        }

        DB::table('category_dis_assembly')->where(['category_id' => $category->id])->delete();
        if($request->disassembly == true)
        {
            for ($i = 1; $i <= 4; $i++) {
                if (isset($request->check_num_workers[$i])) {
                    DB::table('category_dis_assembly')->insert([
                        'category_id' => $category->id,
                        'num_worker' => $i,
                        'R_A' => $request->R_A[$i],
                        'R_B' => $request->R_B[$i],
                        'R_C' => $request->R_C[$i],
                        'R_D' => $request->R_D[$i],
                        'R_E' => $request->R_E[$i],
                    ]);
                }
            }
        }

        Category::update_category($update, $category->id);

        if (isset($request->flag)) {
            $flag_categories = Flag::where([
                'id' => $request->flag
            ])->select('categories')->first()['categories'];
            if (!in_array($category->id, explode(',', $flag_categories))) {
                $flag_categories .= ',' . $category->id;
                Flag::where([
                    'id' => $request->flag
                ])->update([
                    'categories' => $flag_categories
                ]);
            }
        }

        DB::table('category_questions')->where(['category_id' => $category->id])->delete();
        if (isset($request->question)) {
            foreach ($request->question as $k => $question) {
                if (isset($request->question_allow[$k])) {
                    $questions[$k]['category_id'] = $category->id;
                    $questions[$k]['title'] = $question;
                    $questions[$k]['allow'] = true;
                } else {
                    $questions[$k]['category_id'] = $category->id;
                    $questions[$k]['title'] = $question;
                    $questions[$k]['allow'] = false;
                }
            }
    
            Category::AddQuestion($questions);
        }

        $category_id = $category->id;
        if (isset($request->sh_flights)) {
            foreach($request->sh_flights as $l => $sh_flight) {
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'flight',
                    'num_flights' => $l,
                    'location_type' => 0,
                    'mul_value' => $sh_flight[0]
                ));
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'flight',
                    'num_flights' => $l,
                    'location_type' => 1,
                    'mul_value' => $sh_flight[1]
                ));
            }
        }

        if (isset($request->sh_freight)) {
            foreach($request->sh_freight as $l => $sh_freight) {
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'freight',
                    'num_floor' => $l,
                    'location_type' => 0,
                    'mul_value' => $sh_freight[0]
                ));
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'freight',
                    'num_floor' => $l,
                    'location_type' => 1,
                    'mul_value' => $sh_freight[1]
                ));
            }
        }

        if (isset($request->sh_rs_freight)) {
            foreach($request->sh_rs_freight as $l => $sh_rs_freight) {
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'rs_freight',
                    'num_floor' => $l,
                    'location_type' => 0,
                    'mul_value' => $sh_rs_freight[0]
                ));
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'rs_freight',
                    'num_floor' => $l,
                    'location_type' => 1,
                    'mul_value' => $sh_rs_freight[1]
                ));
            }
        }

        if (isset($request->sh_passenger)) {
            foreach($request->sh_passenger as $l => $sh_passenger) {
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'passenger',
                    'num_floor' => $l,
                    'location_type' => 0,
                    'mul_value' => $sh_passenger[0]
                ));
                DB::table('category_shuffle_values')->insert(array(
                    'category_id' => $category_id,
                    'moving_type' => 'passenger',
                    'num_floor' => $l,
                    'location_type' => 1,
                    'mul_value' => $sh_passenger[1]
                ));
            }
        }

        return redirect()->to(route('admin.category.index'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            DB::table('category_time_flights')->where([
                'category_id' => $category->id
            ])->delete();

            DB::table('category_time_elevator')->where([
                'category_id' => $category->id
            ])->delete();

            DB::table('category_stair_time_factor')->where(['category_id' => $category->id])->delete();

            DB::table('category_dis_assembly')->where(['category_id' => $category->id])->delete();

            DB::table('category_questions')->where(['category_id' => $category->id])->delete();

            DB::table('category_shuffle_values')->where(['category_id' => $category->id])->delete();

            return redirect()->back();
        } catch (Exception $exception) {
            return redirect()->back();
        }
    }
    
    public function format_category($category_id) {
        $flights_time_temp = DB::table('category_time_flights')->where([
            'category_id' =>  $category_id
        ])->get();
        $elevator_time_temp = DB::table('category_time_elevator')->where([
            'category_id' =>  $category_id
        ])->get();
        $dis_assembly_temp = DB::table('category_dis_assembly')->where([
            'category_id' =>  $category_id
        ])->get();
        $stair_time_temp = DB::table('category_stair_time_factor')->where([
            'category_id' =>  $category_id
        ])->get();
        $extra_time_temp = DB::table('category_time_extra')->where([
            'category_id' => $category_id
        ])->get();

        $flights_min = array();
        $flights_med = array();
        $flights_max = array();
        $num_flights = DB::table('category_time_flights')->where([
            'category_id' =>  $category_id
        ])->max('num_flights');
        foreach ($flights_time_temp as $item) {
            $flights_min[$item->num_worker][$item->num_flights][$item->location_type] = $item->time_min;
            $flights_med[$item->num_worker][$item->num_flights][$item->location_type] = $item->time_med;
            $flights_max[$item->num_worker][$item->num_flights][$item->location_type] = $item->time_max;
        }

        $passenger_time = array();
        $passenger_delay = array();
        $freight_time = array();
        $freight_delay = array();
        $rs_freight_time = array();
        $rs_freight_delay = array();
        $num_floors = DB::table('category_time_elevator')->where([
            'category_id' =>  $category_id
        ])->max('num_floor');
        foreach ($elevator_time_temp as $item) {
            if (isset($item->passenger_time)) {
                $passenger_time[$item->num_worker][$item->num_floor][$item->location_type] = $item->passenger_time;
                $passenger_delay[$item->num_worker][$item->num_floor][$item->location_type] = $item->passenger_delay;
            }
            if (isset($item->freight_time)) {
                $freight_time[$item->num_worker][$item->num_floor][$item->location_type] = $item->freight_time;
                $freight_delay[$item->num_worker][$item->num_floor][$item->location_type] = $item->freight_delay;
            }
            if (isset($item->rs_freight_time)) {
                $rs_freight_time[$item->num_worker][$item->num_floor][$item->location_type] = $item->rs_freight_time;
                $rs_freight_delay[$item->num_worker][$item->num_floor][$item->location_type] = $item->rs_freight_delay;
            }
            
        }

        $groundfloor_min = array();
        $groundfloor_med = array();
        $groundfloor_max = array();
        $bulkhead_min = array();
        $bulkhead_med = array();
        $bulkhead_max = array();
        $en_steps_min = array();
        $en_steps_med = array();
        $en_steps_max = array();
        foreach ($extra_time_temp as $item) {
            $groundfloor_min[$item->num_worker][$item->num_stairs][$item->location_type] = $item->groundfloor_min;
            $groundfloor_med[$item->num_worker][$item->num_stairs][$item->location_type] = $item->groundfloor_med;
            $groundfloor_max[$item->num_worker][$item->num_stairs][$item->location_type] = $item->groundfloor_max;
            $bulkhead_min[$item->num_worker][$item->num_stairs][$item->location_type] = $item->bulkhead_min;
            $bulkhead_med[$item->num_worker][$item->num_stairs][$item->location_type] = $item->bulkhead_med;
            $bulkhead_max[$item->num_worker][$item->num_stairs][$item->location_type] = $item->bulkhead_max;
            $en_steps_min[$item->num_worker][$item->num_stairs][$item->location_type] = $item->en_steps_min;
            $en_steps_med[$item->num_worker][$item->num_stairs][$item->location_type] = $item->en_steps_med;
            $en_steps_max[$item->num_worker][$item->num_stairs][$item->location_type] = $item->en_steps_max;
        }

        $R = array();
        foreach ($dis_assembly_temp as $item) {
            $R['A'][$item->num_worker] = $item->R_A;
            $R['B'][$item->num_worker] = $item->R_B;
            $R['C'][$item->num_worker] = $item->R_C;
            $R['D'][$item->num_worker] = $item->R_D;
            $R['E'][$item->num_worker] = $item->R_E;
        }

        $stair_time_windy = array();
        $stair_time_narrow = array();
        $stair_time_wide = array();
        $stair_time_spiral = array();
        foreach ($stair_time_temp as $item) {
            $stair_time_windy[$item->num_worker] = $item->windy;
            $stair_time_narrow[$item->num_worker] = $item->narrow;
            $stair_time_wide[$item->num_worker] = $item->wide;
            $stair_time_spiral[$item->num_worker] = $item->spiral;
        }
        $max_num_flights = (isset($num_flights)) ? $num_flights : 7;
        $max_num_floors = (isset($num_floors)) ? $num_floors : 7;

        $ranking = Inventory::GetRanking();

        return view('admin.category.includes.time', compact('ranking', 'flights_min', 'flights_med', 'flights_max', 'passenger_time', 'passenger_delay', 'freight_time', 'freight_delay', 'rs_freight_time', 'rs_freight_delay', 'R', 'stair_time_windy', 'stair_time_narrow', 'stair_time_wide', 'stair_time_spiral', 'max_num_flights', 'max_num_floors', 'bulkhead_min', 'bulkhead_med', 'bulkhead_max', 'en_steps_min', 'en_steps_med', 'en_steps_max', 'groundfloor_min', 'groundfloor_med', 'groundfloor_max'));
    }
}
