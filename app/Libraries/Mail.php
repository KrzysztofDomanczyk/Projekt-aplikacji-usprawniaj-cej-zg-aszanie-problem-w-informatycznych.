<?php

namespace App\Libraries;



class Mail
{
    private $uid;
    private $subject;
    private $date;
    private $from;
    private $body;
 
    public function __construct($oMessage)
    {
        $this->setUid($oMessage->getUid());
        $this->setBody($this->getAppropriateBody($oMessage));
        $this->setDate($oMessage->getDate());
        $this->setFrom($oMessage->getFrom());
        $this->setSubject($oMessage->getSubject());
    }

    private function getAppropriateBody($oMessage)
    {
        return $oMessage->hasHTMLBody() ? $oMessage->getHTMLBody(true) : $oMessage->getTextBody(true) ;
    }

    public function getUrlBodyContent()
    {
        return route('mailBody', ['id' => $this->uid]);
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of subject
     */ 
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set the value of subject
     *
     * @return  self
     */ 
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get the value of from
     */ 
    public function getFrom()
    {
        return $this->from;
    }

    public function getNameFrom()
    {
        return $this->from[0]->mail;
    }

    /**
     * Set the value of from
     *
     * @return  self
     */ 
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get the value of body
     */ 
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the value of body
     *
     * @return  self
     */ 
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get the value of uid
     */ 
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Set the value of uid
     *
     * @return  self
     */ 
    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }
}


