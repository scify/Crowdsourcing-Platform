<?php

namespace Database\Seeders;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\CrowdSourcingProject\CrowdSourcingProjectTranslation;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectTranslationRepository;
use App\Repository\CrowdSourcingProjectRepository;
use App\Utils\Helpers;
use Illuminate\Database\Seeder;

class DefaultProjectSeeder extends Seeder {
    protected $projectRepository;
    protected $projectTranslationRepository;

    public function __construct(CrowdSourcingProjectRepository $crowdSourcingProjectRepository,
                                CrowdSourcingProjectTranslationRepository $crowdSourcingProjectTranslationRepository) {
        $this->projectRepository = $crowdSourcingProjectRepository;
        $this->projectTranslationRepository = $crowdSourcingProjectTranslationRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            [
                'id' => 1,
                'name' => 'Crowdsourcing Demo Project',
                'slug' => 'crowdsourcing-demo',
                'logo_path' => '/images/projects/demo/logo.png',
                'img_path' => '/images/projects/demo/logo-bg.png',
                'motto_title' => 'Please share with us your opinion on an important subject. Your voice matters!',
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
                'language_id' => 6,
                'status_id' => CrowdSourcingProjectStatusLkp::DRAFT,
            ],
            [
                'id' => 2,
                'name' => 'FAIR EU',
                'slug' => 'fair-eu',
                'logo_path' => '/images/projects/ecas/fair-eu.png',
                'img_path' => '/images/projects/ecas/fair-eu-bg.png',
                'motto_title' => 'Please share with us your opinion on obstacles to free movement and <br>political participation in the EU. Your voice matters!',
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
                'language_id' => 6,
                'status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED,
            ],
        ];

        foreach ($data as $project) {
            $project = $this->projectRepository->updateOrCreate(['id' => $project['id']],
                Helpers::getFilteredAttributes($project, (new CrowdSourcingProject())->getFillable()));
            $this->projectTranslationRepository->updateOrCreate(['project_id' => $project['id'], 'language_id' => $project['language_id']],
                Helpers::getFilteredAttributes($project, (new CrowdSourcingProjectTranslation())->getFillable()));
            echo "\nAdded Project: " . $project['name'] . ' with slug: ' . $project->slug . "\n";
        }
    }
}
