<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpeakingTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpeakingTopicController extends Controller
{
    public function index()
    {
        $topics = SpeakingTopic::latest()->paginate(10);

        return view('admin.speaking-topics.index', compact('topics'));
    }

    public function create()
    {
        return view('admin.speaking-topics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        SpeakingTopic::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . time(),
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.speaking-topics.index')
            ->with('success', 'Speaking topic created successfully.');
    }

    public function show(SpeakingTopic $speakingTopic)
    {
        return view('admin.speaking-topics.show', compact('speakingTopic'));
    }

    public function edit(SpeakingTopic $speakingTopic)
    {
        return view('admin.speaking-topics.edit', compact('speakingTopic'));
    }

    public function update(Request $request, SpeakingTopic $speakingTopic)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $speakingTopic->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . $speakingTopic->id,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.speaking-topics.index')
            ->with('success', 'Speaking topic updated successfully.');
    }

    public function destroy(SpeakingTopic $speakingTopic)
    {
        $speakingTopic->delete();

        return redirect()
            ->route('admin.speaking-topics.index')
            ->with('success', 'Speaking topic deleted successfully.');
    }
}