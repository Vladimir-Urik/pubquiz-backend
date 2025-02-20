<?php

namespace App\Http\Controllers; // Definuje jmenný prostor pro kontrolery aplikace

use App\Models\Question; // Importuje model Question pro práci s otázkami
use Illuminate\Http\Request; // Importuje třídu Request pro práci s HTTP požadavky

/**
 * QuestionController zajišťuje správu otázek v kvízu.
 */
class QuestionController extends Controller
{
    /**
     * Uloží novou otázku do databáze.
     *
     * @param  \Illuminate\Http\Request  $request  HTTP požadavek obsahující data otázky
     * @return \Illuminate\Http\JsonResponse  JSON odpověď s potvrzením o vytvoření otázky
     */
    public function store(Request $request)
    {
        // Validace vstupních dat
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id', // Ověří, že quiz_id existuje v tabulce quizzes
            'text' => 'nullable|string|max:255', // Text otázky je nepovinný, max. délka 255 znaků
            'content_type' => 'required|string|in:text,video,image', // Povinný typ obsahu (text, video, obrázek)
            'content' => 'required|string', // Obsah otázky je povinný
        ]);

        // Vytvoří novou otázku v databázi
        Question::create($request->all());

        // Vrátí JSON odpověď s potvrzením o vytvoření
        return response()->json(['message' => 'Question created successfully.']);
    }

    /**
     * Zobrazí konkrétní otázku.
     *
     * @param  int  $id  ID otázky
     * @return \Illuminate\View\View  Zobrazení detailu otázky
     */
    public function show($id)
    {
        // Najde otázku podle ID nebo vrátí 404 chybu, pokud neexistuje
        $question = Question::findOrFail($id);

        // Vrátí pohled 'questions.show' s danou otázkou
        return view('questions.show', compact('question'));
    }
}
