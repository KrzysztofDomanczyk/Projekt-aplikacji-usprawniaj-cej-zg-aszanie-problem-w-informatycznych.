<?php

namespace Tests\Feature;

use App\TicketMessage;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TicketMessagesTest extends TestCase
{
    // use RefreshDatabase;
    // use DatabaseMigrations;
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     * 
     */
    /** @test */
    public function a_user_can_send_message_with_ticket_email()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());

        $param = [
            "content" => "a_user_can_send_message_with_ticket_email",
            "ticket_id" => "3"
        ];
         
        $response = $this->post('/ticketMessage', $param);

        $this->assertDatabaseHas('ticket_messages', [
            'content' => 'a_user_can_send_message_with_ticket_email',
        ]);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     * 
     */
    /** @test */
    public function a_user_can_send_message_without_ticket_email()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());


        $param = [
            "content" => "a_user_can_send_message_without_ticket_email",
            "ticket_id" => "1",
            "email" => "test@wp.pl"
        ];
         
        $response = $this->post('/ticketMessage', $param);

        $this->assertDatabaseHas('ticket_messages', [
            'content' => 'a_user_can_send_message_without_ticket_email',
        ]);
    }
}
