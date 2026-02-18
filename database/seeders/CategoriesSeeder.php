<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('category_translations')->truncate();
        DB::table('categories')->truncate();

        $now = now();
        $categories = [
            ['en' => 'Design', 'ar' => 'التصميم'],
            ['en' => 'Programming', 'ar' => 'البرمجة'],
            ['en' => 'Photography', 'ar' => 'التصوير'],
            ['en' => 'Communication', 'ar' => 'التواصل'],
            ['en' => 'Technology', 'ar' => 'التقنية'],
            ['en' => 'Business', 'ar' => 'الأعمال'],
            ['en' => 'Science', 'ar' => 'العلوم'],
            ['en' => 'Health', 'ar' => 'الصحة'],
            ['en' => 'Media', 'ar' => 'الإعلام'],
            ['en' => 'Data', 'ar' => 'البيانات'],
        ];

        $categoryRows = [];
        foreach ($categories as $category) {
            $categoryRows[] = [
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('categories')->insert($categoryRows);

        $categoryIds = DB::table('categories')
            ->orderBy('id')
            ->pluck('id')
            ->all();

        $translationRows = [];
        foreach ($categories as $index => $category) {
            $categoryId = $categoryIds[$index] ?? null;
            if (! $categoryId) {
                continue;
            }
            $translationRows[] = [
                'category_id' => $categoryId,
                'locale' => 'en',
                'name' => $category['en'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $translationRows[] = [
                'category_id' => $categoryId,
                'locale' => 'ar',
                'name' => $category['ar'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('category_translations')->insert($translationRows);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
