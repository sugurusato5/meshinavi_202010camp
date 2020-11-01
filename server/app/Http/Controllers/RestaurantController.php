<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->name;
        $category = $request->category;
        $query = Restaurant::query();
        if($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if($category) {
            $query->whereHas('Category', function($q) use ($category){
            $q->where('name', 'like', '%' . $category . '%');
        });
        }
        $restaurants = $query->simplePaginate(5);
        // appends = 配列の最後尾に渡す compact = 連想配列を渡す
        $restaurants->appends(compact('name', 'category'));
        return view('restaurants.index', compact('restaurants'));
    // 検索方法(拡張がない)
    // if(!empty($name)) {
    //     $restaurants = Restaurant::where('name', 'like', '%' . $name . '%');
    // }
    // else {
    //     $restaurants = Restaurant::all();
    // }

    // $restaurants = Restaurant::simplepaginate(10);
    }
    
    public function show($id)
    {
        $restaurant = Restaurant::find($id);
        return view('restaurants.show', compact('restaurant'));
    }
}
