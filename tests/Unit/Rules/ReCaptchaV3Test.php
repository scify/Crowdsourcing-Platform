<?php

namespace Unit\Rules;

use App\Rules\ReCaptchaV3;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ReCaptchaV3Test extends TestCase {
    /**
     * Test that reCAPTCHA verifies successfully with a valid response.
     * @throws ConnectionException when the connection to the reCAPTCHA service fails.
     */
    public function test_re_captch_a_verifies_successfully_with_valid_response(): void {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
                'score' => 0.9,
                'action' => 'submitSolution',
            ], 200),
        ]);

        $rule = new ReCaptchaV3('submitSolution', 0.5);
        $fail = function ($message): void {
            $this->fail($message);
        };

        $rule->validate('g-recaptcha-response', 'valid-recaptcha-response', $fail);

        $this->assertTrue(true); // Assert that no exception was thrown
    }

    /**
     * Test that reCAPTCHA fails with an invalid response.
     * @throws ConnectionException when the connection to the reCAPTCHA service fails.
     */
    public function test_re_captch_a_fails_with_invalid_response(): void {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => false,
            ], 200),
        ]);

        $rule = new ReCaptchaV3('submitSolution', 0.5);
        $fail = function ($message): void {
            $this->assertEquals('Your form submission failed the Google reCAPTCHA verification, please try again.', $message);
        };

        $rule->validate('g-recaptcha-response', 'invalid-recaptcha-response', $fail);
    }

    /**
     * Test that reCAPTCHA fails with a low score.
     * @throws ConnectionException when the connection to the reCAPTCHA service fails.
     */
    public function test_re_captch_a_fails_with_low_score(): void {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
                'score' => 0.3,
                'action' => 'submitSolution',
            ], 200),
        ]);

        $rule = new ReCaptchaV3('submitSolution', 0.5);
        $fail = function ($message): void {
            $this->assertEquals('The Google reCAPTCHA verification score was too low, please try again.', $message);
        };

        $rule->validate('g-recaptcha-response', 'valid-recaptcha-response', $fail);
    }

    /**
     * Test that reCAPTCHA fails with a wrong action.
     * @throws ConnectionException when the connection to the reCAPTCHA service fails.
     */
    public function test_re_captch_a_fails_with_wrong_action(): void {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
                'score' => 0.9,
                'action' => 'wrongAction',
            ], 200),
        ]);

        $rule = new ReCaptchaV3('submitSolution', 0.5);
        $fail = function ($message): void {
            $this->assertEquals('The action found in the form didn\'t match the Google reCAPTCHA action, please try again.', $message);
        };

        $rule->validate('g-recaptcha-response', 'valid-recaptcha-response', $fail);
    }

    /**
     * Test that reCAPTCHA fails with a connection exception.
     * @throws ConnectionException when the connection to the reCAPTCHA service fails.
     */
    public function test_re_captch_a_fails_with_connection_exception(): void {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(null, 500),
        ]);

        $rule = new ReCaptchaV3('submitSolution', 0.5);
        $fail = function ($message): void {
            $this->assertEquals('Google reCAPTCHA was not able to verify the form, please try again.', $message);
        };

        $rule->validate('g-recaptcha-response', 'valid-recaptcha-response', $fail);
    }
}
