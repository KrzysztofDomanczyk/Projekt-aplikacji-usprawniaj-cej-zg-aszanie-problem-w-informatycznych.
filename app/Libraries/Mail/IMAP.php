<?php

namespace App\Libraries\Mail;
// require_once "IMAP.php";
// require_once "EmailSender.php";

use App\Libraries\Mail;
use PhpImap\Mailbox;
use PHPMailer\PHPMailer\Exception;
use Webklex\IMAP\Client;
use Illuminate\Support\Facades\Redirect;




class IMAP
{

    private $oClient;
    private $mainFolder = "INBOX";
    private $oFolder;
    CONST SEEN_FLAG = "Seen";
    CONST UNSEEN_FLAG = "Unseen";

    public function __construct($user)
    {
        $this->oClient = new Client([
            'host'          => "$user->host_imap",
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'username'      => "$user->username_imap",
            'password'      => "$user->password_imap",
            'protocol'      => 'imap'
        ]);  

        
            $this->oClient->connect();
       
      
      
        $aFolder = $this->oClient->getFolders();
        $this->oFolder =$this->getAppropriateFolder($aFolder);
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
        try {
            $aMessage = $this->oFolder->messages()->unseen()->leaveUnread()->get();
        } catch (\Throwable  $e) {
             dd($e->getMessage()); 
        }
        foreach ($aMessage as $oMessage) {
            $email = new Mail($oMessage);
            array_push ($emails, $email);
        }
        return $emails;
    }

    public function getMessageByUid($uid)
    {
        
        $message = $this->oFolder->getMessage($uid);
        $email = new Mail($message);
        return $email;
    }

    public function setSeenFlag($email_uid) : void
    {
        $oMessage = $this->oFolder->getMessage($email_uid);
        $oMessage->setFlag([self::SEEN_FLAG]);
    }

    public function setUnseenFlag($email_uid) : void
    {
        $oMessage = $this->oFolder->getMessage($email_uid);
        $oMessage->setFlag([self::UNSEEN_FLAG]);
    }
}
