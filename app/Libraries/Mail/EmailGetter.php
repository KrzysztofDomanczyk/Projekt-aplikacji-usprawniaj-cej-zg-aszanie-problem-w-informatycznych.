<?php

namespace App\Libraries\Mail;
// require_once "EmailGetter.php";
// require_once "EmailSender.php";



require_once app_path() . "\libraries\Imap\autoload.php";
use SSilence\ImapClient\ImapClientException;
use SSilence\ImapClient\ImapConnect;
use SSilence\ImapClient\ImapClient as Imap;
use PhpImap\Mailbox;


class EmailGetter
{

    private $_mailbox;
    private $_username;
    private $_password;
    private $_encryption;
    private $_imap;

    public function __construct()
    {
        $mailbox = new Mailbox(
            '{imap.gmail.com:993/imap/ssl}INBOX', // IMAP server and mailbox folder
            'ithelperdomanczyk@gmail.com', // Username for the before configured mailbox
            'Krzysiek123456' // Password for the before configured username
            
            // 'US-ASCII' // Server encoding (optional)
        );
        
        try {
            // Search in mailbox folder for specific emails
            // PHP.net imap_search criteria: http://php.net/manual/en/function.imap-search.php
            // Here, we search for "all" emails
            $mails_ids = $mailbox->searchMailbox('UNSEEN');
        } catch(PhpImap\Exceptions\ConnectionException $ex) {
            echo "IMAP connection failed: " . $ex;
            die();
        }
        
        // Change default path delimiter '.' to '/'
        $mailbox->setPathDelimiter('/');
        
        // Switch server encoding
        $mailbox->setServerEncoding('UTF-8');
        
        // Change attachments directory
        // Useful, when you did not set it at the beginning or
        // when you need a different folder for eg. each email sender
        // $mailbox->setAttachmentsDir('/var/www/example.com/ticket-system/imap/attachments');
        
        // Disable processing of attachments, if you do not require the attachments
        // This significantly improves the performance
        // $mailbox->setAttachmentsIgnore(false);
        
        // Loop through all emails
        foreach($mails_ids as $mail_id) {
            // Just a comment, to  see, that this is the begin of an email
            echo "+------ P A R S I N G ------+\n";
        
            // Get mail by $mail_id
            $email = $mailbox->getMail(
                $mail_id, // ID of the email, you want to get
                false // Do NOT mark emails as seen
            );
            dump($email);
         
             dump("from-name: " . (isset($email->fromName)) ? $email->fromName : $email->fromAddress);
             dump("from-email: " . $email->fromAddress);
      
             dump("subject: " . $email->subject);
             dump("message_id: " . $email->messageId);
        
        
            if($email->textHtml) {
                 dump("Message HTML:\n" . $email->textHtml);
            } else {
                dump("Message Plain:\n" . $email->textPlain);
            }
        
            // if(!empty($email->autoSubmitted)) {
            //     // Mark email as "read" / "seen"
            //     $mailbox->markMailAsRead($mail_id);
            //             echo "+------ IGNORING: Auto-Reply ------+";
            // }
        
            // if(!empty($email_content->precedence)) {
            //     // Mark email as "read" / "seen"
            //     $mailbox->markMailAsRead($mail_id);
            //     echo "+------ IGNORING: Non-Delivery Report/Receipt ------+";
            // }
        }
        
        // Disconnect from mailbox
        $mailbox->disconnect();       
    }   
}
?>

