<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Lesson\StoreLessonRequest;
use App\Http\Requests\Lesson\UpdateLessonRequest;
use App\Models\Lesson;

class LessonController
{
    /**
     * Todas as aulas
     */
    public function index()
    {
        $lessons = Lesson::all();

        if ($lessons->isEmpty()) {
            return response()->json([
                'error' => 404,
                'message' => 'Lessons not found.'
            ], 404);
        }

        return response()->json($lessons);
    }

    /**
     * Cria uma aula
     */
    public function store(StoreLessonRequest $request)
    {
        $lesson = Lesson::create($request->validated());

        return response()->json($lesson, 201);
    }

    /**
     * Detalhes de uma aula
     */
    public function show(int $lesson)
    {
        $lesson = Lesson::find($lesson);

        if (!$lesson) {
            return response()->json([
                'error' => 404,
                'message' => 'Lesson not found.'
            ], 404);
        }

        return response()->json($lesson);
    }

    /**
     * Atualiza uma aula
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $lesson->update($request->validated());

        return response()->json($lesson);
    }

    /**
     * Elimina uma aula
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->updateOrFail(['active' => !$lesson->active]);

        return response()->json($lesson);
    }
}
