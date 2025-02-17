<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount('questions')->get();

        return response()->json($quizzes);
    }

    public function showQuestions($id)
    {
        $quiz = Quiz::with(['questions.answers'])->findOrFail($id);

        return response()->json($quiz->questions);
    }
} 