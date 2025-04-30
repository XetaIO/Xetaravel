<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Xetaravel\Mail\Contact;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\User;

class PageControllerTest extends TestCase
{
    public function test_index_displays_latest_article(): void
    {
        $article = BlogArticle::latest()->first();

        $response = $this->get(route('page.index'));

        $response->assertOk();
        $response->assertViewIs('page.index');
        $response->assertViewHas('article', $article);
    }

    public function test_terms_returns_view(): void
    {
        $response = $this->get(route('page.terms'));

        $response->assertOk();
        $response->assertViewIs('page.terms');
    }

    public function test_contact_get_displays_contact_page(): void
    {
        $response = $this->get(route('page.contact'));

        $response->assertOk();
        $response->assertViewIs('page.contact');
    }

    public function test_contact_post_sends_mail_and_redirects(): void
    {
        Mail::fake();

        $response = $this->post(route('page.contact'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a valid test message.',
        ]);

        $response->assertRedirect(route('page.contact'));

        Mail::assertSent(Contact::class, function ($mail) {
            return $mail->hasTo(config('xetaravel.site.contact_email'));
        });
    }

    public function test_contact_post_fails_validation(): void
    {
        $response = $this->post(route('page.contact'), [
            'name' => '',
            'email' => 'invalid-email',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
    }

    public function test_banished_view_for_banished_user(): void
    {
        $user = User::find(4);
        $this->actingAs($user);

        $response = $this->get(route('page.banished'));

        $response->assertOk();
        $response->assertViewIs('page.banished');
    }

    public function test_banished_redirects_non_banished_user(): void
    {
        $user = User::find(1);

        $this->actingAs($user);

        $response = $this->get(route('page.banished'));

        $response->assertRedirect(route('page.index'));
    }

    public function test_aboutme_view(): void
    {
        $response = $this->get(route('page.aboutme'));

        $response->assertOk();
        $response->assertViewIs('page.aboutme');
    }
}
