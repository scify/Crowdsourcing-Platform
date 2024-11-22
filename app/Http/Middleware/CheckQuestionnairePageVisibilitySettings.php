<?php

namespace App\Http\Middleware;

use App\BusinessLogicLayer\Questionnaire\QuestionnaireAccessManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckQuestionnairePageVisibilitySettings {
    protected $questionnaireAccessManager;

    /**
     * CheckQuestionnairePageVisibilitySettings constructor.
     */
    public function __construct(QuestionnaireAccessManager $questionnaireAccessManager) {
        $this->questionnaireAccessManager = $questionnaireAccessManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $questionnaire = $request->route('questionnaire');
        if ($this->questionnaireAccessManager->userHasAccessToViewQuestionnaireStatisticsPage(Auth::user(), $questionnaire)) {
            return $next($request);
        }

        return redirect()->route('home', ['locale' => app()->getLocale()]);
    }
}
