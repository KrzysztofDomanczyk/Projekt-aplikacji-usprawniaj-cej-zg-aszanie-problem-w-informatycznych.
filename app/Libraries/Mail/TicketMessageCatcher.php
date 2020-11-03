<?php

namespace App\Libraries\Mail;

use App\TicketMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TicketMessageCatcher
{
    private $imap;
    private $emails;
    CONST REGEX_IS_TICKET_MESSAGE = '/\[IT#[0-9]*\]/';
    CONST REGEX_ID_TICKET_MESSAGE = '/-?(?:[0-9]+(?:\.[0-9]*)?|(?:[0-9]+)?\.[0-9]+)/';
    CONST SEEN_FLAG = "Seen";
    public function __construct()
    {
        $this->imap = new IMAP(Auth::user());
        $this->emails = $this->imap->getUnseenMessages();
    }

    public function catch()
    {
        foreach($this->emails as $email)
        {
            if ($this->isTicketMessage($email)) {
                $this->createTicketMesssage($email);
                $email->source_mail->setFlag([self::SEEN_FLAG]);   
            }   
        }
    }

    private function isTicketMessage($email) 
    {
        return preg_match(self::REGEX_IS_TICKET_MESSAGE, $email->getSubject()) == 1;
    }

    private function createTicketMesssage($email)
    {
        $idTicket = $this->getIdTicket($email->getSubject());
        TicketMessage::create([
            'sender_email' => $email->getNameFrom(),
            'content' => $email->getBody(),
            'ticket_id' => $idTicket
        ]); 
    }

    private function getIdTicket($subject)
    {
        preg_match(self::REGEX_IS_TICKET_MESSAGE, $subject, $prefiks);
        preg_match(self::REGEX_ID_TICKET_MESSAGE, $prefiks[0], $id);
        return (int) $id[0];
    }
 
}
