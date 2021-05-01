<?php

namespace App\Http\Controllers;

use App\Models\MenuItemImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuItemImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu_item_images = MenuItemImage::orderBy('id', 'asc')
                ->get();

        return response()->json($menu_item_images);
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
            'menu_item_id' => 'required',
            'image' => 'required'
        ]);

        if($validator->fails()){

            $status = 'Error';
            $message = $validator->errors();
            $code = 422;

            return response()->json(['status'=>$status,'message'=>$message],$code);
        }

        $menu_item_image = new MenuItemImage;

        $menu_item_image->menu_item_id = $request->menu_item_id;
        $menu_item_image->image = $request->image;

        $menu_item_image->save();

        if($menu_item_image->id > 0){

            $status = 'Success';
            $message = 'Menu Item Image is successfully added';
            $result = $menu_item_image;
            $code = 200;
        }else{
            $status = 'Error';
            $message = 'Menu Item Image is not add';
            $result = null;
            $code = 400;
        }

        return response()->json(['status'=>$status,'message'=>$message,'result'=>$result],$code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MenuItemImage  $menuItemImages
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu_item_image = MenuItemImage::find($id);
        $menu_item_image->menu_item;

        if(isset($menu_item_image->id)){
            $result = 
            $status = 'Success';
            $message = null;
            $result = $menu_item_image;
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
     * @param  \App\Models\MenuItemImage  $menuItemImages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu_item_image = MenuItemImage::find($id);

        if(isset($request->menu_item_id) && $request->menu_item_id != ''){
            $menu_item_image->menu_item_id = $request->menu_item_id;
        }
        if(isset($request->image) && $request->image != ''){
            $menu_item_image->image = $request->image;
        }

        if($menu_item_image->save()){

            $status = 'Success';
            $message = 'Menu Item Image is successfully updated';
            $result = $menu_item_image;
            $code = 200;
        }else{
            $status = 'Error';
            $message = 'Menu Item Image is not update';
            $result = null;
            $code = 400;
        }

        return response()->json(['status'=>$status,'message'=>$message,'result'=>$result],$code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuItemImage  $menuItemImages
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu_item_image = MenuItemImage::find($id);

        if(isset($menu_item_image->id)){

            $deleted = $menu_item_image->delete();

            if($deleted == 1){
                $response = [
                    'status' => 'success',
                    'message'=> 'Menu Item Image is successfully deleted'
                ];    
            }else{
                $response = [
                    'status' => 'error',
                    'message'=> 'Menu Item Image is not delete'
                ];   
            }  
            
        }else{
            $response = [
                'status' => 'error',
                'message'=> 'Menu Item Image is not delete'
            ];   
        }

        return response()->json($response);
    }
}
