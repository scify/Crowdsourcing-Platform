<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckQuestionnairePageVisibilitySettings {
    /**
     * CheckQuestionnairePageVisibilitySettings constructor.
     */
    public function __construct(protected \App\BusinessLogicLayer\Questionnaire\QuestionnaireAccessManager $questionnaireAccessManager) {}

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
