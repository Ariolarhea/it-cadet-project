<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function index()
    {  
        return view('reports.index');
    }

    public function create() 
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required', 
            'detail' => 'required',
            'date_posted' => 'required',
            'posted_by' => 'required',
        ]);
  
        Report::create($request->all()); 
   
        return redirect()->route('reports.index')->with('success','Post created successfully.');
    }

   
    public function show(Report $report) 
    {
        return view('reports.show',compact('report')); 
    }

    public function edit(Report $report)
    {
        return view('reports.edit',compact('report')); 
    }

    public function update(Request $request, Report $report)
    {
        $request->validate([
            'title' => 'required', 
            'detail' => 'required',
            'date_posted' => 'required',
            'posted_by' => 'required',
        ]);
  
        $report->update($request->all()); 
  
        return redirect()->route('reports.index')->with('success','*Post updated successfully');
    }

    public function destroy(Report $report)
    {
        $report->delete();
  
        return redirect()->route('reports.index')->with('success','Post deleted successfully');
    }
}
