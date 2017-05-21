<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;

class Base extends Model
{

    public function getMessages()
    {
        $messages = [];

        foreach (parent::getMessages() as $message) {
            switch ($message->getType()) {
                case "InvalidCreateAttempt":
                    $messages[] = "The record cannot be created because it already exists | ";
                    break;

                case "InvalidUpdateAttempt":
                    $messages[] = "The record cannot be updated because it doesn't exist | ";
                    break;

                case "PresenceOf":
                    $messages[] = "The field " . $message->getField() . " is mandatory | ";
                    break;
                default:
                    $msg = 'Message: '.$message->getMessage().' | ';
                    $msg .= 'Field: '.$message->getField().' | ';
                    $msg .= 'Type: '.$message->getType().' | ';
                    $messages[] = $msg;
                    break;
            }
        }

        return $messages;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        parent::initialize();
    }

}
