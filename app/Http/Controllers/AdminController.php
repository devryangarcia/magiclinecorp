<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\AccessList;
use App\Models\Partners;
use App\Models\ResetRequest;
use App\Models\User;

class AdminController extends Controller
{
    function dashboard(){
        $data = ['LoggedUserInfo'=>User::where('id','=', session('LoggedUser'))]->first();
        return view('admin-dashboard',$data);
    }

    function addcompany(){
        return view('addcompany');
    }
    function partners(){
        return view('partners');
    }

    function storecomp (Request $request){
        $request->validate([
            'company'=>'required|unique:partners',
            'logo' => 'required|image|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg+xml|max:50000',
        ]);
        if ($request->hasFile('logo')) {
            $name = $request->file('logo')->getClientOriginalName();
            $path = $request->file('logo')->storeAs('public/company_logos', $name);
            $logo = $name;
        }
        $partner = new Partners;
        $partner->company = strtoupper($request->company);
        $partner->logo = $logo;
        $save = $partner->save();
        if($save){
            return redirect('/admin/partners')->with('success','New Company has been successfuly');
         }else{
             return back()->with('fail','Something went wrong, try again later');
        }
    }
    
    function compupdate(){
        return view('updatecomp');
    }
    public function storecompupdate(Request $request, $id)
    {
        $request->validate([
            'company'=>'required',
            'logo' => 'nullable|image|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg+xml|max:50000',
        ]);
        $partner = Partners::find($id);
        $oldImage = $partner->logo;
        $oldcompany = $request->oldcompany;
        $partner->company = strtoupper($request->company);
        if ($request->hasFile('logo')) {
            $name = $request->file('logo')->getClientOriginalName();
            $path = $request->file('logo')->storeAs('public/company_logos', $name);
            $logo = $name;
            $partner->logo = $logo;

            if ($oldImage && file_exists(public_path('public/company_logos/' . $oldImage))) {
                unlink(public_path('public/company_logos/' . $oldImage));
            }
        }
        $save = $partner->update();
        if($save){
            $save2 = DB::update('update products set company= ? where company = ?',[strtoupper($request->company),$oldcompany]);
            return redirect('/admin/partners')->with('success','Company has been updated successfuly');
        }else{
            return back()->with('fail','Something went wrong, try again later');
        }
    }
    function trashcompany(){
        return view('trashcompany');
    }
    function restorecomp(Request $request){
        if (isset($request->id)) {
            $partner = Partners::find($request->id);
            $partner->archived = null;
            $partner->save();
            return redirect('/admin/trashcompany')->with('success','Company restored sucessfully');
            
        } else {
            return back();
        }
    }
    function trashcomp(Request $request){
        if (isset($request->id)) {
            $partner = Partners::find($request->id);
            $partner->archived = 1;
            $partner->save();
            return redirect('/admin/partners')->with('deleted','Company transfered to trash sucessfully');
            
        } else {
            return back();
        }
    }
    function compdelete(Request $request){
        if (isset($request->id)) {
            $id = $request->id;
            Partners::find($id)->delete();
            return back()->with('deleted','Company deleted sucessfully');
        } else {
            return back();
        }
    }
    function userrequest(){
        return view('userrequest');
    }
    function grantrequest(Request $request){
        $requestinfos = DB::select('select * from reset_requests where user_id = ?',[$request->uid]);
        foreach ($requestinfos as $requestinfo) {
           $user_id = $requestinfo->user_id;
           $password = $requestinfo->password;
        }
        $save = User::where('id','=',$user_id)->update(['password'=>$password]);
        if($save){
            $delete = ResetRequest::where('user_id','=',$user_id)->delete();
            if ($delete) {
                return redirect('admin/userrequest')->with('success','User request granted sucessfully');
            }
        }
    }
    function removerequest(Request $request){
        
        $requestinfos = DB::select('select * from reset_requests where user_id = ?',[$request->uid]);
        foreach ($requestinfos as $requestinfo) {
           $user_id = $requestinfo->user_id;
           $password = $requestinfo->password;
        }
        $save = ResetRequest::where('user_id','=',$user_id)->delete();
        if($save){
            return redirect('admin/userrequest')->with('deleted','User request rejected sucessfully');
        }
    }
    function activitylogs(){
        return view('activitylogs');
    }
}
