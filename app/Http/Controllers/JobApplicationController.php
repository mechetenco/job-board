<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
   

    /**
     * Show the form for creating a new resource.
     */
    public function create(Job $job)
     {

        Gate::authorize('apply', $job);

         return view('job_application.create', ['job' => $job]);
     }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Job $job,Request $request)
    {

        Gate::authorize('apply', $job);

        $validatedData = $request->validate([
            'expected_salary' => 'required|min:1|max:1000000',
            'cv' => 'required|file|mimes:pdf|max:2048'
        ]);

        $file = $request->file('cv');
        $path = $file->store('cvs', 'private');

        $job->jobApplications()->create([
            'user_id' => $request->user()->id,
            'expected_salary' => $validatedData['expected_salary'],
             'cv_path' => $path
        ]);

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Job application submitted.');
    }


    public function downloadCv(JobApplication $application)
{
    //Gate::authorize('view', $application); // Optional: protect access

    if (!$application->cv_path || !Storage::disk('private')->exists($application->cv_path)) {
        abort(404, 'CV not found.');
    }

    return Storage::disk('private')->download($application->cv_path);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
