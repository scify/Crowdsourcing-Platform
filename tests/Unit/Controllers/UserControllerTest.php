<?php

namespace Tests\Unit\Controllers;

use App\BusinessLogicLayer\Questionnaire\QuestionnaireResponseManager;
use App\BusinessLogicLayer\Solution\SolutionManager;
use App\BusinessLogicLayer\User\UserDashboardManager;
use App\BusinessLogicLayer\User\UserManager;
use App\Http\Controllers\User\UserController;
use App\Models\User\User;
use App\ViewModels\Gamification\GamificationBadgesWithLevels;
use App\ViewModels\User\UserDashboardViewModel;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserControllerTest extends TestCase {
    private User $user;
    private UserDashboardManager $userDashboardManager;
    private UserManager $userManager;
    private QuestionnaireResponseManager $questionnaireResponseManager;
    private SolutionManager $solutionManager;

    protected function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->userDashboardManager = $this->createMock(UserDashboardManager::class);
        $this->userManager = $this->createMock(UserManager::class);
        $this->questionnaireResponseManager = $this->createMock(QuestionnaireResponseManager::class);
        $this->solutionManager = $this->createMock(SolutionManager::class);
        Auth::shouldReceive('user')->andReturn($this->user);
    }

    #[Test]
    public function test_my_dashboard_with_no_badges(): void {
        $this->userDashboardManager->method('getUserDashboardViewModel')
            ->willReturn($this->createDashboardViewModel(0, 0, 0));

        $controller = new UserController($this->userManager, $this->questionnaireResponseManager, $this->userDashboardManager, $this->solutionManager);
        $response = $controller->myDashboard();

        $this->assertEquals('backoffice.my-dashboard', $response->name());
        $this->assertArrayHasKey('viewModel', $response->getData());
        $viewModel = $response->getData()['viewModel'];
        $this->assertCount(0, $viewModel->platformWideGamificationBadgesVM->badgesWithLevelsList);
        $this->assertCount(0, $viewModel->questionnaires);
        $this->assertCount(0, $viewModel->projectsWithActiveProblems);
    }

    #[Test]
    public function test_my_dashboard_with_badges(): void {
        $this->userDashboardManager->method('getUserDashboardViewModel')
            ->willReturn($this->createDashboardViewModel(3, 2, 1));

        $controller = new UserController($this->userManager, $this->questionnaireResponseManager, $this->userDashboardManager, $this->solutionManager);
        $response = $controller->myDashboard();

        $this->assertEquals('backoffice.my-dashboard', $response->name());
        $this->assertArrayHasKey('viewModel', $response->getData());
        $viewModel = $response->getData()['viewModel'];
        $this->assertCount(3, $viewModel->platformWideGamificationBadgesVM->badgesWithLevelsList);
        $this->assertCount(2, $viewModel->questionnaires);
        $this->assertCount(1, $viewModel->projectsWithActiveProblems);
    }

    private function createDashboardViewModel(int $numBadges, int $numQuestionnaires, int $numProjects): UserDashboardViewModel {
        $badges = collect();
        for ($i = 0; $i < $numBadges; $i++) {
            $badges->push((object) ['statusMessage' => 'Badge ' . $i, 'messageForLevel' => 'Level ' . $i, 'level' => $i]);
        }

        $questionnaires = collect();
        for ($i = 0; $i < $numQuestionnaires; $i++) {
            $questionnaires->push((object) ['id' => $i, 'fieldsTranslation' => (object) ['title' => 'Questionnaire ' . $i]]);
        }

        $projects = collect();
        for ($i = 0; $i < $numProjects; $i++) {
            $projects->push((object) ['id' => $i, 'currentTranslation' => (object) ['name' => 'Project ' . $i]]);
        }

        $platformWideGamificationBadgesVM = new GamificationBadgesWithLevels($badges);

        return new UserDashboardViewModel($questionnaires, $projects, $platformWideGamificationBadgesVM, $this->user);
    }
}
