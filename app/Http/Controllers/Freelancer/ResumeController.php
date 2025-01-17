<?php 
namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use App\Models\Skill;

class ResumeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $resumes = auth()->user()->resumes;

        return view('freelancer.dashboard', compact('categories', 'resumes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|string|in:published,draft',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'category' => 'required|exists:categories,id',
            'skills' => 'nullable|string',
        ]);
    
        // Сохраняем основные данные резюме
        $data = $request->only('title', 'content', 'status');
    
        if ($request->hasFile('file')) {
            try {
                $data['file_path'] = $request->file('file')->store('resumes_files', 'public');
            } catch (\Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                return back()->with('error', 'File upload failed. Please try again.');
            }
        }
    
        // Создаём резюме
        $resume = auth()->user()->resumes()->create($data);
    
        // Привязываем категорию
        $resume->categories()->sync([$request->category]);
    
        // Привязываем скиллы
        if ($request->skills) {
            $skillIds = collect(explode(',', $request->skills))->map(function ($skillName) use ($request) {
                return Skill::firstOrCreate(['name' => $skillName, 'category_id' => $request->category])->id;
            });
            $resume->skills()->sync($skillIds);
        }
    
        return redirect()->route('freelancer.dashboard')->with('success', 'Resume created successfully!');
    }
    
    
    

    public function edit($id)
    {
        $resume = Resume::findOrFail($id);

        return view('freelancer.edit-resume', compact('resume'));
    }

    public function update(Request $request, $id)
    {
        $resume = Resume::findOrFail($id);
    
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|string|in:published,draft',
        ]);
    
        $resume->update($request->only('title', 'content', 'status'));
    
        return redirect()->route('freelancer.dashboard')->with('success', 'Resume updated successfully!');
    }
    
}
