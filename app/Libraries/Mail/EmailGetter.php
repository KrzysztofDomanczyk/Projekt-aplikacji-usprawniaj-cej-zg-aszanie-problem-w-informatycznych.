<?php

namespace App\Libraries\Mail;
// require_once "EmailGetter.php";
// require_once "EmailSender.php";

use App\Libraries\Mail;
use SSilence\ImapClient\ImapClientException;
use SSilence\ImapClient\ImapConnect;
use SSilence\ImapClient\ImapClient as Imap;
use PhpImap\Mailbox;
use PHPMailer\PHPMailer\Exception;
use Webklex\IMAP\Client;




class EmailGetter
{

    private $oClient;
    private $mainFolder = "INBOX";

    public function __construct()
    {
        $this->oClient = new Client([
            'host'          => 'imap.gmail.com',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'username'      => 'ithelperdomanczyk@gmail.com',
            'password'      => 'Krzysiek123456',
            'protocol'      => 'imap'
        ]);  
    }

    public function getAppropriateFolder($aFolder)
    {
        foreach ($aFolder as $oFolder) {
            if($oFolder->name == $this->mainFolder) {
                return $oFolder;
            }
        }
    }

    public function getUnseenMessages()
    {
        $emails = [];
        $this->oClient->connect();
        $aFolder = $this->oClient->getFolders();
        $oFolder =$this->getAppropriateFolder($aFolder);
        try {
            $aMessage = $oFolder->messages()->unseen()->leaveUnread()->get();
        } catch (\Throwable  $e) {
             dd($e->getMessage()); 
        }
        foreach ($aMessage as $oMessage) {
            $email = new Mail;
            $email->setUid($oMessage->getUid());
            $email->setBody($this->getAppropriateBody($oMessage));
            $email->setDate($oMessage->getDate());
            $email->setFrom($oMessage->getFrom());
            $email->setSubject($oMessage->getSubject());
            array_push ($emails, $email);
        }
        return $emails;
    }

    private function getAppropriateBody($oMessage)
    {
        return $oMessage->hasHTMLBody() ? $oMessage->getHTMLBody(true) : $oMessage->getTextBody(true) ;
    }
}
