<?php
 
namespace App\Http\Controllers\Api\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Exception;
 
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->default_response;
 
        try {
            $categories = Category::all();
           
            $response['success'] = true;
            $response['data'] = $categories;
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
    public function store(StoreCategoryRequest $request)
    {
        $response = $this->default_response;
 
        try{
            $data = $request->validated();
 
            $category = new Category();
            $category->name = $data['name'];
            $category->description = $data['description'];
            $category->save();
 
            $response['success'] = true;
            $response['data'] = [
                'category' => $category
            ];
            $response['message'] = 'Category created successfully';
        }catch(Exception $e){
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }
 
        return response()->json($response);
   
    }
 
    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $response = $this->default_response;
 
        try{
            $category = Category::find($id);
 
            $response['success'] = true;
            $response['message'] = 'Get Category success';
            $response['data'] = [
                'category' => $category
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
    public function edit(Category $category)
    {
        //
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, String $id)
    {
        $response = $this->default_response;
 
        try{
            $data = $request->validated();
 
            $category = Category::find($id);
            $category->name = $data['name'];
            $category->description = $data['description'];
            $category->save();
 
            $response['success'] = true;
 
            $response['message'] = 'Category Updated successfully';
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
            $category = Category::find($id);
            $category->delete();
 
            $response['success'] = true;
            $response['message'] = 'Category deleted successfully';
        }catch(Exception $e){
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }
 
        return response()->json($response);
    }
}