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
                'name' => 'Crowdsourcing Demo Project',
                'slug' => 'crowdsourcing-demo',
                'logo_path' => '/images/projects/demo/logo.png',
                'img_path' => '/images/projects/demo/logo-bg.png',
                'motto' => 'Please share with us your opinion on an important subject. Your voice matters!',
                'description' => '',
                'about' => '<p>The Demo Project serves as a demonstration mechanism for the various Crowdsourcing beneficial results and a showcase. <a href="https://www.scify.gr/site/en/">Learn more about our project.</a></p>',
                'footer' => '<p style="font-size: 12px;">© SCIFY ' . now()->year . '&nbsp;|&nbsp;
                <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Terms of use</a>&nbsp;|&nbsp;
                <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Privacy Policy</a>&nbsp;|&nbsp;
                <a href="https://www.scify.gr/site/en/" target="_blank" title="Read more">Cookie Policy</a>
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
        DB::table('crowd_sourcing_projects')->insert(array(
            array('id' => 2,
                'name' => 'FAIR EU',
                'slug' => 'fair-eu',
                'logo_path' => '/images/projects/fair-eu/fair-eu.png',
                'img_path' => '/images/projects/fair-eu/fair-eu-bg.png',
                'motto' => 'Please share with us your opinion on obstacles to free movement and <br>political participation in the EU. Your voice matters!',
                'description' => '',
                'about' => '<p>The FAIR EU (Fostering Awareness, Inclusion and Recognition of EU Mobile Citizens’ Political Rights)
                project aims to foster the successful inclusion of EU mobile citizens in their host EU country’s civic
                and political life through the provision of a holistic approach to tackling obstacles they face when
                exercising their rights. <a href="https://ecas.org/projects/fair-eu/">Learn more about our project.</a></p>',
                'footer' => '<p style="font-size: 12px;">© FAIR EU ' . now()->year . '&nbsp;|&nbsp;
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
        DB::table('crowd_sourcing_projects')->insert(array(
            array('id' => 3,
                'name' => 'EICON Public Consultation',
                'slug' => 'eicon',
                'logo_path' => '/images/projects/eicon/logo.png',
                'img_path' => '/images/projects/eicon/active_participation.png',
                'motto' => 'The future is being created now. By us all.<br>So let’s use human-centred tech to make education more inclusive We are planning with teachers, and not for them',
                'description' => '',
                'about' => '<p>EICON’s main objective is to support organisations / institutions providing Vocational Education and Training (VET) 
                            to become more inclusive. In particular, the aim is to put the organisations as a whole in the focus, and not just education and training practice. 
                            Managers of these organisations / institutions are particularly in need for guidance on how to further develop their 
                            organizations, as they often have to work towards multiple aims simultaneously, i.e. inclusion usually is one among other aims. 
                            The typical organizational response to address inclusion is to provide teaching personnel with further qualification and training.
                             <a href="http://www.eicon-project.eu/about.html">Learn more about our project.</a></p>',
                'footer' => '<p style="font-size: 12px;">Copyright © EICON project 2019-2021&nbsp;|&nbsp;
                <a href="http://www.eicon-project.eu/terms-of-use/" target="_blank" title="Read more">Terms of use</a>&nbsp;|&nbsp;
                <a href="http://www.eicon-project.eu/privacy-policy/" target="_blank" title="Read more">Privacy Policy</a>&nbsp;|&nbsp;
                <a href="http://www.eicon-project.eu/cookie-policy/" target="_blank" title="Read more">Cookie Policy</a>
            </p>
            <p style="font-size:13px; line-height:20px;"><img
                        src="http://www.eicon-project.eu/img/erasmus.png" alt=""
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
