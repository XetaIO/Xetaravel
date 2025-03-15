<?php
namespace Tests\Feature\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;
use Xetaravel\Models\User;

class VerificationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_show()
    {
        $response = $this->get('auth/email/verify/test');
        $response->assertSuccessful();
    }

    public function test_verify()
    {
        $user = User::find(2);
        $this->assertNull($user->email_verified_at);

        $hash = base64_encode('moderator@xetaravel.io');
        $url = URL::signedRoute('auth.verification.verify', ['id' => 2, 'hash' => $hash]);
        $response = $this->get($url);

        $response->assertRedirect();
        $this->assertAuthenticated();

        $user = User::find(2);
        $this->assertNotNull($user->email_verified_at);
    }

    public function test_resend()
    {
        $response = $this->post('auth/email/resend', ['hash' => base64_encode('moderator@xetaravel.io')]);
        $response->assertSessionHas('resent', true);
    }

    public function test_resend_already_verified_email()
    {
        $hash = base64_encode('moderator@xetaravel.io');
        $url = URL::signedRoute('auth.verification.verify', ['id' => 2, 'hash' => $hash]);
        $this->get($url);

        $response = $this->post('users/email/resend', ['hash' => $hash]);
        $response->assertSessionMissing('resent');
    }
}
