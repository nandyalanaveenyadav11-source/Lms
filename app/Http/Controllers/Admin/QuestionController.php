<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(\Illuminate\Http\Request $request, \App\Models\Quiz $quiz)
    {
        $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|string|in:a,b,c,d',
        ]);

        $quiz->questions()->create($request->all());

        return back()->with('success', 'Question added successfully.');
    }

    public function update(\Illuminate\Http\Request $request, \App\Models\Quiz $quiz, \App\Models\Question $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|string|in:a,b,c,d',
        ]);

        $question->update($request->all());

        return back()->with('success', 'Question updated successfully.');
    }

    public function destroy(\App\Models\Quiz $quiz, \App\Models\Question $question)
    {
        $question->delete();
        return back()->with('success', 'Question deleted successfully.');
    }

    public function import(\Illuminate\Http\Request $request, \App\Models\Quiz $quiz)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        
        // Skip header row
        fgetcsv($handle);

        $count = 0;
        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) >= 6) {
                $quiz->questions()->create([
                    'question_text' => $data[0],
                    'option_a' => $data[1],
                    'option_b' => $data[2],
                    'option_c' => $data[3],
                    'option_d' => $data[4],
                    'correct_answer' => strtolower(trim($data[5])),
                ]);
                $count++;
            }
        }

        fclose($handle);

        return back()->with('success', "$count questions imported successfully.");
    }
}
