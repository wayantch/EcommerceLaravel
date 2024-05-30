<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->default_response;
 
        try {
            $products = Product::all();
           
            $response['success'] = true;
            $response['data'] = $products;
        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }
 
 
        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        {
            $response = $this->default_response;
     
            try {

                if ($request->hasFile('image')) {
                    $file = $request->file('image');
    
                    $path = $file->storeAs('project-images', $file->hashName(), 'public');
                }

                $data = $request->validated();

                $product = new Product();
                $product->name = $data['name'];
                $product->description = $data['description'];
                $product->stock = $data['stock'];
                $product->price = $data['price'];
                $product->image = $path ?? null;
                $product->category_id = $data['category_id'];
                $product->save();
               
                $response['success'] = true;
                $response['data'] = [
                    'product' => $product
                ];
            } catch (Exception $e) {
                $response['success'] = false;
                $response['message'] = $e->getMessage();
            }
     
     
            return response()->json($response);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $response = $this->default_response;
 
        try{

            $products = Product::with('product')->find($id);
 
            $response['success'] = true;
            $response['message'] = 'Get Category success';
            $response['data'] = [
                'product' => $products
            ];  
        }catch(Exception $e){
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }
 
        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, String $id)
    {
        $response = $this->default_response;
 
        try{
            if ($request->hasFile('image')) {
                $file = $request->file('image');
    
                $path = $file->storeAs('project-images', $file->hashName(), 'public');
            }

            $data = $request->validated();
 
            $product = Product::find($id);
            $product->name = $data['name'];
            $product->description = $data['description'];
            $product->stock = $data['stock'];
            $product->price = $data['price'];
            if($request->hasFile('image')) $product->image = $path ?? null;
            $product->category_id = $data['category_id'];
            $product->save();
 
            $response['success'] = true;
            $response['message'] = 'Product Updated successfully';
            $response['data'] = [
                'product' => $product
            ];
 
        }catch(Exception $e){
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }
        
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $response = $this->default_response;
       
        try{
            $product = Product::find($id);
            $product->delete();
 
            $response['success'] = true;
            $response['data'] = [
                'product' => $product
            ];
            $response['message'] = 'Product deleted successfully';
        }catch(Exception $e){
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }
 
        return response()->json($response);
    }
}
