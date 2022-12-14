<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::with('categories', 'products', 'products.options')->paginate(10);
        return response($vendors);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendor = Vendor::with('categories', 'products', 'products.options')->findOrFail($id);
        return response($vendor);
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
            $vendors = Vendor::where('name_en', 'like', $search_input)->orderBy('created_at', 'DESC')->limit(20)->get();
            if (count($vendors)>0)  return response($vendors);
            return response('can not find any field about data you entered !');
        }
        else if($request['name_ar']) {
            $search_input = '%' . $request['name_ar'] . '%';
            $vendors = Vendor::where('name_ar', 'like', $search_input)->orderBy('created_at', 'DESC')->limit(20)->get();
            if (count($vendors)>0)  return response($vendors);
            return response('لا يوجد أي مطاعم بالاسم الذي أدخلته !');
        }
    }
}
