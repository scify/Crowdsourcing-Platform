<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\BusinessLogicLayer\Questionnaire\QuestionnaireAccessManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckQuestionnairePageVisibilitySettings {
    /**
     * CheckQuestionnairePageVisibilitySettings constructor.
     */
    public function __construct(protected QuestionnaireAccessManager $questionnaireAccessManager) {}

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $questionnaire = $request->route('questionnaire');
        if ($this->questionnaireAccessManager->userHasAccessToViewQuestionnaireStatisticsPage(Auth::user(), $questionnaire)) {
            return $next($request);
        }

        return redirect()->route('login', ['locale' => app()->getLocale(), 'redirectTo' => $request->fullUrl()])
            ->with('flash_message_error', __('You do not have access to this page.'));
    }
}
