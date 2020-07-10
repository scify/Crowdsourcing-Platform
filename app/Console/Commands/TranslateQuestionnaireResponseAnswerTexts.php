<?php

namespace App\Console\Commands;

use App\BusinessLogicLayer\questionnaire\QuestionnaireResponseAnswerTranslator;
use Illuminate\Console\Command;

class TranslateQuestionnaireResponseAnswerTexts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:questionnaire_answer_texts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command translates any questionnaire response answer texts that have not been translated yet.';

    private $questionnaireResponseAnswerTranslator;

    public function __construct(QuestionnaireResponseAnswerTranslator $questionnaireResponseAnswerTranslator)
    {
        parent::__construct();
        $this->questionnaireResponseAnswerTranslator = $questionnaireResponseAnswerTranslator;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->questionnaireResponseAnswerTranslator->translateAllNonTranslatedAnswerTexts();
    }
}
