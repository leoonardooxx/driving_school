<?php

namespace App\Http\Controllers\Api;


use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController
{
    /**
     * Mostra todas as aulas
     */
    public function index()
    {
        $lessons = Lesson::all();

        if (!$lessons) {
            return response()->json([
                'error' => 404,
                'message' => 'Lessons not found.'
            ], 404);
        }

        return $lessons;
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        //
    }
}
