<?php

namespace App\Http\Controllers; // Definuje jmenný prostor pro kontrolery aplikace

use App\Models\Quiz; // Importuje model Quiz pro práci s kvízy
use App\Models\Answer; // Importuje model Answer pro práci s odpověďmi
use App\Models\QuizCompletion; // Importuje model QuizCompletion pro záznam dokončených kvízů
use Illuminate\Http\Request; // Importuje třídu Request pro práci s HTTP požadavky
use Illuminate\Support\Facades\DB; // Importuje DB pro transakce

/**
 * QuizController zajišťuje správu kvízů, jejich otázek a zpracování odpovědí.
 */
class QuizController extends Controller
{
    /**
     * Vrátí seznam všech kvízů včetně počtu otázek v každém kvízu.
     *
     * @return \Illuminate\Http\JsonResponse JSON odpověď se seznamem kvízů
     */
    public function index()
    {
        // Získá všechny kvízy spolu s počtem otázek
        $quizzes = Quiz::withCount('questions')->get();

        // Vrátí seznam kvízů ve formátu JSON
        return response()->json($quizzes);
    }

    /**
     * Vrátí seznam otázek a odpovědí pro konkrétní kvíz.
     *
     * @param  int  $id  ID kvízu
     * @return \Illuminate\Http\JsonResponse JSON odpověď se seznamem otázek a odpovědí
     */
    public function showQuestions($id)
    {
        // Najde kvíz podle ID a načte jeho otázky spolu s odpověďmi
        $quiz = Quiz::with(['questions.answers'])->findOrFail($id);

        // Vrátí otázky kvízu ve formátu JSON
        return response()->json($quiz->questions);
    }

    /**
     * Zpracuje odpovědi uživatele na kvíz a vypočítá skóre.
     *
     * @param  \Illuminate\Http\Request  $request  HTTP požadavek obsahující odpovědi
     * @param  int  $id  ID kvízu
     * @return \Illuminate\Http\JsonResponse JSON odpověď s výsledkem kvízu
     */
    public function submit(Request $request, $id)
    {
        // Validace odpovědí - musí být pole a obsahovat platná ID odpovědí
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|exists:answers,id'
        ]);

        // Najde kvíz spolu s jeho otázkami a odpověďmi
        $quiz = Quiz::with('questions.answers')->findOrFail($id);
        $user = $request->user();

        // Ověří, zda uživatel už tento kvíz dokončil
        if (QuizCompletion::where('user_id', $user->id)->where('quiz_id', $id)->exists()) {
            return response()->json(['message' => 'Quiz already completed'], 400);
        }

        $score = 0;
        $totalQuestions = $quiz->questions->count(); // Počet otázek v kvízu
        $submittedAnswers = collect($request->answers); // Odpovědi od uživatele

        // Výpočet skóre
        foreach ($quiz->questions as $question) {
            // Najde správnou odpověď pro otázku
            $correctAnswer = $question->answers->where('is_correct', true)->first();
            if ($submittedAnswers->contains($correctAnswer->id)) {
                $score++; // Zvýší skóre, pokud uživatel vybral správnou odpověď
            }
        }

        // Výpočet XP (10 XP za každou správnou odpověď)
        $xpEarned = $score * 10;

        // Uloží dokončení kvízu a aktualizuje XP uživatele v databázi v rámci transakce
        DB::transaction(function () use ($user, $id, $score, $xpEarned, $request) {
            // Vytvoří záznam o dokončení kvízu
            QuizCompletion::create([
                'user_id' => $user->id,
                'quiz_id' => $id,
                'score' => $score,
                'xp_earned' => $xpEarned,
                'answers' => $request->answers
            ]);

            // Zvýší XP uživatele
            $user->increment('xp', $xpEarned);
        });

        // Vrátí JSON odpověď s výsledky kvízu
        return response()->json([
            'score' => $score,
            'total_questions' => $totalQuestions,
            'xp_earned' => $xpEarned
        ]);
    }
}
