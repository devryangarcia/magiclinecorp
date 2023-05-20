<?php

namespace App\Http\Controllers;
use DB;
Use App\Models\AccessList;
Use App\Models\Product;
use Illuminate\Http\Request;
class PartnersController extends Controller
{
    function companylist(Request $request){
        $uid = session()->get('LoggedUser');
        $checkinfo = DB::table('users')
        ->where('id', 'like', $uid)
        ->get();
        foreach ($checkinfo as $check) {
            if($check->role=='admin1' || $check->role=='owner'){
                return redirect('/admin/dashboard');
            }
            elseif($check->role=='admin2'){
                return redirect('/admin/dashboard2');
            }
        }
        $accesslist = DB::table('access_lists')
        ->where('user_id', 'like', $uid)
        ->get();
        foreach($accesslist as $access){ 
            $delimiter = ",";
            $access_array = explode($delimiter, $access->accesslists);
            if(count($access_array)==1){
                $company = strtolower($access_array[0]);
                $company = $company;
                $selected = '';
                if ($request->categ_filter) {
                    $selected = $request->categ_filter;
                    $products = Product::where('company','=',strtoupper($company))->where('category','=',$request->categ_filter)->get();
                } else{
                $products = Product::where('company','=',strtoupper($company))->get();
                }
                return redirect()->route('company',compact('company','products'));
            }
            else {
                return view('companylist',['accesslists'=>$access_array]);
            }
        }
    }
    function company(Request $request, $company){
        $company = $company;
        $selected = '';
        if ($request->categ_filter) {
            $selected = $request->categ_filter;
            $products = Product::where('company','=',strtoupper($company))->where('category','=',$request->categ_filter)->get();
        } else{
        $products = Product::where('company','=',strtoupper($company))->get();
        }
        return view('company',compact('company','products','selected'));
    }
    function partneredcompany(){
        return view('partnerlist');
    }
    function adminaccesslists(){
        return view('admin-accesslist');
    }
    function props(){
        return view('props');
    }
    function accessories(){
        return view('accessories');
    }
}
