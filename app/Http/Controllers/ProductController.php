<?php
namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Price;
use App\Models\Product;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    function products(){
        return view('products');
    }
    function partnerproduct(Request $request, $company){
        $company = $company;
        $selected = '';
        if ($request->categ_filter) {
            $selected = $request->categ_filter;
            $products = Product::where('company','=',strtoupper($company))->where('category','=',$request->categ_filter)->get();
        } else{
        $products = Product::where('company','=',strtoupper($company))->whereNull('archived')->get();
        }
        return view('partnerproduct',compact('products','company','selected'));
        
    }
    function addproducts(Request $request){
        $company = $request->company;
       return view('addproducts',compact('company'));
    }
    function editproducts($id){
        $product = Product::find($id);
        return view('editproducts',compact('product'));
    }
    function trashproduct(Request $request){
        $company = $request->company;
       return view('trashproduct',compact('company'));
    }
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(),[
            'po' => 'nullable|unique:products',
            'itemref' => 'required|unique:products',
            'company' => 'required|string',
            'category' => 'required|string',
            'type' => 'required|string',
            'price' => 'nullable|string',
            'description' => 'required',
            'images.*' => 'required|mimes:jpeg,png,jpg|max:50000',
            'costing' => 'nullable|mimes:xls,xlsx|max:50000',
            'priceaccess' => 'nullable',
        ]);

        $LoggedUser = session()->get('LoggedUser');
        $userdata = User::find($LoggedUser);
        $images = [];
        $temporaryImages = TemporaryFile::all();
        if ($validatedData->fails()) {
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('public/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }
            return back()->withErrors($validatedData)->withInput();
        }
        foreach ($temporaryImages as $temporaryImage) {
            Storage::copy('public/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file, 'public/product_images/'. $temporaryImage->file);
            $images[] = $temporaryImage->file;
            Storage::deleteDirectory('public/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }
        sort($images);
        $product = Product::create([
            'po' => $request->input('po'),
            'itemref' => $request->input('itemref'),
            'company' => $request->input('company'),
            'category' => $request->input('category'),
            'type' => $request->input('type'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'images' => implode(",",$images),
            'addedby' => $userdata->username,
        ]);
        if(isset($request->priceaccess)){
        foreach ($request->priceaccess as $access) {
            $price = Price::create([
                'itemref' => $request->input('itemref'),
                'user_id' => $access,
            ]);
        }
        }
        
        
        return redirect('/admin/partnerproduct/'.strtolower($request->input('company')))->with('success','Product Added Successfully');
    }
    
    function storeupdateproducts(Request $request){
        $validatedData = Validator::make($request->all(),[
            'po' => 'nullable',
            'itemref' => 'required',
            'company' => 'required|string',
            'category' => 'required|string',
            'price' => 'nullable|string',
            'type' => 'required|string',
            'description' => 'required',
            'images.*' => 'required|mimes:jpeg,png,jpg|max:50000',
            'costing' => 'nullable|mimes:xls,xlsx|max:50000',
            'priceaccess' => 'nullable',
        ]);

        $LoggedUser = session()->get('LoggedUser');
        $userdata = User::find($LoggedUser);
        $images = [];
        $temporaryImages = TemporaryFile::all();
        if ($validatedData->fails()) {
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('public/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }
            return back()->withErrors($validatedData)->withInput();
        }
        $checks = DB::table('products')->where('po','=',$request->po)->get();
        $checks2 = DB::table('products')->where('itemref','=',$request->itemref)->get();
        foreach ($checks as $check) {
            $check_id = $check->id;
        }
        foreach ($checks2 as $check2) {
            $check_id2 = $check2->id;
        }
        if(!isset($check_id)){ $check_id = $request->id;}
        if(!isset($check_id2)){ $check_id2 = $request->id;}
        if ($request->id != $check_id) {
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('public/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }
            return back()->with('fail','PO is already taken by other product');
        } elseif ($request->id != $check_id2) {
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('public/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }
            return back()->with('fail','Item Reference is already taken by other product');
        } else {
        $LoggedUser = session()->get('LoggedUser');
        $userdata = User::find($LoggedUser);
        $images = [];
        $costingname = null;
        $temporaryImages = TemporaryFile::all();
        if ($validatedData->fails()) {
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('public/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }
            return back()->withErrors($validatedData)->withInput();
        }
        foreach ($temporaryImages as $temporaryImage) {
            Storage::copy('public/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file, 'public/product_images/'. $temporaryImage->file);
            $images[] = $temporaryImage->file;
            Storage::deleteDirectory('public/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }
        if (!empty($request->file('costing'))) {
            $costingname = $request->file('costing')->getClientOriginalName();
            $filepath = $request->file('costing')->storeAS('public/product_files',$costingname);
        }
        if($images){
            $product = Product::whereId($request->id)->update([
                'po' => $request->input('po'),
                'itemref' => $request->input('itemref'),
                'company' => $request->input('company'),
                'category' => $request->input('category'),
                'type' => $request->input('type'),
                'price' => $request->input('price'),
                'description' => $request->input('description'),
                'images' => implode(",",$images),
                'file' => $request->input('costing'),
                'file' => $costingname,
                'updatedby' => $userdata->username,
            ]);
            
            $checkprice = Price::where('itemref','=',$request->input('itemref'))->get();
            $priceaccess = [];
            if(count($checkprice)==0){
                foreach ($request->priceaccess as $access) {
                    $priceaccess[]=$access;
                }
                $price = Price::create([
                    'itemref' => $request->input('itemref'),
                    'user_id' => implode(',',$priceaccess),
                ]);
            } else{
                foreach ($request->priceaccess as $access) {
                    $priceaccess[]=$access;
                }
                $price = Price::where('itemref','=',$request->input('itemref'))->update([
                    'itemref' => $request->input('itemref'),
                    'user_id' => implode(',',$priceaccess),
                ]);
            }
        } else {
            $product = Product::whereId($request->id)->update([
                'po' => $request->input('po'),
                'itemref' => $request->input('itemref'),
                'company' => $request->input('company'),
                'category' => $request->input('category'),
                'type' => $request->input('type'),
                'price' => $request->input('price'),
                'description' => $request->input('description'),
                'file' => $costingname, 
                'updatedby' => $userdata->username,
            ]);
            $checkprice = Price::where('itemref','=',$request->input('itemref'))->get();
            $priceaccess = [];
            if(!empty($request->priceaccess)){
                if(count($checkprice)==0){
                    foreach ($request->priceaccess as $access) {
                        $priceaccess[]=$access;
                    }
                    $price = Price::create([
                        'itemref' => $request->input('itemref'),
                        'user_id' => implode(',',$priceaccess),
                    ]);
                } else{
                    foreach ($request->priceaccess as $access) {
                        $priceaccess[]=$access;
                    }
                    $price = Price::where('itemref','=',$request->input('itemref'))->update([
                        'itemref' => $request->input('itemref'),
                        'user_id' => implode(',',$priceaccess),
                    ]);
                }
            } else {
                if(count($checkprice)==0){
                    $price = Price::create([
                        'itemref' => $request->input('itemref'),
                        'user_id' => null,
                    ]);
                } else{
                    $price = Price::where('itemref','=',$request->input('itemref'))->update([
                        'itemref' => $request->input('itemref'),
                        'user_id' => null,
                    ]);
                }
            }
        }
        
        return redirect('/admin/partnerproduct/'.strtolower($request->input('company')))->with('success','Updated Product Infomations Sucessfully!');
        }
    }
    function trash(Request $request){
        if(isset($request->id)){
            $product = Product::whereId($request->id)->update([
                'archived' => 1,
            ]);
            return redirect('/admin/partnerproduct/'.strtolower($request->company))->with('deleted','Product transfered to trash successfully!!');
        } else {
            return back();
        }
    }
    function restoreproduct(Request $request){
        if(isset($request->id)){
            $product = Product::whereId($request->id)->update([
                'archived' => null,
            ]);
            if($product){
                return redirect('/admin/trashproduct')->with('success','Product restored sucessfully!');
            }
        } else {
            return back();
        }
    }
    function deleteproduct(Request $request){
        if(isset($request->id)){
            $product = Product::find($request->id)->delete();
            if($product){
                return redirect('/admin/trashproduct')->with('deleted','Product permanently deleted successfuly!');
            }
        } else {
            return back();
        }
    }
    public function tmpUpload(Request $request){
        if ($request->hasFile('images')) {
            $folder = uniqid('product',true);
            $images = $request->file('images');
            $name = $images->getClientOriginalName();
            $path = $images->storeAs('public/tmp/'.$folder, $name);
            TemporaryFile::create([
                'folder' => $folder,
                'file' => $name,
            ]);
            return $folder;
        }
        return '';
        
    }
    public function tmpDelete(Request $request){
        $temporaryImage = TemporaryFile::where('folder', request()->getContent())->first();
        if ($temporaryImage) {
            Storage::deleteDirectory('public/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }
        
        return response('');
    }
}
