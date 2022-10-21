<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Report;

class ReportApiController extends Controller
{
    public function index()
    {
        return Report::with('attachment')->orderBy('id','desc')->paginate(5);
    }

    public function store(Request $request)
    {
        $request ->validate([
            'title'=> 'required',
            'detail'=> 'required',
            'date_posted'=> 'required',
            'posted_by'=> 'required',
            'attachment' => 'mimes:jpeg,bmp,png,gif,tiff,svg,pdf|max:10240'
        ]);
       
        $report = Report::create($request->all());
        $path = $request->file('attachment')->store('attachments','public');
        $report->attachment()->create([
            'path' => $path
        ]);

        return $report->load('attachment');

    }

       public function show($id)
    {
        //
    }

   
    public function update(Request $request, Report $report)
    {
        $request->validate([
            'title'=> 'required',
            'detail'=>'required',
            'date_posted'=>'required',
            'posted_by'=>'required',
        ]);

        $report->title = $request->title;
        $report->detail = $request->detail;
        $report->date_posted =$request->date_posted;
        $report->posted_by = $request->posted_by;
        $report->save();

        return $report;

    }

    public function destroy(Report $report)
    {
        $report->delete();
        return $report;
    }
}
