<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use File;
use App\Category;
use App\Answer;
use App\Helpers\Helper;
use App\Inventory;
use App\Material;
use App\Question;
use App\Flag;
use App\Designation;
use App\InsuranceCategory;
use App\ShuffleFee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class InventoryController extends Controller
{
    
    public function __construct()
    {
        if (!Helper::authorized('item')){
            return abort(404);
        }
        
        $this->middleware('admin');
    }
    
    public function index(Request $request)
    {
        if (!isset($request->category_id))
            $category_id = Category::orderBy('id')->first()->id;
        else
            $category_id = $request->category_id;

        if (!isset($request->per_page))
            $per_page = 10;
        else
            $per_page = $request->per_page;

        if (isset($request->search)) {
            $inventories = Inventory::orderBy('created_at', 'desc')->where('category_id', $category_id)->where('name', 'LIKE', '%'.$request->search.'%')->paginate($per_page);
            $search = $request->search;
        } else {
            $inventories = Inventory::orderBy('created_at', 'desc')->where('category_id', $category_id)->paginate($per_page);
            $search = '';
        }

        $categories = Category::all();
        return view('admin.inventory.index', compact('inventories', 'categories', 'category_id', 'search', 'per_page'));
    }
    
    public function create()
    {

        // Get Ranking
        $ranking = Inventory::GetRanking();
        $equipments = Inventory::GetInventoryEquipment();
        $materials = Material::orderBy('created_at', 'desc')->get();
        $ins_categories = InsuranceCategory::orderBy('created_at', 'desc')->get();

        // $samSaraCategories = $this->getSamSaraCategories();
        $categories = Category::orderBy('created_at', 'desc')->get();

        $category_questions = Category::GetQuestion();

        $badgess = Designation::GetBadgesFactor();
        $badge_type = Designation::GetBadgesType();
        
        foreach($badge_type as $tk => $t)
        {
            $types[$tk]['type'] = $t->badge_type_name;
            
            foreach($badgess as $k => $b)
            {
                if($t->badge_type_id == $b->badge_type_id)
                {
                    $types[$tk]['badge'][$k]['id'] = $b->factor_id;
                    $types[$tk]['badge'][$k]['name'] = $b->factor_name;
                }
            }    
        }

        $flags_temp = Flag::get();
        $flags = [];
        foreach ($flags_temp as $f) {
            if (in_array('items', explode(',', $f->conditions))) {
                array_push($flags, $f);
            }
        }
        
        $max_num_flights = 7;
        $max_num_floors = 7;

        // Charges per cb ft from shuffle fees
        $charge_cb_ft = ShuffleFee::first()->charge_cb_ft;

        return view('admin.inventory.create', compact('categories','ranking','equipments','materials','category_questions','types', 'flags', 'max_num_flights', 'max_num_floors', 'ins_categories', 'charge_cb_ft'));
        
    }
   
    public function store(Request $request)
    {
        // dd($request->all());
        if(isset($request->upload_excel_sheet))
        {
            $this->importFileIntoDB($request);
            return redirect()->to(route('admin.inventory.index'));
        }
        elseif(isset($request->download_excel_sheet))
        {
            $file= public_path(). "/sample/sample.xlsx";
            $headers = ['Content-Type' => 'application/xlsx'];
            return response()->download($file, 'sample.xlsx', $headers);
        }
        else
        {
            $item = new Inventory();
            $item->name = $request->get('name');
            
            $item->meterial = $request->get('meterial_type');
            $item->category_id = $request->get('category');
            $item->hoisting = $request->get('hoisting');

            if(!empty($request->equipment))
            {
                $item['equipments'] = implode(',',$request->equipment);
            }

            if (!empty($request->badges)) {
                $item->badges = implode(',', $request->badges);
            }

            if (isset($request->stackable)) {
                $item->stackable = 1;
                $item->stackable_multiplier = $request->stackable_multiplier;
            } else {
                $item->stackable = 0;
            }

            $item->storage_price = $request->get('storage_price');
            $item->pickup_price = $request->get('pickup_price');
            $item->dropoff_price = $request->get('dropoff_price');
            $item->weight_min = $request->get('weight_min');
            $item->junk_price_min = $request->get('junk_price_min');
            $item->weight_max = $request->get('weight_max');
            $item->junk_price_max = $request->get('junk_price_max');
            $item->width = $request->get('width');
            $item->height = $request->get('height');
            $item->breadth = $request->get('breadth');
            $item->volume = $request->get('volume');
            $item->multiplier = $request->get('multiplier');
            $item->packing_volume = $request->get('packing_volume');

            $item->wrapping_material = $request->get('wrapping_material');
            $item->wrapping_qty = $request->get('wrapping_qty');
            $item->wrapping_price = $request->get('wrapping_price');
            $item->wrapping_time = $request->get('wrapping_time');

            $item->flag = isset($request->flag) ? $request->flag : null;

            $item->save();

            if (isset($request->ins)) {
                foreach ($request->ins as $k => $ins) {
                    DB::table('inventory_insurance')->insert(array(
                        'inventory_id' => $item->id,
                        'insurance_id' => $k,
                        'value' => $ins
                    ));
                }
            }

            if (isset($request->flag)) {
                $flag_items = Flag::where([
                    'id' => $request->flag
                ])->select('items')->first()['items'];
                $flag_items .= ',' . $item->id;
                Flag::where([
                    'id' => $request->flag
                ])->update([
                    'items' => $flag_items
                ]);
            }

            if (isset($request->question)) {
                foreach($request->question as $k => $question)
                {
                    if (isset($request->check_inv_question[$k])) {
                        $questions[$k]['allow'] = true;
                    } else {
                        $questions[$k]['allow'] = false;
                    }
                    $questions[$k]['item_id'] = $item->id;
                    $questions[$k]['title'] = $question;
                    $questions[$k]['created_at'] = now();
                    $questions[$k]['updated_at'] = now();
                }

                $where['item_id'] = $item->id;
                Inventory::DeleteInventoryQuestion($where);
                Inventory::AddInventoryQuestion($questions);
            }

            $active_cat_que_ids = array();
            if (isset($request->check_cat_question)) {
                foreach ($request->check_cat_question as $k => $i) {
                    array_push($active_cat_que_ids, $k);
                }
            }
            DB::table('category_questions')->whereNotIn('question_id', $active_cat_que_ids)->update([
                'allow' => 0
            ]);
            DB::table('category_questions')->whereIn('question_id', $active_cat_que_ids)->update([
                'allow' => 1
            ]);

            if ($request->hasFile('file')) 
            {
                $this->upload_picture($request,$item->id);    
            }

            $item_id = $item->id;

            for ($i = 1; $i <= 4; $i++) {
                if (isset($request->check_num_workers[$i])) {
                    foreach ($request->flights_min[$i] as $k => $min_times) {
                        foreach ($min_times as $l => $min_time) {
                            DB::table('inventory_time_flights')->insert([
                                'item_id' => $item_id,
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
                            DB::table('inventory_time_elevator')->insert([
                                'item_id' => $item_id,
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
                            $temp = DB::table('inventory_time_elevator')->where([
                                'item_id' => $item_id,
                                'num_worker' => $i,
                                'num_floor' => $k,
                                'location_type' => $l
                            ])->get();
                            if ($temp != null) {
                                DB::table('inventory_time_elevator')->where([
                                    'item_id' => $item_id,
                                    'num_worker' => $i,
                                    'num_floor' => $k,
                                    'location_type' => $l
                                ])->update([
                                    'freight_time' => $freight_time,
                                    'freight_delay' => $request->freight_delay[$i][$k][$l],
                                ]);
                            } else {
                                DB::table('inventory_time_elevator')->insert([
                                    'item_id' => $item_id,
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
                            $temp = DB::table('inventory_time_elevator')->where([
                                'item_id' => $item_id,
                                'num_worker' => $i,
                                'num_floor' => $k,
                                'location_type' => $l
                            ])->get();
                            if ($temp != null) {
                                DB::table('inventory_time_elevator')->where([
                                    'item_id' => $item_id,
                                    'num_worker' => $i,
                                    'num_floor' => $k,
                                    'location_type' => $l,
                                ])->update([
                                    'rs_freight_time' => $rs_freight_time,
                                    'rs_freight_delay' => $request->rs_freight_delay[$i][$k][$l],
                                ]);
                            } else {
                                DB::table('inventory_time_elevator')->insert([
                                    'item_id' => $item_id,
                                    'num_worker' => $i,
                                    'num_floor' => $k,
                                    'location_type' => $l,
                                    'rs_freight_time' => $rs_freight_time,
                                    'rs_freight_delay' => $request->rs_freight_delay[$i][$k][$l],
                                ]);
                            }
                        }
                    }

                    DB::table('inventory_stair_time_factor')->insert([
                        'item_id' => $item_id,
                        'num_worker' => $i,
                        'windy' => $request->stair_time_windy[$i],
                        'narrow' => $request->stair_time_narrow[$i],
                        'wide' => $request->stair_time_wide[$i],
                        'spiral' => $request->stair_time_spiral[$i],
                    ]);

                    foreach ($request->groundfloor_min[$i] as $k => $groundfloor_mins) {
                        foreach ($groundfloor_mins as $l => $groundfloor_min) {
                            DB::table('inventory_time_extra')->insert([
                                'item_id' => $item_id,
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

            if (isset($request->sh_flights)) {
                foreach($request->sh_flights as $l => $sh_flight) {
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'flight',
                        'num_flights' => $l,
                        'location_type' => 0,
                        'mul_value' => $sh_flight[0]
                    ));
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'flight',
                        'num_flights' => $l,
                        'location_type' => 1,
                        'mul_value' => $sh_flight[1]
                    ));
                }
            }

            if (isset($request->sh_freight)) {
                foreach($request->sh_freight as $l => $sh_freight) {
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'freight',
                        'num_floor' => $l,
                        'location_type' => 0,
                        'mul_value' => $sh_freight[0]
                    ));
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'freight',
                        'num_floor' => $l,
                        'location_type' => 1,
                        'mul_value' => $sh_freight[1]
                    ));
                }
            }

            if (isset($request->sh_rs_freight)) {
                foreach($request->sh_rs_freight as $l => $sh_rs_freight) {
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'rs_freight',
                        'num_floor' => $l,
                        'location_type' => 0,
                        'mul_value' => $sh_rs_freight[0]
                    ));
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'rs_freight',
                        'num_floor' => $l,
                        'location_type' => 1,
                        'mul_value' => $sh_rs_freight[1]
                    ));
                }
            }

            if (isset($request->sh_passenger)) {
                foreach($request->sh_passenger as $l => $sh_passenger) {
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'passenger',
                        'num_floor' => $l,
                        'location_type' => 0,
                        'mul_value' => $sh_passenger[0]
                    ));
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'passenger',
                        'num_floor' => $l,
                        'location_type' => 1,
                        'mul_value' => $sh_passenger[1]
                    ));
                }
            }

            if($request->disassembly == true)
            {
                for ($i = 1; $i <= 4; $i++) {
                    if (isset($request->check_num_workers[$i])) {
                        DB::table('inventory_dis_assembly')->insert([
                            'item_id' => $item_id,
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

            return redirect()->to(route('admin.inventory.index'));
        }
    }
    
    
    public function show(Inventory $inventory)
    {
        
    }
    
    public function edit(Inventory $inventory)
    {
        // Get Ranking
        $ranking = Inventory::GetRanking();
        $equipments = Inventory::GetInventoryEquipment();
        $inventory_questions = Inventory::GetInventoryQuestion($inventory->id);
        $materials = Material::orderBy('created_at', 'desc')->get();
        $ins_categories = InsuranceCategory::orderBy('created_at', 'desc')->get();
        $ins_data_temp = DB::table('inventory_insurance')->where('inventory_id', $inventory->id)->get();
        
        // $samSaraCategories = $this->getSamSaraCategories();
        $categories = Category::orderBy('created_at', 'desc')->get();
        
        $category_questions = Category::GetQuestion();
        
        $badgess = Designation::GetBadgesFactor();
        $badge_type = Designation::GetBadgesType();
        
        foreach($badge_type as $tk => $t)
        {
            $types[$tk]['type'] = $t->badge_type_name;
            
            foreach($badgess as $k => $b)
            {
                if($t->badge_type_id == $b->badge_type_id)
                {
                    $types[$tk]['badge'][$k]['id'] = $b->factor_id;
                    $types[$tk]['badge'][$k]['name'] = $b->factor_name;
                }
            }    
        }

        $flags_temp = Flag::get();
        $flags = [];
        foreach ($flags_temp as $f) {
            if (in_array('items', explode(',', $f->conditions))) {
                array_push($flags, $f);
            }
        }

        $flights_time_temp = DB::table('inventory_time_flights')->where([
            'item_id' => $inventory->id
        ])->get();
        $elevator_time_temp = DB::table('inventory_time_elevator')->where([
            'item_id' => $inventory->id
        ])->get();
        $dis_assembly_temp = DB::table('inventory_dis_assembly')->where([
            'item_id' => $inventory->id
        ])->get();
        $stair_time_temp = DB::table('inventory_stair_time_factor')->where([
            'item_id' => $inventory->id
        ])->get();
        $extra_time_temp = DB::table('inventory_time_extra')->where([
            'item_id' => $inventory->id
        ])->get();

        $flights_min = array();
        $flights_med = array();
        $flights_max = array();
        $num_flights = DB::table('inventory_time_flights')->where([
            'item_id' => $inventory->id
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
        $num_floors = DB::table('inventory_time_elevator')->where([
            'item_id' => $inventory->id
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

        $ins_data = array();
        foreach ($ins_data_temp as $i_d) {
            $ins_data[$i_d->insurance_id] = $i_d->value;
        }

        // Shuffle Data
        $sh_flights = array();
        $sh_passenger = array();
        $sh_freight = array();
        $sh_rs_freight = array();
        $sh_data_temp = DB::table('inventory_shuffle_values')->where([
            'item_id' => $inventory->id
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

        return view('admin.inventory.edit', compact('inventory','ranking', 'equipments','materials','categories','category_questions','inventory_questions','types', 'flags', 'flights_min', 'flights_med', 'flights_max', 'passenger_time', 'passenger_delay', 'freight_time', 'freight_delay', 'rs_freight_time', 'rs_freight_delay', 'R', 'stair_time_windy', 'stair_time_narrow', 'stair_time_wide', 'stair_time_spiral', 'max_num_flights', 'max_num_floors', 'bulkhead_min', 'bulkhead_med', 'bulkhead_max', 'en_steps_min', 'en_steps_med', 'en_steps_max', 'groundfloor_min', 'groundfloor_med', 'groundfloor_max', 'ins_categories', 'ins_data', 'sh_flights', 'sh_passenger', 'sh_freight', 'sh_rs_freight', 'charge_cb_ft'));
        
    }
    
    public function calculate_moving_time($item)
    {
        
    }
    
    public function update(Request $request, Inventory $inventory)
    {
        
        // dd($request->all());
        
        if (isset($_FILES['file']['name'])) 
        {
            $this->upload_picture($request,$inventory->id);    
        }
        else
        {
            // insurance data update

            foreach($request->ins as $k => $ins) {
                $temp = DB::table('inventory_insurance')->where(array(
                    'inventory_id' => $inventory->id,
                    'insurance_id' => $k
                ))->get();
                if (isset($temp)) {
                    DB::table('inventory_insurance')->where(array(
                        'inventory_id' => $inventory->id,
                        'insurance_id' => $k
                    ))->update(array(
                        'value' => $ins
                    ));
                } else {
                    DB::table('inventory_insurance')->insert(array(
                        'inventory_id' => $inventory->id,
                        'insurance_id' => $k,
                        'value' => $ins
                    ));
                }
            }

            $item['name'] = $request->get('name');
            $item['meterial'] = $request->get('meterial');
            $item['hoisting'] = $request->get('hoisting');
            $item['category_id'] = $request->get('category');
            $item['storage_price'] = $request->get('storage_price');
            $item['pickup_price'] = $request->get('pickup_price');
            $item['dropoff_price'] = $request->get('dropoff_price');
            $item['weight_min'] = $request->get('weight_min');
            $item['junk_price_min'] = $request->get('junk_price_min');
            $item['weight_max'] = $request->get('weight_max');
            $item['junk_price_max'] = $request->get('junk_price_max');
            $item['width'] = $request->get('width');
            $item['height'] = $request->get('height');
            $item['breadth'] = $request->get('breadth');
            $item['volume'] = $request->get('volume');
            $item['multiplier'] = $request->get('multiplier');
            $item['packing_volume'] = $request->get('packing_volume');

            if (isset($request->stackable)) {
                $item['stackable'] = 1;
                $item['stackable_multiplier'] = $request->stackable_multiplier;
            } else {
                $item['stackable'] = 0;
            }

            if(!empty($request->equipment))
            {
                $item['equipments'] = implode(',',$request->equipment);
            }
            
            if(!empty($request->badges))
            {
                $item['badges'] = implode(',',$request->badges);
            }

            $item['flag'] = isset($request->flag) ? $request->flag : null;
            $inventory->where('id',$inventory->id)->update($item);

            DB::table('inventory_time_flights')->where([
                'item_id' => $inventory->id
            ])->delete();
            DB::table('inventory_time_elevator')->where([
                'item_id' => $inventory->id
            ])->delete();
            DB::table('inventory_stair_time_factor')->where(['item_id' => $inventory->id])->delete();
            DB::table('inventory_time_extra')->where(['item_id' => $inventory->id])->delete();
            DB::table('inventory_shuffle_values')->where(['item_id' => $inventory->id])->delete();

            for ($i = 1; $i <= 4; $i++) {
                if (isset($request->check_num_workers[$i])) {
                    foreach ($request->flights_min[$i] as $k => $min_times) {
                        foreach ($min_times as $l => $min_time) {
                            DB::table('inventory_time_flights')->insert([
                                'item_id' => $inventory->id,
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
                            DB::table('inventory_time_elevator')->insert([
                                'item_id' => $inventory->id,
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
                            $temp = DB::table('inventory_time_elevator')->where([
                                'item_id' => $inventory->id,
                                'num_worker' => $i,
                                'num_floor' => $k,
                                'location_type' => $l
                            ])->get();
                            if ($temp != null) {
                                DB::table('inventory_time_elevator')->where([
                                    'item_id' => $inventory->id,
                                    'num_worker' => $i,
                                    'num_floor' => $k,
                                    'location_type' => $l
                                ])->update([
                                    'freight_time' => $freight_time,
                                    'freight_delay' => $request->freight_delay[$i][$k][$l],
                                ]);
                            } else {
                                DB::table('inventory_time_elevator')->insert([
                                    'item_id' => $inventory->id,
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
                            $temp = DB::table('inventory_time_elevator')->where([
                                'item_id' => $inventory->id,
                                'num_worker' => $i,
                                'num_floor' => $k,
                                'location_type' => $l
                            ])->get();
                            if ($temp != null) {
                                DB::table('inventory_time_elevator')->where([
                                    'item_id' => $inventory->id,
                                    'num_worker' => $i,
                                    'num_floor' => $k,
                                    'location_type' => $l,
                                ])->update([
                                    'rs_freight_time' => $rs_freight_time,
                                    'rs_freight_delay' => $request->rs_freight_delay[$i][$k][$l],
                                ]);
                            } else {
                                DB::table('inventory_time_elevator')->insert([
                                    'item_id' => $inventory->id,
                                    'num_worker' => $i,
                                    'num_floor' => $k,
                                    'location_type' => $l,
                                    'rs_freight_time' => $rs_freight_time,
                                    'rs_freight_delay' => $request->rs_freight_delay[$i][$k][$l],
                                ]);
                            }
                        }
                    }

                    DB::table('inventory_stair_time_factor')->insert([
                        'item_id' => $inventory->id,
                        'num_worker' => $i,
                        'windy' => $request->stair_time_windy[$i],
                        'narrow' => $request->stair_time_narrow[$i],
                        'wide' => $request->stair_time_wide[$i],
                        'spiral' => $request->stair_time_spiral[$i],
                    ]);

                    foreach ($request->groundfloor_min[$i] as $k => $groundfloor_mins) {
                        foreach ($groundfloor_mins as $l => $groundfloor_min) {
                            DB::table('inventory_time_extra')->insert([
                                'item_id' => $inventory->id,
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

            DB::table('inventory_dis_assembly')->where(['item_id' => $inventory->id])->delete();
            if($request->disassembly == true)
            {
                for ($i = 1; $i <= 4; $i++) {
                    if (isset($request->check_num_workers[$i])) {
                        DB::table('inventory_dis_assembly')->insert([
                            'item_id' => $inventory->id,
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
                $flag_items = Flag::where([
                    'id' => $request->flag
                ])->select('items')->first()['items'];
                if (!in_array($inventory->id, explode(',', $flag_items))) {
                    $flag_items .= ',' . $inventory->id;
                    Flag::where([
                        'id' => $request->flag
                    ])->update([
                        'items' => $flag_items
                    ]);
                }
            }
            
            $where['item_id'] = $inventory->id;
            Inventory::DeleteInventoryQuestion($where);
            
            if(isset($request->question))
            {
                foreach($request->question as $k => $question)
                {
                    if (isset($request->check_inv_question[$k])) {
                        $questions[$k]['allow'] = true;
                    } else {
                        $questions[$k]['allow'] = false;
                    }
                    $questions[$k]['item_id'] = $inventory->id;
                    $questions[$k]['title'] = $question;
                    $questions[$k]['created_at'] = now();
                    $questions[$k]['updated_at'] = now();
                }
                Inventory::AddInventoryQuestion($questions);
            }

            $active_cat_que_ids = array();
            if (isset($request->check_cat_question)) {
                foreach ($request->check_cat_question as $k => $item) {
                    array_push($active_cat_que_ids, $k);
                }
            }
            DB::table('category_questions')->whereNotIn('question_id', $active_cat_que_ids)->update([
                'allow' => 0
            ]);
            DB::table('category_questions')->whereIn('question_id', $active_cat_que_ids)->update([
                'allow' => 1
            ]);

            $item_id = $inventory->id;

            if (isset($request->sh_flights)) {
                foreach($request->sh_flights as $l => $sh_flight) {
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'flight',
                        'num_flights' => $l,
                        'location_type' => 0,
                        'mul_value' => $sh_flight[0]
                    ));
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'flight',
                        'num_flights' => $l,
                        'location_type' => 1,
                        'mul_value' => $sh_flight[1]
                    ));
                }
            }

            if (isset($request->sh_freight)) {
                foreach($request->sh_freight as $l => $sh_freight) {
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'freight',
                        'num_floor' => $l,
                        'location_type' => 0,
                        'mul_value' => $sh_freight[0]
                    ));
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'freight',
                        'num_floor' => $l,
                        'location_type' => 1,
                        'mul_value' => $sh_freight[1]
                    ));
                }
            }

            if (isset($request->sh_rs_freight)) {
                foreach($request->sh_rs_freight as $l => $sh_rs_freight) {
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'rs_freight',
                        'num_floor' => $l,
                        'location_type' => 0,
                        'mul_value' => $sh_rs_freight[0]
                    ));
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'rs_freight',
                        'num_floor' => $l,
                        'location_type' => 1,
                        'mul_value' => $sh_rs_freight[1]
                    ));
                }
            }

            if (isset($request->sh_passenger)) {
                foreach($request->sh_passenger as $l => $sh_passenger) {
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'passenger',
                        'num_floor' => $l,
                        'location_type' => 0,
                        'mul_value' => $sh_passenger[0]
                    ));
                    DB::table('inventory_shuffle_values')->insert(array(
                        'item_id' => $item_id,
                        'moving_type' => 'passenger',
                        'num_floor' => $l,
                        'location_type' => 1,
                        'mul_value' => $sh_passenger[1]
                    ));
                }
            }

            return redirect()->to(route('admin.inventory.index'));
        }
    }
    
    
    public function destroy(Inventory $inventory)
    {
        $questions = Question::where('item_id', $inventory->id)->get();
        foreach ($questions as $question) {
            Answer::where('question_id', $question->id)->delete();
            Question::findOrFail($question->id)->delete();
        }
        $inventory->delete();
        DB::table('inventory_time_flights')->where([
            'item_id' => $inventory->id
        ])->delete();
        DB::table('inventory_time_elevator')->where([
            'item_id' => $inventory->id
        ])->delete();
        DB::table('inventory_stair_time_factor')->where(['item_id' => $inventory->id])->delete();
        DB::table('inventory_dis_assembly')->where(['item_id' => $inventory->id])->delete();
        DB::table('inventory_time_extra')->where(['item_id' => $inventory->id])->delete();
        DB::table('inventory_insurance')->where(['inventory_id' => $inventory->id])->delete();
        DB::table('inventory_shuffle_values')->where(['item_id' => $inventory->id])->delete();
        return redirect()->back();
    }
    
    public function questionsAnswersDestroy(Inventory $inventory)
    {
        $questions = Question::where('item_id', $inventory->id)->get();
        foreach ($questions as $question) {
            Answer::where('question_id', $question->id)->delete();
            Question::findOrFail($question->id)->delete();
        }
    }
    
    /**
     * @param $item_id
     * @param $question
     * @return mixed
     */
    public function store_question($item_id, $question)
    {
        $newQuestion = new Question;
        $newQuestion->item_id = $item_id;
        $newQuestion->title = $question;
        $newQuestion->save();
        return $newQuestion->id;
    }
    
    /**
     * @param $question_id
     * @param $answer
     */
    public function store_answer($question_id, $answer)
    {
        $newAnswer = new Answer;
        $newAnswer->question_id = $question_id;
        $newAnswer->title = $answer;
        $newAnswer->save();
    }

    
    
    /**
     * @param Request $request
     * @param $item_id
     */
    public function storeQuestionAnswers(Request $request, $item_id)
    {
        $questions = $request->get('question');
        
        foreach ($questions as $key => $question) 
        {
            $question_id = $this->store_question($item_id, $question);
            $answers = $request->get("answer_" . $key);
            foreach ($answers as $answer) {
                $this->store_answer($question_id, $answer);
            }
        }
    }

    public function importFileIntoDB(Request $request)
    {
        // Get Ranking
        $ranking = Inventory::GetRanking();
        $equipments = Inventory::GetInventoryEquipment();
        $materials = Material::orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('created_at', 'desc')->get();
        
        // $ext = ltrim(strstr($_FILES['excel_file']['name'], '.'), '.');
        
        // if($ext == 'xlsx')
        // {
        $path = $request->file('excel_file')->getRealPath();
        $data = \Excel::load($path)->get();

        $num_images = count($_FILES['image_files']['name']);
        if (count($data) < $num_images) {
            return redirect()->to(route('admin.inventory.index'));
        } else {
            if($data->count())
            {
                foreach ($data as $key => $value) 
                {
                    $category_value = 0;
                    if(!empty($value->category))
                    {
                        foreach($categories as $c)
                        {
                            if(strtolower(trim($c->name)) == strtolower(trim($value->category)))
                            {
                                $category_value = $c->id;
                            }
                        }
                    }
                    $hoisting_value = null;
                    if(!empty($value->hoisting)) {
                        if ($value->hoisting == 'yes') {
                            $hoisting_value = true;
                        } elseif ($value->hoisting == 'no') {
                            $hoisting_value = false;
                        }
                    }
                    $material_value = 0;
                    $material_price = 0;
                    if (!empty($value->material)) {
                        foreach ($materials as $m) {
                            if (strtolower(trim($m->name)) == strtolower(trim($value->material))) {
                                $material_value = $m->id;
                                $material_price = $m->price;
                            }
                        }
                    }

                    if ($category_value != 0) {
                        $item['category_id'] = $category_value;
                        $item['name'] = $value->name;
                        $item['weight'] = $value->weight;
                        $item['width'] = $value->width;
                        $item['height'] = $value->height;
                        $item['breadth'] = $value->breadth;
                        $item['volume'] = $value->breadth * $value->height * $value->width;
                        $item['junk_price'] = $value->weight * $material_price;
                        $item['meterial'] = $material_value;
                        $item['hoisting'] = $hoisting_value;
                        $item['created_at'] = now(); 
                        $item['updated_at'] = now();
                        $id = Inventory::insertGetId($item);
                        for ($k = 0; $k < $num_images; $k++) {
                            $file_name = pathinfo($_FILES['image_files']['name'][$k], PATHINFO_FILENAME);
    
                            if ($file_name == $item['name']) {
                                $ext = ltrim(strstr($_FILES['image_files']['name'][$k], '.'), '.');
                                $path = public_path() . "/uploads/inventory";
                                $name = $id.'_'.$_FILES['image_files']['name'][$k];
                                $target_file = $path.'/'. $name;
    
                                if (move_uploaded_file($_FILES['image_files']['tmp_name'][$k], $target_file)) {
    
                                    $update['file_path']     = "/uploads/inventory/".$_FILES['image_files']['name'][$k];
                                    $update['file_name']     = $_FILES['image_files']['name'][$k];
                                    $update['file_size']     = $_FILES['image_files']['size'][$k];
                                    $update['file_type']     = $_FILES['image_files']['type'][$k];
                                    $update['extension']     = $ext;
                                    $where['id'] = $id;
                                    Inventory::update_item_image($update,$where);
    
                                }
                            }
                        }
                    }
                }
            }
        }

        // }

    } 
    
    public static function upload_picture($request,$item_id)
    {
        $ext = ltrim(strstr($_FILES['file']['name'], '.'), '.');
        $path = public_path() . "/uploads/inventory";
        
        $file_name = $item_id.'_'.$_FILES['file']['name'];
        $target_file = $path.'/'. $file_name;
        
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
        {
            $update['file_path']     = "/uploads/inventory/".$file_name;
            $update['file_name']     = $_FILES['file']['name'];
            $update['file_size']     = $_FILES['file']['size'];
            $update['file_type']     = $_FILES['file']['type'];
            $update['extension']     = $ext;
            $where['id'] = $item_id;
            Inventory::update_item_image($update,$where);
            return true;
        } 
        else 
        {
            return false;
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

        return view('admin.inventory.includes.time', compact('ranking', 'flights_min', 'flights_med', 'flights_max', 'passenger_time', 'passenger_delay', 'freight_time', 'freight_delay', 'rs_freight_time', 'rs_freight_delay', 'R', 'stair_time_windy', 'stair_time_narrow', 'stair_time_wide', 'stair_time_spiral', 'max_num_flights', 'max_num_floors', 'bulkhead_min', 'bulkhead_med', 'bulkhead_max', 'en_steps_min', 'en_steps_med', 'en_steps_max', 'groundfloor_min', 'groundfloor_med', 'groundfloor_max'));
    }

    public function image_upload(Request $request, $item_id) {
        if ($request->hasFile('file')) 
        {
            $this->upload_picture($request,$item_id);
        }

        return redirect()->to(route('admin.inventory.index'));
    }
}
