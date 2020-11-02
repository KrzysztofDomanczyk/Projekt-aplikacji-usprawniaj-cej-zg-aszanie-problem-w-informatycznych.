<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function guestCantSeeProjectsPage()
    {
        $response = $this->get('/projects');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function guestCantSeehomePage()
    {
        $response = $this->get('/home');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function authorizedAndImapCorrectlyUserCanSeeHomePage()
    {
        $this->actingAs(factory(User::class)->create([
            'host_imap' => 'imap.gmail.com',
            'username_imap' => 'ithelperdomanczyk@gmail.com',
            'password_imap' => 'Krzysiek123456',
        ]));

        $response = $this->get('/home');
        $response->assertOk();
    }

      /** @test */
      /**
       * @test
     * @expectedException InvalidArgumentException
     */
      public function authorizedAndNotImapCorrectlyUserMustBeRedirectToSettings()
      {
          $this->withoutExceptionHandling();
          $this->actingAs(factory(User::class)->create([
              'host_imap' => 'imap.gmail.com',
              'username_imap' => '2ithelperdomanczyk@gmail.com',
              'password_imap' => 'Krzysiek123456',
          ]));
          
          $response = $this->get('/home');
          $this->expectException(\Webklex\IMAP\Exceptions\ConnectionFailedException::class);
        //   $response->assertRedirect('/user-settings');
        
      }
}
