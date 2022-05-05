<?php
namespace Tests\Http\Controllers;

use Xetaravel\Models\Newsletter;
use Tests\TestCase;

class NewsletterControllerTest extends TestCase
{
    /**
     * testSubscribeSuccess method
     *
     * @return void
     */
    public function testSubscribeSuccess()
    {
        $data = [
            'email' => 'newsletter@xetaravel.io'
        ];
        $response = $this->post('/newsletter/subscribe', $data);
        $response->assertRedirect();

        $newsletter = Newsletter::where('email', $data['email'])->first();
        $this->assertSame($newsletter->email, $data['email']);
    }

    /**
     * testUnsubscribe method
     *
     * @return void
     */
    public function testUnsubscribe()
    {
        $data = [
            'email' => 'newsletter@xetaravel.io'
        ];
        $response = $this->post('/newsletter/subscribe', $data);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        $response = $this->get('/newsletter/unsubscribe/' . $data['email']);
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }
}
