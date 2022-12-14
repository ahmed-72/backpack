<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::with('categories','vendor','options')->paginate(10);
        return response($products);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Product::with('categories','vendor','options')->findOrFail($id);
        return response($product);
    }

   /**
     * Display the specified resource from seacrh bar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if ($request['name_en']) {
            $search_input = '%' . $request['name_en'] . '%';
            $products = Product::where('name_en', 'like', $search_input)->orderBy('created_at', 'DESC')->limit(20)->get();
            if (count($products)>0)  return response($products);
            return response('can not find any field about data you entered !');
        }
        else if($request['name_ar']) {
            $search_input = '%' . $request['name_ar'] . '%';
            $products = Product::where('name_ar', 'like', $search_input)->orderBy('created_at', 'DESC')->limit(20)->get();
            if (count($products)>0)  return response($products);
            return response('لا يوجد أي أصناف بالاسم الذي أدخلته !');
        }
    }
}
