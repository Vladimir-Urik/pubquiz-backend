<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Answer;
use App\Models\QuizCompletion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function submit(Request $request, $id)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*.answer' => 'required|exists:answers,id',
            'answers.*.question_id' => 'required|exists:questions,id'
        ]);

        $quiz = Quiz::with('questions.answers')->findOrFail($id);
        $user = $request->user();

        // Check if quiz was already completed
        //if (QuizCompletion::where('user_id', $user->id)->where('quiz_id', $id)->exists()) {
        //    return response()->json(['message' => 'Quiz already completed'], 400);
        //}

        $score = 0;
        $totalQuestions = $quiz->questions->count();
        $submittedAnswers = collect($request->answers);

        // Calculate score
        foreach ($submittedAnswers as $data) {
            $question = $quiz->questions->find($data['question_id']);
            $correctAnswer = $question->answers->where('is_correct', true)->first();
            if ($correctAnswer->id == $data['answer']) {
                $score++;
            }
        }

        // Calculate XP (10 XP per correct answer)
        $xpEarned = $score * 10;

        // increment xp
        $userModel = User::where('id', '=', $user->id)->first();
        $userModel->xp += $xpEarned;
        $userModel->save();

        return response()->json([
            'score' => $score,
            'total_questions' => $totalQuestions,
            'xp_earned' => $xpEarned
        ]);
    }
}
