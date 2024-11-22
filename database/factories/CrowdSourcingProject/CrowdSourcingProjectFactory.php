<?php

namespace Database\Factories\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use Illuminate\Database\Eloquent\Factories\Factory;

class CrowdSourcingProjectFactory extends Factory {
    protected $model = CrowdSourcingProject::class;

    public function definition() {
        return [
            'status_id' => 1,
            'slug' => $this->faker->slug,
            'created_at' => now(),
            'updated_at' => now(),
            'user_creator_id' => 1,
            'language_id' => 1,
            'sm_featured_img_path' => $this->faker->imageUrl(),
            'lp_questionnaire_img_path' => $this->faker->imageUrl(),
            'lp_show_speak_up_btn' => $this->faker->boolean,
            'lp_primary_color' => $this->faker->hexColor,
            'lp_btn_text_color_theme' => 'light',
            'should_send_email_after_questionnaire_response' => $this->faker->boolean,
            'display_landing_page_banner' => $this->faker->boolean,
            'img_path' => $this->faker->imageUrl(),
            'logo_path' => $this->faker->imageUrl(),
        ];
    }
}
