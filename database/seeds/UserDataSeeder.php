<?php

use Illuminate\Database\Seeder;
use App\Models\LanguageLevel;
use App\Models\EducationDegree;
use App\Models\Country;
use App\Models\Language;
use App\Models\UserEducation;
use App\Models\UserLanguage;
use App\Models\Career;
use App\Models\Skill;


class UserDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Countries
        Country::insert(['name_en' => 'Egypt', 'name_ar' => 'مصر']);
        Country::insert(['name_en' => 'Saudi Arabia', 'name_ar' => 'المملكة العربية السعودية']);

        //Language Levels
        LanguageLevel::insert(['name_en' => 'Elementary', 'name_ar' => 'مبتديء']);
        LanguageLevel::insert(['name_en' => 'Intermediate', 'name_ar' => 'متوسط']);
        LanguageLevel::insert(['name_en' => 'Advanced', 'name_ar' => 'متقدم']);
        LanguageLevel::insert(['name_en' => 'Proficient', 'name_ar' => 'بارع']);

        //Language Levels
        Language::insert(['name_en' => 'Arabic', 'name_ar' => 'العربية']);
        Language::insert(['name_en' => 'English', 'name_ar' => 'الانجليزية']);
        Language::insert(['name_en' => 'French', 'name_ar' => 'الفرنسية']);

        //Education Degree
        EducationDegree::insert(['name_en' => 'High School', 'name_ar' => 'المدرسة العليا']);
        EducationDegree::insert(['name_en' => 'Bachelor', 'name_ar' => 'بكالريوس']);
        EducationDegree::insert(['name_en' => 'MS', 'name_ar' => 'ماجستير']);
        EducationDegree::insert(['name_en' => 'PHD', 'name_ar' => 'دكتوراه']);

        //UserEducation
        UserEducation::insert(['user_id'=>1, 'degree_id'=>'2', 'school'=>'Cairo University', 'started_year'=>'2000',
            'graduation_year'=>'2004', 'education_status'=>'finished']);

        //UserLanguage
        UserLanguage::insert(['user_id' => 1, 'language_id' => 2, 'language_level_id' => 4]);
        UserLanguage::insert(['user_id' => 1, 'language_id' => 1, 'language_level_id' => 4]);

        //Career
        Career::insert(['user_id' => 1, 'title_ar' => 'مهندس برمجيات', 'title_en' => 'Software Engineer', 'employer' => 'Google',
            'start_date' => '2006-04-01', 'end_date' => '2009-07-01', 'employment_status' => 'finished', 'role' => 'Coordinator', 'description_ar' => 'لللللللللل',
            'description_en' => 'blablabla']);

        //Skills
        Skill::insert(['user_id' => 1, 'skill' => 'PHP', 'skill_percentage'=>90]);
        Skill::insert(['user_id' => 1, 'skill' => 'Scrum', 'skill_percentage'=>90]);

    }
}
