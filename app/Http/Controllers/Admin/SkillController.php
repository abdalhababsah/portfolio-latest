<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = Skill::with('category')->orderBy('name_en')->get();
        $categories = Category::orderBy('name_en')->get();
        return view('admin.skills.index', compact('skills', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'level' => 'required|integer|min:1|max:100',
            'category_id' => 'required|exists:categories,id',
            'icon' => 'nullable|image|max:2048',
        ]);

        // Handle icon upload if present
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('skills', 'public');
            $validated['icon'] = $path;
        }

        Skill::create($validated);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    {
        return response()->json($skill);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'level' => 'required|integer|min:1|max:100',
            'category_id' => 'required|exists:categories,id',
            'icon' => 'nullable|image|max:2048',
        ]);

        // Handle icon upload if present
        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($skill->icon) {
                Storage::disk('public')->delete($skill->icon);
            }
            
            $path = $request->file('icon')->store('skills', 'public');
            $validated['icon'] = $path;
        }

        $skill->update($validated);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        // Delete icon if exists
        if ($skill->icon) {
            Storage::disk('public')->delete($skill->icon);
        }
        
        $skill->delete();

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill deleted successfully');
    }
}