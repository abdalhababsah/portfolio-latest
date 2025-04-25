<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Darkone',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        $now = Carbon::now();

        /* -----------------------------------------------------------------
                 |  0.  House-keeping
                 | -----------------------------------------------------------------
                 */
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        foreach (['project_technology', 'project_tag', 'blog_tag',  // pivots first
            'service_images', 'project_images', 'project_videos', 'contacts', 'social_links', 'site_settings', 'skills', 'education', 'experiences', 'testimonials', 'certificates', 'faqs', 'projects', 'services', 'blogs', 'categories', 'technologies', 'tags',] as $tbl) {
            DB::table($tbl)->truncate();
        }

        /* -----------------------------------------------------------------
         |  1.  Lookup tables
         | -----------------------------------------------------------------
         */
        // 1-A  Categories
        $categories = [
            ['name_en' => 'Web Development', 'name_ar' => 'تطوير الويب'],
            ['name_en' => 'Mobile Apps', 'name_ar' => 'تطبيقات الهاتف'],
            ['name_en' => 'AI & ML', 'name_ar' => 'الذكاء الاصطناعي'],
            ['name_en' => 'DevOps', 'name_ar' => 'ديف أوبس'],
            ['name_en' => 'UI / UX Design', 'name_ar' => 'تصميم واجهات'],
        ];
        foreach ($categories as &$c) {
            $c += [
                'meta_title_en' => "$c[name_en] Services",
                'meta_title_ar' => "خدمات $c[name_ar]",
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('categories')->insert($categories);

        // 1-B  Technologies
        $technologies = [
            ['Laravel', 'لارافيل', 'laravel.png'],
            ['Vue.js', 'فيو جي إس', 'vue.png'],
            ['React.js', 'ريأكت', 'react.png'],
            ['Node.js', 'نود', 'node.png'],
            ['Django', 'جانغو', 'django.png'],
            ['TailwindCSS', 'تايلويند', 'tailwind.png'],
            ['Docker', 'دوكر', 'docker.png'],
            ['AWS', 'خدمات AWS', 'aws.png'],
            ['MySQL', 'ماي إس كيو إل', 'mysql.png'],
            ['PostgreSQL', 'بوستجري', 'postgres.png'],
        ];
        foreach ($technologies as $t) {
            DB::table('technologies')->insert([
                'name_en' => $t[0],
                'name_ar' => $t[1],
                'logo' => "logos/$t[2]",
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // 1-C  Tags
        $tags = ['API', 'Frontend', 'Backend', 'Cloud', 'Security', 'DevOps', 'UI', 'Open-Source'];
        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'name_en' => $tag,
                'name_ar' => match ($tag) {
                    'API' => 'واجهة برمجة', 'Frontend' => 'الواجهة', 'Backend' => 'الخلفية',
                    'Cloud' => 'سحابة', 'Security' => 'أمن', 'DevOps' => 'ديف أوبس',
                    'UI' => 'واجهة', 'Open-Source' => 'مفتوح المصدر'
                },
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        /* -----------------------------------------------------------------
         |  2.  Services (+ images)
         | -----------------------------------------------------------------
         */
        $servicesData = [
            ['web-design', 'Web Design', 'تصميم مواقع', 500, 'USD', 'per project'],
            ['full-stack', 'Full-Stack Development', 'تطوير متكامل', 80, 'USD', 'per hour'],
            ['mobile-apps', 'Mobile Apps', 'تطبيقات هاتف', 1000, 'USD', 'starting'],
            ['ai-consult', 'AI Consultation', 'استشارات ذكاء اصطناعي', 120, 'USD', 'per hour'],
        ];
        foreach ($servicesData as $i => $s) {
            DB::table('services')->insert([
                'slug' => $s[0],
                'title_en' => $s[1],
                'title_ar' => $s[2],
                'description_en' => "$s[1] service description.",
                'description_ar' => "وصف خدمة $s[2].",
                'price' => $s[3],
                'currency' => $s[4],
                'unit_en' => $s[5],
                'unit_ar' => 'لكل وحدة',
                'cover_image' => "services/{$s[0]}.jpg",
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            // two images each
            DB::table('service_images')->insert([
                [
                    'service_id' => $i + 1,
                    'image_path' => "services/{$s[0]}-main.jpg",
                    'alt_text_en' => "{$s[1]} main",
                    'alt_text_ar' => "صورة {$s[2]} الرئيسية",
                    'is_main' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'service_id' => $i + 1,
                    'image_path' => "services/{$s[0]}-extra.jpg",
                    'alt_text_en' => "{$s[1]} extra",
                    'alt_text_ar' => "صورة إضافية {$s[2]}",
                    'is_main' => false,        // extra image, not the main one
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }

        /* -----------------------------------------------------------------
         |  3.  Projects (+ pivots, media)
         | -----------------------------------------------------------------
         */
        $projectSlugs = ['portfolio', 'e-commerce', 'chatbot', 'devops-pipeline', 'ai-dashboard'];
        foreach ($projectSlugs as $idx => $slug) {
            $id = $idx + 1;
            $titleEn = Str::headline($slug);
            DB::table('projects')->insert([
                'slug' => $slug,
                'title_en' => $titleEn,
                'title_ar' => "مشروع $titleEn",
                'short_description_en' => "Short description for $titleEn.",
                'short_description_ar' => "وصف مختصر للمشروع $titleEn.",
                'full_description_en' => "Full description of $titleEn using multiple tech.",
                'full_description_ar' => "وصف مفصل للمشروع $titleEn بعدة تقنيات.",
                'role_en' => 'Lead Developer',
                'role_ar' => 'المطوّر الرئيسي',
                'duration_en' => '2-4 months',
                'duration_ar' => '٢-٤ أشهر',
                'cover_image' => "projects/$slug/cover.jpg",
                'featured' => ($idx < 3),
                'category_id' => rand(1, 5),
                'github_url' => "https://github.com/demo/$slug",
                'demo_url' => "https://demo.example.com/$slug",
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // pivot: 3 random tech & 2 random tags each
            $techIds = array_rand(array_flip(range(1, 10)), 3);
            foreach ($techIds as $t) {
                DB::table('project_technology')->insert([
                    'project_id' => $id,
                    'technology_id' => $t
                ]);
            }
            $tagIds = array_rand(array_flip(range(1, 8)), 2);
            foreach ($tagIds as $t) {
                DB::table('project_tag')->insert([
                    'project_id' => $id,
                    'tag_id' => $t
                ]);
            }

            // images
            for ($n = 1; $n <= 3; $n++) {
                DB::table('project_images')->insert([
                    'project_id' => $id,
                    'image_path' => "projects/$slug/$n.jpg",
                    'alt_text_en' => "$titleEn screenshot $n",
                    'alt_text_ar' => "لقطة $n للمشروع",
                    'is_main' => ($n == 1),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            // video (first two projects only)
            if ($id <= 2) {
                DB::table('project_videos')->insert([
                    'project_id' => $id,
                    'video_url' => "https://youtu.be/{$slug}Demo",
                    'caption_en' => "$titleEn Demo",
                    'caption_ar' => "عرض $titleEn",
                    'thumbnail_path' => "projects/$slug/thumb.jpg",
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        /* -----------------------------------------------------------------
         |  4.  Experiences & Education
         | -----------------------------------------------------------------
         */
        DB::table('experiences')->insert([
            [
                'company_en' => 'Atypon',
                'company_ar' => 'أتيفون',
                'position_en' => 'React Engineer',
                'position_ar' => 'مهندس React',
                'start_date' => '2025-01-01',
                'end_date' => null,                    //  ← add this
                'description_en' => 'Building reader platforms.',
                'description_ar' => 'بناء منصات قراءة.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'company_en' => 'MENADevs',
                'company_ar' => 'مينا ديفز',
                'position_en' => 'AI Prompt Engineer',
                'position_ar' => 'مهندس برمجيات محادثة',
                'start_date' => '2024-05-01',
                'end_date' => '2024-12-31',            //  ← key now exists in both rows
                'description_en' => 'Crafted production prompts.',
                'description_ar' => 'صممت مطالبات ذكية.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('education')->insert([
            [
                'institution_en' => 'University of Jordan',
                'institution_ar' => 'جامعة الأردن',
                'degree_en' => 'B.Sc. Software Engineering',
                'degree_ar' => 'هندسة البرمجيات',
                'start_date' => '2019-09-01',
                'end_date' => '2023-06-30',   // completed study
                'description_en' => null,
                'description_ar' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'institution_en' => 'Orange Coding Academy',
                'institution_ar' => 'أكاديمية أورانج',
                'degree_en' => 'Backend Diploma',
                'degree_ar' => 'دبلوم باك-إند',
                'start_date' => '2023-09-01',
                'end_date' => null,           // ongoing → keep the key, set to null
                'description_en' => null,
                'description_ar' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        /* -----------------------------------------------------------------
         |  5.  Skills
         | -----------------------------------------------------------------
         */
        $skills = [
            ['React.js', 1],
            ['Vue.js', 1],
            ['Laravel', 1],
            ['Django', 1],
            ['Docker', 4],
            ['Kubernetes', 4],
            ['AWS', 4],
            ['Figma', 5],
            ['TailwindCSS', 1],
            ['MySQL', 1],
            ['PostgreSQL', 1],
            ['Redis', 1],
        ];
        foreach ($skills as $s) {
            DB::table('skills')->insert([
                'name_en' => $s[0],
                'name_ar' => Str::replace('.js', ' جي إس', $s[0]),
                'level' => rand(60, 95),
                'category_id' => $s[1],
                'icon' => "icons/" . Str::slug($s[0]) . ".png",
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        /* -----------------------------------------------------------------
         |  6.  Testimonials
         | -----------------------------------------------------------------
         */
        DB::table('testimonials')->insert([
            [
                'name' => 'Reem Al-Hussein',
                'role' => 'Project Manager',
                'rating' => 5,
                'message_en' => 'Delivered ahead of schedule!',
                'message_ar' => 'تم التسليم قبل الموعد!',
                'image' => 'testimonials/reem.jpg',
                'date_given' => '2025-02-15',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Ahmad Al-Zoubi',
                'role' => 'CTO',
                'rating' => 4,
                'message_en' => 'Great eye for detail.',
                'message_ar' => 'دقة عالية في التفاصيل.',
                'image' => 'testimonials/ahmad.jpg',
                'date_given' => '2024-09-10',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        /* -----------------------------------------------------------------
         |  7.  Blogs (+ tags)
         | -----------------------------------------------------------------
         */
        $blogs = [
            ['laravel-vs-django', 'Laravel vs Django'],
            ['react-performance', 'Optimising React Performance'],
            ['devops-best-practices', 'DevOps Best Practices'],
            ['ai-in-testing', 'AI in Software Testing'],
        ];
        foreach ($blogs as $i => $b) {
            $id = $i + 1;
            DB::table('blogs')->insert([
                'slug' => $b[0],
                'title_en' => $b[1],
                'title_ar' => "مقالة $b[1]",
                'summary_en' => "Summary of $b[1].",
                'content_en' => "$b[1] full content...",
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            // attach 2 random tags
            foreach (array_rand(array_flip(range(1, 8)), 2) as $tag) {
                DB::table('blog_tag')->insert(['blog_id' => $id, 'tag_id' => $tag]);
            }
        }

        /* -----------------------------------------------------------------
         |  8.  Certificates
         | -----------------------------------------------------------------
         */
        DB::table('certificates')->insert([
            [
                'title_en' => 'AWS Solutions Architect-Associate',
                'title_ar' => 'مهندس حلول AWS',
                'description_en' => null,
                'description_ar' => null,
                'file_path' => 'certs/aws-sa.pdf',
                'issued_by' => 'Amazon',
                'date_issued' => '2024-11-01',
                'expiry_date' => null,          // key must exist in every row
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title_en' => 'Google Cloud Professional',
                'title_ar' => 'محترف سحابة جوجل',
                'description_en' => null,
                'description_ar' => null,
                'file_path' => 'certs/gcp.pdf',
                'issued_by' => 'Google',
                'date_issued' => '2024-06-15',
                'expiry_date' => '2027-06-15',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        /* -----------------------------------------------------------------
         |  9.  FAQs
         | -----------------------------------------------------------------
         */
        DB::table('faqs')->insert([
            [
                'question_en' => 'What tech stack do you use?',
                'question_ar' => 'ما هي التقنيات التي تستخدمها؟',
                'answer_en' => 'Mostly Laravel, React, and AWS.',
                'answer_ar' => 'أستخدم بشكل أساسي لارافيل وريأكت وAWS.',
                'display_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question_en' => 'How long does a project take?',
                'question_ar' => 'كم يستغرق المشروع؟',
                'answer_en' => 'Anywhere from 2 weeks to 4 months.',
                'answer_ar' => 'من أسبوعين إلى أربعة أشهر.',
                'display_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        /* -----------------------------------------------------------------
         | 10.  Static Settings, Contacts, Social
         | -----------------------------------------------------------------
         */
        DB::table('site_settings')->insert([
            ['key_name' => 'site_title', 'value_en' => 'Abdelrahman', 'value_ar' => 'عبدالرحمن'],
            ['key_name' => 'hero_heading', 'value_en' => 'Building Digital Experiences', 'value_ar' => 'بناء تجارب رقمية'],
            ['key_name' => 'contact_email', 'value_en' => 'contact@site.com', 'value_ar' => 'contact@site.com'],
        ]);

        DB::table('contacts')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'subject' => 'Inquiry',
                'message' => 'Loved your recent project!',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Sarah',
                'email' => 'sarah@example.com',
                'subject' => 'Quote',
                'message' => 'Need an e-commerce site.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('social_links')->insert([
            ['platform' => 'GitHub', 'url' => 'https://github.com/username', 'icon_class' => 'fa-github', 'created_at' => $now, 'updated_at' => $now],
            ['platform' => 'LinkedIn', 'url' => 'https://linkedin.com/in/username', 'icon_class' => 'fa-linkedin', 'created_at' => $now, 'updated_at' => $now],
            ['platform' => 'Twitter', 'url' => 'https://twitter.com/username', 'icon_class' => 'fa-twitter', 'created_at' => $now, 'updated_at' => $now],
            ['platform' => 'Instagram', 'url' => 'https://instagram.com/username', 'icon_class' => 'fa-instagram', 'created_at' => $now, 'updated_at' => $now],
            ['platform' => 'Facebook', 'url' => 'https://facebook.com/username', 'icon_class' => 'fa-facebook', 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}