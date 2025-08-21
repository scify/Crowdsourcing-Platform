<?php

declare(strict_types=1);

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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(protected CrowdSourcingProjectManager $crowdSourcingProjectManager) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int {
        $alternateLanguages = [];
        $translatablePublicPages = ['/', '/terms-and-privacy', '/code-of-conduct'];
        $translatablePublicPagesAvailability = [
            '/terms-and-privacy' => ['bg', 'de', 'el', 'en', 'es', 'et', 'fr', 'hu', 'it', 'lv', 'nl', 'pt', 'sk', 'sr'],
            '/code-of-conduct' => ['bg', 'de', 'el', 'en', 'et', 'fr', 'hu', 'lv', 'nl', 'pt', 'sr'],
        ];
        foreach (explode('|', (string) config('app.regex_for_validating_locale_at_routes')) as $language) {
            if (strlen($language) === 2 && $language !== 'en') {
                $alternateLanguages[] = $language;
            }
        }

        $sitemapGenerator = SitemapGenerator::create(config('app.url'))
            ->configureCrawler(function (Crawler $crawler): void {
                $crawler->setMaximumDepth(3);
            })
            ->getSitemap();

        $crowdSourcingProjectsForHomePage = $this->crowdSourcingProjectManager->getCrowdSourcingProjectsForHomePage();

        foreach ($crowdSourcingProjectsForHomePage as $crowdSourcingProjectForHomePage) {
            $link = Url::create('/en/' . $crowdSourcingProjectForHomePage->slug);
            foreach ($alternateLanguages as $alternateLanguage) {
                $link->addAlternate('/' . $alternateLanguage . '/' . $crowdSourcingProjectForHomePage->slug, $alternateLanguage);
            }

            $sitemapGenerator->add($link);
        }

        foreach ($translatablePublicPages as $translatablePublicPage) {
            $link = Url::create($translatablePublicPage . 'en');
            $languagesToCrawl = $translatablePublicPagesAvailability[$translatablePublicPage] ?? $alternateLanguages;
            foreach ($languagesToCrawl as $languageToCrawl) {
                $link->addAlternate($languageToCrawl . $translatablePublicPage, $languageToCrawl);
            }

            $sitemapGenerator->add($link);
        }

        $sitemapGenerator->writeToFile(public_path('sitemap.xml'));

        return CommandAlias::SUCCESS;
    }
}
