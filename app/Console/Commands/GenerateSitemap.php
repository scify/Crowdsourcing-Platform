<?php

namespace App\Console\Commands;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use Illuminate\Console\Command;
use Spatie\Crawler\Crawler;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;
use Symfony\Component\Console\Command\Command as CommandAlias;

class GenerateSitemap extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a sitemap for better SEO';

    protected $crowdSourcingProjectManager;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CrowdSourcingProjectManager $crowdSourcingProjectManager) {
        parent::__construct();
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $alternateLanguages = [];
        $translatablePublicPages = ['/', '/terms-and-privacy', '/code-of-conduct'];
        $translatablePublicPagesAvailability = [
            '/terms-and-privacy' => ['bg', 'de', 'el', 'en', 'es', 'et', 'fr', 'hu', 'it', 'lv', 'nl', 'pt', 'sk', 'sr'],
            '/code-of-conduct' => ['bg', 'de', 'el', 'en', 'et', 'fr', 'hu', 'lv', 'nl', 'pt', 'sr'],
        ];
        foreach (explode('|', config('app.regex_for_validating_locale_at_routes')) as $language) {
            if (strlen($language) === 2 && $language !== 'en') {
                $alternateLanguages[] = $language;
            }
        }

        $sitemapGenerator = SitemapGenerator::create(config('app.url'))
            ->configureCrawler(function (Crawler $crawler) {
                $crawler->setMaximumDepth(3);
            })
            ->getSitemap();

        $projects = $this->crowdSourcingProjectManager->getCrowdSourcingProjectsForHomePage();

        foreach ($projects as $project) {
            $link = Url::create('/en/' . $project->slug);
            foreach ($alternateLanguages as $alternateLanguage) {
                $link->addAlternate('/' . $alternateLanguage . '/' . $project->slug, $alternateLanguage);
            }
            $sitemapGenerator->add($link);
        }

        foreach ($translatablePublicPages as $translatablePublicPage) {
            $link = Url::create($translatablePublicPage . 'en');
            $languagesToCrawl = $translatablePublicPagesAvailability[$translatablePublicPage] ?? $alternateLanguages;
            foreach ($languagesToCrawl as $alternateLanguage) {
                $link->addAlternate($alternateLanguage . $translatablePublicPage, $alternateLanguage);
            }
            $sitemapGenerator->add($link);
        }
        $sitemapGenerator->add(Url::create('/newsletter'));


        $sitemapGenerator->writeToFile(public_path('sitemap.xml'));

        return CommandAlias::SUCCESS;
    }
}
