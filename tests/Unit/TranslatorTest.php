<?php


namespace Tests\Unit;


use App\Utils\Translator;
use Tests\TestCase;

class TranslatorTest extends TestCase {

    protected $translator;

    protected function setUp(): void {
        parent::setUp();
        $this->translator = $this->app->make(Translator::class);
    }

    public function test_translator_service() {
        $translated = $this->translator->translateTexts(
            [
                'Καλημέρα',
                'Καληνύχτα'
            ],
            'en'
        );
        self::assertEquals($translated[0]['text'], 'good morning');
    }

}
