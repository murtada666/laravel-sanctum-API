<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // When creating a Controller instead of (php artisan make:controller ProductController) we can use(php artisan make:controller ProductController --api) to contract the CRUD function for us. 

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        // This part will return a nicely formatted error massage.
        $request->validate([
            'name' => 'required', 
            'slug' => 'required',
            'description' => 'required',
        ]);
        /*
            - When creating a POST Request you should:
                * Go to headers in Postman and assign the key(accept) and the value(application/json)
        */
        // all() will bring all the data in the request
        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::find($id);  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = product::find($id);

        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // if(!Product::find($id)) {
        //     return "Item not exist";
        // }
        return Product::destroy($id);
        // return "Deleted";
    }

    /**
     * Search for a name.
     */
    public function search(string $name)
    {
        return Product::where('name','like', '%' . $name . '%')->get();
        
        // This form needs the whole name to get the item
        // return Product::where('name', $name)->get();
    }
}
