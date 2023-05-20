<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BugReport;
use App\Models\User;
class BugReportController extends Controller
{
    function index(){
        return view('bugreports');
    }
    function reportedbugs(){
        return view('reportedbugs');
    }
    function readbugreport($id){
        $report = BugReport::find($id);
        $reportsender = User::find($report->user_id);
        return view('readbugreport',compact('report','reportsender'));
    }
    function savereport(Request $request){
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'attachment' => 'nullable|max:35000',
        ]);
        if($request->user_id){
            // Create a new BugReport instance
            $bugReport = new BugReport();

            // Set the values for other columns
            $bugReport->user_id = $request->input('user_id');
            $bugReport->title = $request->input('title');
            $bugReport->description = $request->input('description');
            $bugReport->status = "open";
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('public/bugreport_attachments/'.$name);
                $bugReport->attachment = $name;
            }
            // Save the bug report (this will automatically set the created_at timestamp)
            $bugReport->save();
            return back()->with('success','Bug report was sent!');
        } else {
            return back();
        }
    }
    function updatereport(Request $request){
        if($request->report_id){
            // Retrieve an existing BugReport instance
            $bugReport = BugReport::find($request->report_id);

            if ($bugReport) {
                // Update the bug report and automatically set the updated_at timestamp
                $bugReport->status = $request->status;
                $bugReport->save();

                // Other actions or responses after successful update
                return back()->with('success', 'Bug report status was change');
            } else {
                // Bug report not found, handle the error
                return back()->with('fail', 'Something went wrong. Please try again later!');
            }
        } else {
            return back();
        }
    }
}
