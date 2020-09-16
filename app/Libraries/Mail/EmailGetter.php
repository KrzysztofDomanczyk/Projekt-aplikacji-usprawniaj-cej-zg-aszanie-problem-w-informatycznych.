<?php

namespace App\Libraries\Mail;
// require_once "EmailGetter.php";
// require_once "EmailSender.php";




use SSilence\ImapClient\ImapClientException;
use SSilence\ImapClient\ImapConnect;
use SSilence\ImapClient\ImapClient as Imap;
use PhpImap\Mailbox;
use Webklex\IMAP\Client;


class EmailGetter
{

    private $_mailbox;
    private $_username;
    private $_password;
    private $_encryption;
    private $_imap;

    public function __construct()
    {


        $oClient = new Client([
            'host'          => 'imap.gmail.com',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'username'      => 'ithelperdomanczyk@gmail.com',
            'password'      => 'Krzysiek123456',
            'protocol'      => 'imap'
        ]);
      
        $oClient->connect();
        $aFolder = $oClient->getFolders();
        //Loop through every Mailbox
        /** @var \Webklex\IMAP\Folder $oFolder */
        foreach ($aFolder as $oFolder) {

            //Get all Messages of the current Mailbox $oFolder
            /** @var \Webklex\IMAP\Support\MessageCollection $aMessage */
            $aMessage = $oFolder->messages()->all()->get();

            /** @var \Webklex\IMAP\Message $oMessage */
            foreach ($aMessage as $oMessage) {
                echo $oMessage->getSubject() . '<br />';
                echo 'Attachments: ' . $oMessage->getAttachments()->count() . '<br />';
                echo $oMessage->getHTMLBody(true);

                //Move the current Message to 'INBOX.read'
                if ($oMessage->moveToFolder('INBOX.read') == true) {
                    echo 'Message has ben moved';
                } else {
                    echo 'Message could not be moved';
                }
            }
        }
        dd($aFolder);
    }
}
