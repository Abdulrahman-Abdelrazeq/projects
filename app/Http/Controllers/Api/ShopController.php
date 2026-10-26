<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListShopResource;
use App\Models\Instruction;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function list()
    {
        if (request()->ip() == '197.43.117.211') {
            request()->headers->set('env-type', 'test') ;
        }
        
        $v=5;
        if(request('v') >= $v ){
            $v = request('v');
        }
        
        \Log::info(request('v'));
        
        if (request()->header('env-type') == 'test') {
            $records = Shop::where('is_live', 0);
        } else {
            $records = Shop::where('active', 1)->where('is_live', 1);
        }

        if (request('name') && strlen(request('name'))) {
            $records = $records->where('shop_name', 'LIKE', '%' . request('name') . '%');
        }
        
        $records = $records->paginate();

        foreach($records as $record){
            $link = $record->link_api;
            $link = str_replace('/api/v4', '/api/v' . $v, $link);
            $record->link_api = $link;
            
        }

        $last_page = $records->lastPage();
        $current_page = request('page') ?? 1;
        $source = ListShopResource::collection($records);

        $auto_start = true;
        if (request()->header('test') == '1') {
            $auto_start = false;
        }

        $auto_start = false;


        $data = [
            'data' => $source,
            'current_page' => $current_page,
            'last_page' => $last_page,
            'auto_start' => $auto_start
        ];
        if (count($records) > 0) {
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } else {
            $response = [
                "msg" => "لا يوجد محلات ",
                "status" => false
            ];
            return response()->json($response, 200);
        }
    }

    public function instructions()
    {
        $data = Instruction::select('id', 'order', 'notes', 'image')->orderBy('order')->get();

        if ($data->isEmpty()) {
            return response()->json([
                'status' => false,
                "msg" => "لا يوجد تعليمات ",
            ]);
        }
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }
}