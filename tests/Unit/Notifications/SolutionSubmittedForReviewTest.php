<?php

declare(strict_types=1);

namespace Tests\Unit\Notifications;

use App\Models\Solution\Solution;
use App\Models\User\User;
use App\Notifications\SolutionSubmittedForReview;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SolutionSubmittedForReviewTest extends TestCase {
    /**
     * GIVEN a solution whose author nickname and title contain HTML
     * WHEN the review email is rendered
     * THEN the HTML is escaped
     */
    #[Test]
    public function mail_escapes_user_supplied_values(): void {
        $payload = '<b>injected</b>';
        $solution = Solution::whereHas('creator')->whereHas('problem.project')->firstOrFail();
        $solution->creator->nickname = $payload;
        $solution->defaultTranslation->title = $payload;

        $html = (string) (new SolutionSubmittedForReview($solution))->toMail(User::factory()->make())->render();

        $this->assertStringNotContainsString($payload, $html);
        $this->assertStringContainsString(e($payload), $html);
    }
}
