<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('questions')->truncate();
        DB::table('question_translations')->truncate();
        $now = now();
        $questionRows = [];
        $translationRows = [];


        foreach (['assessments', 'hobbies'] as $type) {
            for ($i = 1; $i <= 20; $i++) {
                $questionRows[] = [
                    'type' => $type,
                    'active' => true,
                    'order' => $i,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('questions')->insert($questionRows);

        $insertedIds = DB::table('questions')
            ->orderBy('id')
            ->pluck('id')
            ->all();

        $half = (int) (count($insertedIds) / 2);
        $assessmentIds = array_slice($insertedIds, 0, $half);
        $hobbyIds = array_slice($insertedIds, $half);

        foreach ($assessmentIds as $index => $questionId) {
            $number = $index + 1;
            $translationRows[] = [
                'question_id' => $questionId,
                'locale' => 'en',
                'title' => "Assessment question {$number}",
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $translationRows[] = [
                'question_id' => $questionId,
                'locale' => 'ar',
                'title' => "سؤال التقييم رقم {$number}",
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach ($hobbyIds as $index => $questionId) {
            $number = $index + 1;
            $translationRows[] = [
                'question_id' => $questionId,
                'locale' => 'en',
                'title' => "Hobby question {$number}",
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $translationRows[] = [
                'question_id' => $questionId,
                'locale' => 'ar',
                'title' => "سؤال الهوايات رقم {$number}",
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('question_translations')->insert($translationRows);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
