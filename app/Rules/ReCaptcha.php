<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class ReCaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => env('GOOGLE_RECAPTCHA_SECRET'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        if (!$response['success']) {
            $errorMessage = 'The reCAPTCHA validation failed.';
            if (isset($data['error-codes'])) {
                $errorCodes = $data['error-codes'];
                if (in_array('missing-input-secret', $errorCodes)) {
                    $errorMessage = 'reCAPTCHA configuration error: Missing secret key.';
                } elseif (in_array('invalid-input-secret', $errorCodes)) {
                    $errorMessage = 'reCAPTCHA configuration error: Invalid secret key.';
                } elseif (in_array('missing-input-response', $errorCodes)) {
                    $errorMessage = 'Please complete the reCAPTCHA verification.';
                } elseif (in_array('invalid-input-response', $errorCodes)) {
                    $errorMessage = 'The reCAPTCHA verification was invalid. Please try again.';
                } elseif (in_array('bad-request', $errorCodes)) {
                    $errorMessage = 'reCAPTCHA verification request was malformed.';
                } elseif (in_array('timeout-or-duplicate', $errorCodes)) {
                    $errorMessage = 'reCAPTCHA verification timed out or was already used.';
                }
            }
            $fail($errorMessage);
        }
    }
}