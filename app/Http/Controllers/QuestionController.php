<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'text' => 'nullable|string|max:255',
            'content_type' => 'required|string|in:text,video,image',
            'content' => 'required|string',
        ]);

        Question::create($request->all());

        return response()->json(['message' => 'Question created successfully.']);
    }

    public function show($id)
    {
        $question = Question::findOrFail($id);

        return view('questions.show', compact('question'));
    }
} 