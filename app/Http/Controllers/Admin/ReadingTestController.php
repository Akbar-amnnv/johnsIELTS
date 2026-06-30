<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReadingTest;
use Illuminate\Http\Request;

class ReadingTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tests = ReadingTest::latest()->paginate(10);

        return view('admin.reading-tests.index', compact('tests'));
    }

    public function create()
    {
        return view('admin.reading-tests.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'module_type' => ['required', 'in:academic,general'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['is_published'] = $request->boolean('is_published');

        ReadingTest::create($data);

        return redirect()
            ->route('reading-tests.index')
            ->with('success', 'Reading test created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReadingTest $reading_test)
    {
        return view('admin.reading-tests.edit', compact('reading_test'));
    }

    public function update(Request $request, ReadingTest $reading_test)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'module_type' => ['required','in:academic,general'],
            'duration_minutes' => ['required','integer','min:1'],
            'is_published' => ['nullable','boolean'],
        ]);

        $data['is_published'] = $request->boolean('is_published');

        $reading_test->update($data);

        return redirect()
            ->route('reading-tests.index')
            ->with('success','Reading test updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReadingTest $reading_test)
    {
        $reading_test->delete();

        return redirect()
            ->route('reading-tests.index')
            ->with('success', 'Reading test deleted.');
    }
}
