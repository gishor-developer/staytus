<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::select('id', 'parent_id', 'name', 'description', 'sort_order', 'status',  'created_at', 'updated_at')
                ->where('status', '=', 'active')
                ->orderBy('sort_order', 'asc')
                ->get();

        return response()->json($categories);
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

        $category = new Category;

        $category->parent_id    = 0;
        $category->name         = $name;
        $category->description  = $description;
        $category->sort_order   = $sort_order;

        $category->save();

        if($category->id > 0){
            $status = 'Success';
            $message = 'Category is successfully added';
            $result = $category;
            $code = 200;
        }else{
            $status = 'Error';
            $message = 'Category is not add';
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

        $category = Category::find($id);

        if(isset($category->id)){
            $status = 'Success';
            $message = null;
            $result = $category;
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
        $category = Category::find($id);

        if(isset($request->name) && $request->name != ''){
            $category->name = $request->name;
        }
        if(isset($request->description) && $request->description != ''){
            $category->description = $request->description;
        }
        if(isset($request->sort_order) && $request->sort_order != ''){
            $category->sort_order = $request->sort_order;
        }
        if(isset($request->status) && $request->status != ''){
            $category->status = $request->status;
        }

        if($category->save()){
            $response = [
                'status' => 'success',
                'message'=> 'Category is successfully updated'
            ];            
        }else{
            $response = [
                'status' => 'error',
                'message'=> 'Category is not update'
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
        $category = Category::find($id);

        if(isset($category->id)){

            $deleted = $category->delete();

            if($deleted == 1){
                $response = [
                    'status' => 'success',
                    'message'=> 'Category is successfully deleted'
                ];    
            }else{
                $response = [
                    'status' => 'error',
                    'message'=> 'Category is not delete'
                ];   
            }  
            
        }else{
            $response = [
                'status' => 'error',
                'message'=> 'Category is not delete'
            ];   
        }

        return response()->json($response);
    }

    public function sort($field,$order)
    {
        $categories = Category::where('status', '=', 'active')
                ->orderBy($field, $order)
                ->get();

        return response()->json($categories);
    }
}
