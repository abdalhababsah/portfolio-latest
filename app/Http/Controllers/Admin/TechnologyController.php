<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $technologies = Technology::orderBy('name_en')->get();
        return view('admin.technologies.index', compact('technologies'));
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
            'logo' => 'nullable|image|max:2048',
        ]);

        // Handle logo upload if present
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('technologies', 'public');
            $validated['logo'] = $path;
        }

        Technology::create($validated);

        return redirect()->route('admin.technologies.index')
            ->with('success', 'Technology added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function edit(Technology $technology)
    {
        return response()->json($technology);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Technology $technology)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        // Handle logo upload if present
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($technology->logo) {
                Storage::disk('public')->delete($technology->logo);
            }
            
            $path = $request->file('logo')->store('technologies', 'public');
            $validated['logo'] = $path;
        }

        $technology->update($validated);

        return redirect()->route('admin.technologies.index')
            ->with('success', 'Technology updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
        // Check if technology is associated with any projects
        if ($technology->projects()->count() > 0) {
            return redirect()->route('admin.technologies.index')
                ->with('error', 'Cannot delete technology because it is associated with projects');
        }

        // Delete logo if exists
        if ($technology->logo) {
            Storage::disk('public')->delete($technology->logo);
        }
        
        $technology->delete();

        return redirect()->route('admin.technologies.index')
            ->with('success', 'Technology deleted successfully');
    }
}