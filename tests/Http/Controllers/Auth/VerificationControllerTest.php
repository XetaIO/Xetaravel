<?php
namespace Tests\Http\Controllers\Auth;

use Illuminate\Support\Facades\URL;
use Tests\TestCase;
use Xetaravel\Models\User;

class VerificationControllerTest extends TestCase
{
    /**
     * testShow method
     *
     * @return void
     */
    public function testShow()
    {
        $response = $this->get('users/email/verify/test');
        $response->assertSuccessful();
    }

    /**
     * testVerify method
     *
     * @return void
     */
    public function testVerify()
    {
        $user = User::find(2);
        $this->assertNull($user->email_verified_at);

        $hash = sha1('moderator@xetaravel.io');
        $url = URL::signedRoute('users.auth.verification.verify', ['id' => 2, 'hash' => $hash]);
        $response = $this->get($url);

        $response->assertRedirect();
        $this->assertAuthenticated();

        $user = User::find(2);
        $this->assertNotNull($user->email_verified_at);
    }

    /**
     * testResend method
     *
     * @return void
     */
    public function testResend()
    {
        $response = $this->post('users/email/resend', ['hash' => base64_encode(2)]);
        $response->assertSessionHas('resent', true);
    }

    /**
     * testResendAlreadyVerifiedEmail method
     *
     * @return void
     */
    public function testResendAlreadyVerifiedEmail()
    {
        $hash = sha1('moderator@xetaravel.io');
        $url = URL::signedRoute('users.auth.verification.verify', ['id' => 2, 'hash' => $hash]);
        $response = $this->get($url);

        $response = $this->post('users/email/resend', ['hash' => base64_encode(2)]);
        $response->assertSessionMissing('resent');
    }
}
