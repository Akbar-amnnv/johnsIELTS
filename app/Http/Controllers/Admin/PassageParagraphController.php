<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Passage;
use App\Models\PassageParagraph;
use App\Models\ReadingTest;
use Illuminate\Http\Request;

class PassageParagraphController extends Controller
{
    public function index(ReadingTest $reading_test, Passage $passage)
    {
        $this->ensurePassageBelongsToTest($reading_test, $passage);

        $paragraphs = $passage->paragraphs()
            ->orderBy('sort_order')
            ->get();

        return view('admin.paragraphs.index', compact(
            'reading_test',
            'passage',
            'paragraphs'
        ));
    }

    public function create(ReadingTest $reading_test, Passage $passage)
    {
        $this->ensurePassageBelongsToTest($reading_test, $passage);

        return view('admin.paragraphs.create', compact(
            'reading_test',
            'passage'
        ));
    }

    public function store(Request $request, ReadingTest $reading_test, Passage $passage)
    {
        $this->ensurePassageBelongsToTest($reading_test, $passage);

        $data = $request->validate([
            'label' => ['nullable', 'string', 'max:10'],
            'content' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:1'],
        ]);

        $nextOrder = ($passage->paragraphs()->max('sort_order') ?? 0) + 1;

        PassageParagraph::create([
            'passage_id' => $passage->id,
            'label' => $data['label'] ?: $this->generateLabel($nextOrder - 1),
            'content' => trim($data['content']),
            'sort_order' => $data['sort_order'] ?? $nextOrder,
        ]);

        return redirect()
            ->route('reading-tests.passages.paragraphs.index', [$reading_test, $passage])
            ->with('success', 'Paragraph created successfully.');
    }

    public function edit(ReadingTest $reading_test, Passage $passage, PassageParagraph $paragraph)
    {
        $this->ensurePassageBelongsToTest($reading_test, $passage);
        $this->ensureParagraphBelongsToPassage($passage, $paragraph);

        return view('admin.paragraphs.edit', compact(
            'reading_test',
            'passage',
            'paragraph'
        ));
    }

    public function update(
        Request $request,
        ReadingTest $reading_test,
        Passage $passage,
        PassageParagraph $paragraph
    ) {
        $this->ensurePassageBelongsToTest($reading_test, $passage);
        $this->ensureParagraphBelongsToPassage($passage, $paragraph);

        $data = $request->validate([
            'label' => ['nullable', 'string', 'max:10'],
            'content' => ['required', 'string'],
            'sort_order' => ['required', 'integer', 'min:1'],
        ]);

        $paragraph->update([
            'label' => $data['label'],
            'content' => trim($data['content']),
            'sort_order' => $data['sort_order'],
        ]);

        return redirect()
            ->route('reading-tests.passages.paragraphs.index', [$reading_test, $passage])
            ->with('success', 'Paragraph updated successfully.');
    }

    public function destroy(
        ReadingTest $reading_test,
        Passage $passage,
        PassageParagraph $paragraph
    ) {
        $this->ensurePassageBelongsToTest($reading_test, $passage);
        $this->ensureParagraphBelongsToPassage($passage, $paragraph);

        $paragraph->delete();

        return redirect()
            ->route('reading-tests.passages.paragraphs.index', [$reading_test, $passage])
            ->with('success', 'Paragraph deleted successfully.');
    }

    public function storeSplit(Request $request, ReadingTest $reading_test, Passage $passage)
    {
        $this->ensurePassageBelongsToTest($reading_test, $passage);

        $data = $request->validate([
            'full_content' => ['required', 'string'],
        ]);

        $rawText = trim($data['full_content']);

        $paragraphs = preg_split("/(\r\n\s*\r\n|\n\s*\n|\r\s*\r)/", $rawText);

        $paragraphs = array_values(array_filter(array_map(function ($item) {
            return trim($item);
        }, $paragraphs)));

        if (empty($paragraphs)) {
            return back()->withErrors([
                'full_content' => 'No valid paragraphs were found.',
            ])->withInput();
        }

        $passage->paragraphs()->delete();

        foreach ($paragraphs as $index => $content) {
            PassageParagraph::create([
                'passage_id' => $passage->id,
                'label' => $this->generateLabel($index),
                'content' => $content,
                'sort_order' => $index + 1,
            ]);
        }

        return redirect()
            ->route('reading-tests.passages.paragraphs.index', [$reading_test, $passage])
            ->with('success', 'Paragraphs generated successfully.');
    }

    private function ensurePassageBelongsToTest(ReadingTest $reading_test, Passage $passage): void
    {
        abort_if($passage->reading_test_id !== $reading_test->id, 404);
    }

    private function ensureParagraphBelongsToPassage(Passage $passage, PassageParagraph $paragraph): void
    {
        abort_if($paragraph->passage_id !== $passage->id, 404);
    }

    private function generateLabel(int $index): string
    {
        $alphabet = range('A', 'Z');

        if ($index < 26) {
            return $alphabet[$index];
        }

        $first = intdiv($index, 26) - 1;
        $second = $index % 26;

        return $alphabet[$first] . $alphabet[$second];
    }
}
