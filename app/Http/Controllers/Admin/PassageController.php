<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Passage;
use App\Models\ReadingTest;
use Illuminate\Http\Request;

class PassageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ReadingTest $reading_test)
    {
        $passages = $reading_test->passages()->orderBy('sort_order')->get();

        return view('admin.passages.index', compact('reading_test', 'passages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ReadingTest $reading_test)
    {
        return view('admin.passages.create', compact('reading_test'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ReadingTest $reading_test)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'instruction' => ['nullable', 'string'],
            'display_mode' => ['required', 'in:plain,labeled,smart'],
            'sort_order' => ['nullable', 'integer', 'min:1'],
        ]);

        $data['reading_test_id'] = $reading_test->id;
        $data['sort_order'] = $data['sort_order'] ?? ($reading_test->passages()->max('sort_order') + 1);

        Passage::create($data);

        return redirect()
            ->route('reading-tests.passages.index', $reading_test)
            ->with('success', 'Passage created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ReadingTest $reading_test, Passage $passage)
    {
        $this->ensurePassageBelongsToTest($reading_test, $passage);

        return view('admin.passages.show', compact('reading_test', 'passage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReadingTest $reading_test, Passage $passage)
    {
        $this->ensurePassageBelongsToTest($reading_test, $passage);

        return view('admin.passages.edit', compact('reading_test', 'passage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReadingTest $reading_test, Passage $passage)
    {
        $this->ensurePassageBelongsToTest($reading_test, $passage);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'instruction' => ['nullable', 'string'],
            'display_mode' => ['required', 'in:plain,labeled,smart'],
            'sort_order' => ['nullable', 'integer', 'min:1'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? $passage->sort_order;

        $passage->update($data);

        return redirect()
            ->route('reading-tests.passages.index', $reading_test)
            ->with('success', 'Passage updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReadingTest $reading_test, Passage $passage)
    {
        $this->ensurePassageBelongsToTest($reading_test, $passage);

        $passage->delete();

        return redirect()
            ->route('reading-tests.passages.index', $reading_test)
            ->with('success', 'Passage deleted successfully.');
    }

    /**
     * Ensure the passage belongs to the given reading test.
     */
    private function ensurePassageBelongsToTest(ReadingTest $reading_test, Passage $passage): void
    {
        abort_if($passage->reading_test_id !== $reading_test->id, 404);
    }
}