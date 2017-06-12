<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;

class Base extends Model
{

    public function getMessages()
    {
        $messages = [];
        if(parent::getMessages()){
            foreach (parent::getMessages() as $message) {
                switch ($message->getType()) {
                    case "InvalidCreateAttempt":
                        $messages[] = "不可新增已存在的数据";
                        break;

                    case "InvalidUpdateAttempt":
                        $messages[] = "不可更新不存在的数据";
                        break;

                    case "PresenceOf":
                        $messages[] = "字段： " . $message->getField() . " 是必须的";
                        break;
                    case 'Email':
                        $messages[] = '请填入有效的邮箱地址';
                        break;
                    default:
                        $messages[] = $message->getMessage();
                        break;
                }
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
