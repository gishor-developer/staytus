<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::where('status', '=', 'active')
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
        $sort_order = $request->sort_order;

        $menu = new Menu;

        $menu->name         = $name;
        $menu->description  = $description;
        $menu->sort_order   = $sort_order;

        $menu->save();

        if($menu->id > 0){

            $status = 'Success';
            $message = 'Menu is successfully added';
            $result = $menu;
            $code = 200;
        }else{
            $status = 'Error';
            $message = 'Menu is not add';
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
        $menu = Menu::find($id);

        if(isset($menu->id)){
            $result = 
            $status = 'Success';
            $message = null;
            $result = $menu;
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
        $menu = Menu::find($id);

        if(isset($request->name) && $request->name != ''){
            $menu->name = $request->name;
        }
        if(isset($request->description) && $request->description != ''){
            $menu->description = $request->description;
        }
        if(isset($request->sort_order) && $request->sort_order != ''){
            $menu->sort_order = $request->sort_order;
        }
        if(isset($request->status) && $request->status != ''){
            $menu->status = $request->status;
        }

        if($menu->save()){

            $response = [
                'status' => 'success',
                'message'=> 'Menu is successfully updated'
            ];            
        }else{
            $response = [
                'status' => 'error',
                'message'=> 'Menu is not update'
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
        $menu = Menu::find($id);

        if(isset($menu->id)){

            $deleted = $menu->delete();

            if($deleted == 1){
                $response = [
                    'status' => 'success',
                    'message'=> 'Menu is successfully deleted'
                ];    
            }else{
                $response = [
                    'status' => 'error',
                    'message'=> 'Menu is not delete'
                ];   
            }  
            
        }else{
            $response = [
                'status' => 'error',
                'message'=> 'Menu is not delete'
            ];   
        }

        return response()->json($response);
    }

    public function sort($field,$order)
    {
        $menus = Menu::where('status', '=', 'active')
                ->orderBy($field, $order)
                ->get();

        return response()->json($menus);
    }
}
