<?php

// EmailVerificationPromptController.php

// EmailVerificationPromptController.php

// EmailVerificationPromptController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param  Request  $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('dashboard', absolute: false))
                    : Inertia::render('VerifyEmail', [ // Render the VerifyEmail component
                        'status' => session('status'),
                        'verificationNoticeRoute' => route('verification.notice') // Pass the verification notice route to the frontend
                    ]);
    }
}



