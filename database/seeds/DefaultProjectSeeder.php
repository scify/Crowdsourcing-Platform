<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('crowd_sourcing_projects')->delete();
        DB::table('crowd_sourcing_projects')->insert(array(
            array('id' => 1,
                'name' => 'FAIR EU',
                'slug' => 'fair-eu',
                'logo_path' => '/images/default-project/fair-eu.png',
                'img_path' => '/images/default-project/fair-eu-bg.png',
                'motto' => 'Help us tackle the obstacles of low political participation levels',
                'description' => '',
                'about' => '<p>
                Et qui consequuntur voluptas aliquid est. Nisi esse delectus laborum beatae iusto corrupti quia et.
                Omnis minima est eaque aut rerum mollitia.Autem voluptatem adipisci modi. Nemo rerum natus id laudantium. Atque recusandae qui qui et voluptas
                quis. Et sit quia dolores magni eligendi sequi.Corporis reprehenderit qui nobis maiores quibusdam voluptatum at sit. Deleniti et quia possimus. Amet
                quasi aut totam molestias inventore veniam.
            </p>',
                'questionnaire' => '<div class="row">
                <div class="col-md-6">
                    <div class="questionnaire-wrapper"
                         style="border: 1px solid #99aec1; height: 450px; background-color: white;">
                        <div class="questionnaire-title"
                             style="background-color: #ced8e1; color: black; font-weight: 600;
                             border-bottom: 1px solid #99aec1; text-align: center; padding: 10px;">
                            Under construction
                        </div>
                        <div class="questionnaire-content"
                             style="padding-top: 180px; font-style: italic; text-align: center;">
                            <p style="font-size: 14px !important;">Call to actions to start answering the questionnaire will be displayed here</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="gamification-wrapper"
                         style="border: 1px solid #99aec1; height: 250px; background-color: white;">
                        <div class="questionnaire-title"
                             style="background-color: #ced8e1; color: black; font-weight: 600;
                             border-bottom: 1px solid #99aec1; text-align: center; padding: 10px;">
                            Under construction
                        </div>
                        <div class="gamification-content">
                        </div>
                        <div class="gamification-overlay"
                             style="position: absolute; top: 41px; left: 16px; right: 16px; bottom: 1px; background-color: rgba(100,100,100,0.1);">
                        </div>
                        <p style="font-size: 14px !important; text-align: center; font-style: italic; padding-top: 20px;">
                           gamificiation elements will be displayed here
                        </p>
                    </div>
                </div>
            </div>',
                'footer' => '<p style="font-size: 12px;">© FAIR EU 2018&nbsp;|&nbsp;
                <a href="https://faireu.ecas.org/terms-of-use/" target="_blank" title="Read more">Terms of use</a>&nbsp;|&nbsp;
                <a href="https://faireu.ecas.org/privacy-policy/" target="_blank" title="Read more">Privacy Policy</a>&nbsp;|&nbsp;
                <a href="https://faireu.ecas.org/cookie-policy/" target="_blank" title="Read more">Cookie Policy</a>
            </p>
            <p style="font-size:13px; line-height:20px;"><img
                        src="https://faireu.ecas.org/wp-content/uploads/2018/02/big-eu-flag.png" alt=""
                        style="width:120px; float:left; margin:5px 30px 0 0;">
                Project Co-funded by the JUSTICE, EQUALITY AND CITIZENSHIP PROGRAMME (2014-2020) OF THE EUROPEAN
                UNION.<br>
                The content of this website represents the views of the author only and is his/her sole responsibility.
                The European Commission does not accept any responsibility for use that may be made of the information
                it contains.
            </p>',
                'user_creator_id' => 1,
                'language_id' => 6
            ),
        ));
    }
}
