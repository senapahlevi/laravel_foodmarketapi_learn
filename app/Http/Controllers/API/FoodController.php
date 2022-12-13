<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FoodController extends Controller
{
    //
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit',6);
        $name = $request->input('name');
        $types = $request->input('types');
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');
        $rate_to = $request->input('rate_to');
        $rate_from = $request->input('rate_from');

        if($id)
        {
            $food = Food::find($id);
            if($food)
            {
                return ResponseFormatter::success(
                    $food,
                    'Data produk berhasil diambil'
                );
            }else
            {
                return ResponseFormatter::error(
                    null,
                    'Data produk tidak ada',
                    404
                );
            }
        }
        $food = Food::query();
        if($name)
        {
            $food->where('name','like','%'.$name.'%');
        }
        if($types)
        {
            $food->where('name','like','%'.$types.'%');
        }
        if($price_from)
        {
            $food->where('price','>=',$price_from);
        }
        if($price_to)
        {
            $food->where('price','<=',$price_to);
        }
        return ResponseFormatter::success(
            $food->paginate($limit),
            'Data list produk berhasil diambil!'
        );
    }
}
