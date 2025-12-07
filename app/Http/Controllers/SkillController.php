<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
    public function index()
    {
        return view('skills.index', [
            'skills' => Skill::paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:skills,name'
        ]);

        Skill::create($request->only(['name']));

        return redirect()->route('skills.index')
            ->with('success', 'Skill created successfully.');
    }

    public function edit(Skill $skill)
    {
        return response()->json([
            'skill' => $skill
        ]);
    }

    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|unique:skills,name,' . $skill->id
        ]);

        $skill->update($request->only(['name']));

        return redirect()->route('skills.index')
            ->with('success', 'Skill updated successfully.');
    }

    public function show(Skill $skill)
    {
        return response()->json([
            'skill' => $skill
        ]);
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->route('skills.index')
            ->with('success', 'Skill deleted successfully.');
    }
}
