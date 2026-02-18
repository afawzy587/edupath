<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('course_translations')->truncate();
        DB::table('courses')->truncate();

        $now = now();
        $categoryLookup = DB::table('category_translations')
            ->where('locale', 'en')
            ->pluck('category_id', 'name');

        $courses = [
            [
                'category' => 'Design',
                'instructor' => 'EduPath Team',
                'en' => [
                    'name' => 'UI & Motion Design',
                    'description' => 'Build elegant interfaces and bring them to life with motion.',
                ],
                'ar' => [
                    'name' => 'تصميم الواجهات والموشن',
                    'description' => 'ابنِ واجهات أنيقة وأضف لها الحركة بطريقة احترافية.',
                ],
            ],
            [
                'category' => 'Programming',
                'instructor' => 'EduPath Team',
                'en' => [
                    'name' => 'Python Programming Basics',
                    'description' => 'Start coding in Python with simple, practical projects.',
                ],
                'ar' => [
                    'name' => 'مقدمة في البرمجة بلغة Python',
                    'description' => 'ابدأ البرمجة بلغة بايثون من خلال تطبيقات عملية سهلة.',
                ],
            ],
            [
                'category' => 'Photography',
                'instructor' => 'EduPath Team',
                'en' => [
                    'name' => 'Photography Fundamentals',
                    'description' => 'Learn composition, lighting, and camera settings from scratch.',
                ],
                'ar' => [
                    'name' => 'أساسيات التصوير الفوتوغرافي',
                    'description' => 'تعلّم التكوين والإضاءة وإعدادات الكاميرا من البداية.',
                ],
            ],
            [
                'category' => 'Design',
                'instructor' => 'EduPath Team',
                'en' => [
                    'name' => 'Digital Illustration & Graphics',
                    'description' => 'Create digital drawings and build strong visual identities.',
                ],
                'ar' => [
                    'name' => 'الرسم الرقمي والتصميم الجرافيكي',
                    'description' => 'اصنع رسوما رقمية وطور هوية بصرية قوية.',
                ],
            ],
            [
                'category' => 'Communication',
                'instructor' => 'EduPath Team',
                'en' => [
                    'name' => 'Public Speaking & Presentation',
                    'description' => 'Deliver confident talks and connect with your audience.',
                ],
                'ar' => [
                    'name' => 'فن الخطابة والإلقاء',
                    'description' => 'قدّم عروضك بثقة وتواصل بفاعلية مع الجمهور.',
                ],
            ],
            [
                'category' => 'Technology',
                'instructor' => 'EduPath Team',
                'en' => [
                    'name' => 'Robotics & AI',
                    'description' => 'Explore robotics, sensors, and smart automation.',
                ],
                'ar' => [
                    'name' => 'الروبوتات والذكاء الاصطناعي',
                    'description' => 'تعرّف على الروبوتات والحساسات وتقنيات الأتمتة الذكية.',
                ],
            ],
            [
                'category' => 'Business',
                'instructor' => 'EduPath Team',
                'en' => [
                    'name' => 'Accounting & Money Management',
                    'description' => 'Track budgets and understand personal finance essentials.',
                ],
                'ar' => [
                    'name' => 'المحاسبة وإدارة الأموال',
                    'description' => 'تعلم إدارة الميزانيات وفهم أساسيات المال الشخصي.',
                ],
            ],
            [
                'category' => 'Science',
                'instructor' => 'EduPath Team',
                'en' => [
                    'name' => 'Everyday Chemistry',
                    'description' => 'Discover how chemistry shapes everyday life.',
                ],
                'ar' => [
                    'name' => 'الكيمياء في حياتنا اليومية',
                    'description' => 'اكتشف كيف تؤثر الكيمياء في حياتنا اليومية.',
                ],
            ],
            [
                'category' => 'Business',
                'instructor' => 'EduPath Team',
                'en' => [
                    'name' => 'Entrepreneurship for Youth',
                    'description' => 'Turn ideas into real projects and launch your startup.',
                ],
                'ar' => [
                    'name' => 'ريادة الأعمال للشباب',
                    'description' => 'حوّل أفكارك إلى مشاريع واقعية وانطلق بشركتك.',
                ],
            ],
            [
                'category' => 'Data',
                'instructor' => 'EduPath Team',
                'en' => [
                    'name' => 'Data Analysis & Statistics',
                    'description' => 'Analyze data and interpret insights with confidence.',
                ],
                'ar' => [
                    'name' => 'تحليل البيانات وعلم الإحصاء',
                    'description' => 'حلل البيانات واستخرج منها رؤى مفيدة بثقة.',
                ],
            ],
            [
                'category' => 'Media',
                'instructor' => 'EduPath Team',
                'en' => [
                    'name' => 'Short Film Production',
                    'description' => 'Create short films from script to final edit.',
                ],
                'ar' => [
                    'name' => 'صناعة الأفلام القصيرة',
                    'description' => 'أنجز فيلما قصيرا من الفكرة وحتى المونتاج النهائي.',
                ],
            ],
            [
                'category' => 'Health',
                'instructor' => 'EduPath Team',
                'en' => [
                    'name' => 'First Aid & Volunteering',
                    'description' => 'Learn first aid basics and how to support your community.',
                ],
                'ar' => [
                    'name' => 'الإسعافات الأولية والعمل التطوعي',
                    'description' => 'تعلّم مبادئ الإسعاف وكيف تساهم في خدمة مجتمعك.',
                ],
            ],
        ];

        foreach ($courses as $course) {
            $categoryId = $categoryLookup[$course['category']] ?? null;
            if (! $categoryId) {
                continue;
            }

            $courseId = DB::table('courses')->insertGetId([
                'category_id' => $categoryId,
                'instructor_name' => $course['instructor'],
                'active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('course_translations')->insert([
                [
                    'course_id' => $courseId,
                    'locale' => 'en',
                    'name' => $course['en']['name'],
                    'description' => $course['en']['description'],
                    'image' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'course_id' => $courseId,
                    'locale' => 'ar',
                    'name' => $course['ar']['name'],
                    'description' => $course['ar']['description'],
                    'image' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
