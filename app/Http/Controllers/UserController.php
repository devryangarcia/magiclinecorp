<?php

namespace App\Http\Controllers;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AccessList;
use App\Models\ActivityLog;
use App\Models\ResetRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Events\UserLoginEvent;
class UserController extends Controller
{
    function login(Request $request){
        return view('login');
    }
    function forgotpassword(){
        return view('forgotpassword');
    }
    function loginprocess(Request $request){
        //Validate requests
        $request->validate([
            'username'=>'required',
            'password'=>'required|min:5|max:12'
       ]);

       $user = User::where('username','=', $request->username)->first();

       if(!$user){
           return back()->with('fail','We do not recognize your username');
       }else{
           //check password
           if(Hash::check($request->password, $user->password)){
            if($user->status=='activated' && $user->archived==null){
                $request->session()->put('LoggedUser', $user->id);
				$request->session()->put('isUnlocked', true);
                Cookie::queue('user_id', $user->id, 60*24*7); // expires in 7 days
                $activity = 'Logged in';
                $timestamp = $this->getUserTimestamp($user);
                $this->logActivity($user, $activity, $timestamp);
                event(new UserLoginEvent($request->username));
                if ($user->role=='admin1' || $user->role=='owner') {
                    return redirect('admin/dashboard');
                } elseif ($user->role=='admin2') {
                    return redirect('admin/dashboard2');
                }
                else{
                    return redirect('/');
                }
            } else {
                return back()->with('fail','Your account is deactivated');
            }

           }else{
               return back()->with('fail','Incorrect password');
           }
       }
    }
    function adduser(){
        return view('adduser');
    }
    function edituser(Request $request){
        return view('editacct');
    }
    function saveuser(Request $request){
        
        $request->validate([
            'fname'=>'required|min:3',
            'lname'=>'required|min:3',
            'username'=>'required|min:4|unique:users',
            'email'=>'required|email|unique:users',
            'company'=>'required',
            'password'=>'required|min:5|max:20',
            'role'=>'required',
            'avatar'=>'required',
        ]);
        if($request->role=='admin2'||$request->role=='user'){
            $request->validate([
                'accesslists'=>'required',
            ]);
        }
        $user = new User;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->company = $request->company;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->status = "activated";
        $user->avatar = $request->avatar;
        $user->archived = null;
        $save = $user->save();


        if($save){
            $access = array();
            if($request->role!='admin1'){
                foreach ($request->input('accesslists') as $accesslist){
                    $access[] =$accesslist ;
                }
            } else {
                $access[] = 'ALL' ;
            }

            $user_info = DB::select('select * from users where username = ?',[$user->username]);
            $list = new AccessList();
            foreach ($user_info as $info) {
                $id = $info->id;
            }
            $list->user_id = $id;
            $list->accesslists = implode(",",$access);
            $save2 = $list->save();
            if($save2){
                return redirect('/admin/users')->with('success','New User has been successfuly!');
            }
         }else{
             return back()->with('fail','Something went wrong, try again later!');
         }
    }
    function user($id){
        $users = User::where('id','=',$id)->get();
        return view('updateuser',compact('users'));
        
        
    }
    function userupdate(Request $request){
        
        $request->validate([
            'fname'=>'required|min:3',
            'lname'=>'required|min:3',
            'username'=>'required|min:4',
            'email'=>'required',
            'company'=>'required',
            'password'=>'max:20',
            'role'=>'required',
            'status'=>'required',
            'avatar'=>'required',
        ]);
        
        
        $id = $request->id;
        $fname = $request->fname;
        $lname = $request->lname;
        $oldusername = $request->oldusername;
        $username = $request->username;
        $email = $request->email;
        $company = $request->company;
        $role = $request->role;
        $status = $request->status;
        $avatar = $request->avatar;
        $access = array();
        if($role=='admin2' || $role=='user'){
            $request->validate([
                'accesslists'=>'required',
            ]);
        }
        if ($role=='admin2' || $role=='user') {
            foreach ($request->input('accesslists') as $accesslist){
                $access[] = $accesslist;
            }
        } else{
            $access[] = 'ALL';
        }
        
        $checks = DB::select('select * from users where username = ?', [$username]);
        $checks2 = DB::select('select * from users where email = ?', [$email]);
        foreach ($checks as $check) {
            $check_id = $check->id;
            $check_username = $check->username;
        }
        foreach ($checks2 as $check2) {
            $check_id2 = $check2->id;
            $check_email2 = $check2->email;
        }
        if(!isset($check_id)){ $check_id = $id;}
        if(!isset($check_id2)){ $check_id2 = $id;}
        
        sort($access);
        if($id != $check_id){
            return back()->with('fail','Username is already taken by other users!');
        }
        elseif ($id != $check_id2) {
            return back()->with('fail','Email is already taken by other users!');
        }
        else {
            if($request->password!=''){
                $request->validate([
                    'password'=>'min:5|max:20',
                ]);
                $password = Hash::make($request->password);
                $save = DB::update('update users set fname = ?, lname = ?, username = ?, email = ?, company = ?, password = ?, role = ?,
                status = ?, avatar = ? where id = ?',[$fname,$lname,$username,$email,$company,$password,$role,$status,$avatar,$id]);
                $save2 = DB::update('update products set addedby = ? where addedby = ?',[$username,$oldusername]);
                $save3 = DB::update('update products set updatedby = ? where updatedby = ? ',[$username,$oldusername]);
                $save4 = AccessList::where('user_id',$id)->update(['accesslists' => implode(",",$access)]);
                return redirect('/admin/users')->with('success','Updated User Info Sucessfully!');
            } elseif(empty($request->password)) {
                $save = DB::update('update users set fname = ?, lname = ?, username = ?, email = ?, company = ?, role = ?,
                status = ?, avatar = ? where id = ?',[$fname,$lname,$username,$email,$company,$role,$status,$avatar,$id]);
                $save2 = DB::update('update products set addedby = ? where addedby = ?',[$username,$oldusername]);
                $save3 = DB::update('update products set updatedby = ? where updatedby = ? ',[$username,$oldusername]);
                $save4 = AccessList::where('user_id',$id)->update(['accesslists' => implode(",",$access)]);
                return redirect('/admin/users')->with('success','Updated User Info Sucessfully!');
            } else {
                return back()->with('fail','Something went wrong, try again later!');
            }
        }
    }
    function storeuserupdate(Request $request){
        $request->validate([
            'fname'=>'required|min:3',
            'lname'=>'required|min:3',
            'username'=>'required|min:4',
            'email'=>'required',
            'password'=>'max:20',
        ]);

    if(isset($request->id)){
        $id = $request->id;
        $fname = $request->fname;
        $lname = $request->lname;
        $oldusername = $request->oldusername;
        $username = $request->username;
        $email = $request->email;
        $avatar = $request->avatar;
        $checks = DB::select('select * from users where username = ?', [$username]);
        $checks2 = DB::select('select * from users where email = ?', [$email]);
        foreach ($checks as $check) {
            $check_id = $check->id;
            $check_username = $check->username;
        }
        foreach ($checks2 as $check2) {
            $check_id2 = $check2->id;
            $check_email2 = $check2->email;
        }
        if(!isset($check_id)){ $check_id = $id;}
        if(!isset($check_id2)){ $check_id2 = $id;}
        
        if($id != $check_id){
            return back()->with('fail','Username is already taken by other users!');
        }
        elseif ($id != $check_id2) {
            return back()->with('fail','Email is already taken by other users!');
        }
        else {
            if($request->password!=''){
                $request->validate([
                    'password'=>'min:5|max:20',
                ]);
                $password = Hash::make($request->password);
                $save = DB::update('update users set fname = ?, lname = ?, username = ?, email = ?, password = ?, avatar = ? where id = ?',[$fname,$lname,$username,$email,$password,$avatar,$id]);
                $save2 = DB::update('update products set addedby = ? where addedby = ?',[$username,$oldusername]);
                $save3 = DB::update('update products set updatedby = ? where updatedby = ? ',[$username,$oldusername]);

                return back()->with('success','Updated User Info Sucessfully!');
            } elseif(empty($request->password)) {
                $save = DB::update('update users set fname = ?, lname = ?, username = ?, email = ?, avatar = ? where id = ?',[$fname,$lname,$username,$email,$avatar,$id]);
                $save2 = DB::update('update products set addedby = ? where addedby = ?',[$username,$oldusername]);
                $save3 = DB::update('update products set updatedby = ? where updatedby = ? ',[$username,$oldusername]);
                return back()->with('success','Updated User Info Sucessfully!');
            } else {
                return back()->with('fail','Something went wrong, try again later!');
            }
        }
    } else {
        return back();
    }
    }
    function trash(Request $request){
        return view('trash');
    }
    function trashuser(Request $request){
        if(isset($request->id)){
            $user_id = $request->id;
            $archived = 1;
            $user = DB::update('update users set archived = ? where id = ?',[$archived, $user_id]);
            return redirect('/admin/users')->with('deleted','Account transfered to trash successfully!');
        } else {
            return back();
        }
    }
    function restoreuser(Request $request){
        if(isset($request->id)){
            $user_id = $request->id;
            $archived = null;
            $user = DB::update('update users set archived = ? where id = ?',[$archived, $user_id]);
            return redirect('/admin/trash')->with('success','Account restored successfully!');
        } else {
            return back();
        }
    }
    function userdelete(Request $request){
        if(isset($request->id)){
            $id = $request->id;
            $user = User::find($id);
            if($user->role !='owner'){
                $user->accessLists()->delete();
                $user->delete();
                return back()->with('deleted','Deleted User Sucessfully!');
            } else {
                return back()->with('deleted',"Owner's account cannot be deleted");
            }
        } else {
            return back();
        }
    }
    function resetpassrequest(Request $request){

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:5|max:20',
        ]);
        $username = $request->username;
        $password = $request->password;
        $password = Hash::make($password);
        $user = User::where('username','=', $request->username)->first();

        if(!$user){
           return back()->with('fail','We do not recognize your username');
        } else {
            $checkinfo = DB::table('reset_requests')->where('user_id','=',$user->id)->get();
            foreach ($checkinfo as $check) {
                echo $check->user_id;
            }
            if(isset($check->user_id)){
                return back()->with('fail','You already sent a request. Please wait for the approval.');
            }elseif(empty($check->user_id)) {
                $reset = new ResetRequest;
                $reset->user_id = $user->id;
                $reset->password = $password;
                $reset->save();
                return back()->with('success','We sent your request to the admin. Please wait for approval.');
            }
        }
        
    }
    function logout(){
        $user = User::find(session()->get('LoggedUser'));
        $activity = 'Logged out';
        $timestamp = $this->getUserTimestamp($user);
        $this->logActivity($user, $activity, $timestamp);
        Cookie::queue(Cookie::forget('user_id'));
        if(session()->get('Reason')){
            $reason = session()->get('Reason');
        }
        if(session()->get('LoggedUser')){
            session()->flush();
        }
        Auth::logout();
        if (!empty($reason)) {
            return redirect('login')->with('fail','Your account was deactivated!');
        } else{
            return redirect('login');
        }
    }
    private function getUserTimestamp($user)
    {
        $timezone = $user->timezone; // assume user timezone is stored in the 'timezone' column of the users table
        $userTime = new Carbon('now', $timezone);
        return $userTime->toDateTimeString();
    }

    private function logActivity($user, $activity, $timestamp)
    {
        $log = new ActivityLog;
        $log->user_id = $user->id;
        $log->activity = $activity;
        $log->timestamp = $timestamp;
        $log->save();
    }
    function lockscreen(){
        session()->put('isUnlocked', false);
        $uid = session()->get('LoggedUser');
        $user = User::find($uid);
        return view('lockscreen',compact('user'));
    }
    function unlock(Request $request){
        $request->validate([
            'password'=>'required|min:5|max:20'
       ]);

        $user = User::where('id','=', $request->id)->first();
        if(Hash::check($request->password, $user->password)){
            $request->session()->put('isUnlocked', true);
            return redirect('/');
        } else {
           return back()->with('fail', 'The password you entered is incorrect.');
        }
    }
}
