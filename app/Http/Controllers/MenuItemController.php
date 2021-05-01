<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\MenuItemImage;
use App\Models\MenuItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = MenuItem::where('status', '=', 'active')
                ->orderBy('sort_order', 'asc')
                ->get();

        return response()->json($menus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'menu_id' => 'required',
            'category_id' => 'required',
            'price' => 'required|max:8',
            'sort_order' => 'required',
        ]);

        if($validator->fails()){

            $status = 'Error';
            $message = $validator->errors();
            $code = 422;

            return response()->json(['status'=>$status,'message'=>$message],$code);
        }

        $name       = $request->name;
        $description= $request->description;
        $menu_id = $request->menu_id;
        $price= $request->price;
        $sort_order = $request->sort_order;
        $category_id = $request->category_id;

        $menu_item = new MenuItem;

        $menu_item->name         = $name;
        $menu_item->description  = $description;
        $menu_item->menu_id  = $menu_id;
        $menu_item->price    = $price;
        $menu_item->sort_order   = $sort_order;

        $menu_item->save();

        if($menu_item->id > 0){

            foreach($category_id as $cid){
                $menu_item_category = new MenuItemCategory;
    
                $menu_item_category->category_id = $cid;
                $menu_item_category->menu_item_id = $menu_item->id;
        
                $menu_item_category->save();   
            }

            $menu_item = MenuItem::find($menu_item->id);

            $menu_item->categories;

            $status = 'Success';
            $message = 'Menu Item is successfully added';
            $result = $menu_item;
            $code = 200;
        }else{
            $status = 'Error';
            $message = 'Menu Item is not add';
            $result = null;
            $code = 400;
        }

        return response()->json(['status'=>$status,'message'=>$message,'result'=>$result],$code);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu_item = MenuItem::find($id);
        $menu_item->menu;
        $menu_item->image;
        $menu_item->categories;

        if(isset($menu_item->id)){
            $result = 
            $status = 'Success';
            $message = null;
            $result = $menu_item;
            $code = 200;
        }else{
            $status = 'Error';
            $message = 'No Record Found';
            $result = null;
            $code = 400;
        }

        return response()->json(['status'=>$status,'message'=>$message,'result'=>$result],$code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu_item = MenuItem::find($id);

        if(isset($request->name) && $request->name != ''){
            $menu_item->name = $request->name;
        }
        if(isset($request->description) && $request->description != ''){
            $menu_item->description = $request->description;
        }
        if(isset($request->menu_id) && $request->menu_id != ''){
            $menu_item->menu_id = $request->menu_id;
        }
        if(isset($request->price) && $request->price != ''){
            $menu_item->price = $request->price;
        }
        if(isset($request->sort_order) && $request->sort_order != ''){
            $menu_item->sort_order = $request->sort_order;
        }
        if(isset($request->status) && $request->status != ''){
            $menu_item->status = $request->status;
        }

        if($menu_item->save()){

            if(isset($request->category_id) && $request->category_id != ''){
                $category_id = $request->category_id;

                MenuItemCategory::where('menu_item_id', '=', $id)->delete();

                foreach($category_id as $cid){
                    $menu_item_category = new MenuItemCategory;
        
                    $menu_item_category->category_id    = $cid;
                    $menu_item_category->menu_item_id   = $menu_item->id;
            
                    $menu_item_category->save();   
                }
            }

            $response = [
                'status' => 'success',
                'message'=> 'Menu Item is successfully updated'
            ];            
        }else{
            $response = [
                'status' => 'error',
                'message'=> 'Menu Item is not update'
            ];   
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu_item = MenuItem::find($id);

        if(isset($menu_item->id)){

            $deleted = $menu_item->delete();

            MenuItemImage::where('menu_item_id', '=', $id)->delete();
            MenuItemCategory::where('menu_item_id', '=', $id)->delete();

            if($deleted == 1){
                $response = [
                    'status' => 'success',
                    'message'=> 'Menu Item is successfully deleted'
                ];    
            }else{
                $response = [
                    'status' => 'error',
                    'message'=> 'Menu Item is not delete'
                ];   
            }  
            
        }else{
            $response = [
                'status' => 'error',
                'message'=> 'Menu Item is not delete'
            ];   
        }

        return response()->json($response);
    }

    public function sort($field,$order)
    {
        $menu_items = MenuItem::where('status', '=', 'active')
                ->orderBy($field, $order)
                ->get();

        return response()->json($menu_items);
    }
}
