<?php
namespace App\Http\Controllers;

use App\Models\Resume;

class ResumeController extends Controller
{
    public function index()
    {
        $resumes = Resume::where('status', 'published')->get();

        return view('resumes.index', compact('resumes'));
    }
}

