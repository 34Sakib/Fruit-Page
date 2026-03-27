<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutContent = AboutUs::first();
        $teamMembers = TeamMember::ordered()->get();
        
        return view('admin.about-us.index', compact('aboutContent', 'teamMembers'));
    }

    public function edit()
    {
        $aboutContent = AboutUs::first();
        
        return view('admin.about-us.edit', compact('aboutContent'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            'hero_icon' => 'required|string|max:50',
            'happy_customers' => 'required|integer|min:0',
            'deliveries_made' => 'required|integer|min:0',
            'local_farms' => 'required|integer|min:0',
            'years_excellence' => 'required|integer|min:0',
            'mission_title' => 'required|string|max:255',
            'mission_subtitle' => 'required|string',
            'feature1_title' => 'required|string|max:255',
            'feature1_text' => 'required|string',
            'feature1_icon' => 'required|string|max:50',
            'feature2_title' => 'required|string|max:255',
            'feature2_text' => 'required|string',
            'feature2_icon' => 'required|string|max:50',
            'feature3_title' => 'required|string|max:255',
            'feature3_text' => 'required|string',
            'feature3_icon' => 'required|string|max:50',
            'team_title' => 'required|string|max:255',
            'team_subtitle' => 'required|string',
            'values_title' => 'required|string|max:255',
            'values_subtitle' => 'required|string',
            'value1_title' => 'required|string|max:255',
            'value1_text' => 'required|string',
            'value2_title' => 'required|string|max:255',
            'value2_text' => 'required|string',
            'value3_title' => 'required|string|max:255',
            'value3_text' => 'required|string',
            'cta_title' => 'required|string|max:255',
            'cta_text' => 'required|string',
            'cta_button_text' => 'required|string|max:255',
            'cta_button_url' => 'required|string|max:255',
            'cta_button_icon' => 'required|string|max:50',
        ]);

        $aboutContent = AboutUs::first();
        
        if (!$aboutContent) {
            $aboutContent = AboutUs::create($request->all());
        } else {
            $aboutContent->update($request->all());
        }

        return redirect()->route('admin.about-us.index')
            ->with('success', 'About Us content updated successfully!');
    }

    // Team Members Management
    public function teamIndex()
    {
        $teamMembers = TeamMember::ordered()->get();
        return view('admin.about-us.team.index', compact('teamMembers'));
    }

    public function teamShow(TeamMember $teamMember)
    {
        return view('admin.about-us.team.show', compact('teamMember'));
    }

    public function teamCreate()
    {
        return view('admin.about-us.team.create');
    }

    public function teamStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'integer|min:0',
            'status' => 'boolean',
        ]);

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('team-members', $imageName, 'public');
            $data['image_path'] = 'team-members/' . $imageName;
        }

        TeamMember::create($data);

        return redirect()->route('admin.about-us.team.index')
            ->with('success', 'Team member added successfully!');
    }

    public function teamEdit(TeamMember $teamMember)
    {
        return view('admin.about-us.team.edit', compact('teamMember'));
    }

    public function teamUpdate(Request $request, TeamMember $teamMember)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'integer|min:0',
            'status' => 'boolean',
        ]);

        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($teamMember->image_path) {
                $oldImagePath = storage_path('app/public/' . $teamMember->image_path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('team-members', $imageName, 'public');
            $data['image_path'] = 'team-members/' . $imageName;
        }

        $teamMember->update($data);

        return redirect()->route('admin.about-us.team.index')
            ->with('success', 'Team member updated successfully!');
    }

    public function teamDestroy(TeamMember $teamMember)
    {
        $teamMember->delete();

        return redirect()->route('admin.about-us.team.index')
            ->with('success', 'Team member deleted successfully!');
    }

    public function teamToggleStatus(TeamMember $teamMember)
    {
        $teamMember->status = !$teamMember->status;
        $teamMember->save();

        return response()->json([
            'success' => true,
            'status' => $teamMember->status
        ]);
    }
}
