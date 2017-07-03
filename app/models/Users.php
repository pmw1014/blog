<?php
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Mvc\Model\Message;
use App\Models\Base;

class Users extends Base
{
    const HASH = PASSWORD_DEFAULT;
    const COST = 14;

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            "login",
            new Email()
        );
        $validator->add(
            'password',
            new StringLength(
                [
                    "max"            => 30,
                    "min"            => 8,
                    "messageMaximum" => "密码请输入8~30位的字符",
                    "messageMinimum" => "密码请输入8~30位的字符",
                ]
            )
        );

        return $this->validate($validator);
    }

    public function login()
    {
        $row = $this->existUser();
        if($row){
            if (password_verify($this->password, $row['password'])) {
                // Success - Now see if their password needs rehashed
                if (password_needs_rehash($row['password'], self::HASH, ['cost' => self::COST])) {
                    // We need to rehash the password, and save it. Just call setPassword
                    $this->id = $row['id'];
                    $this->created_at = $row['created_at'];
                    $this->save();
                }
                $data['id'] = $row['id'];
                $data['login'] = $row['login'];

                return $data;
            }else{
                $message = new Message(
                    "用户名或密码错误",
                    "password",
                    "LoginError"
                );
                $this->appendMessage($message);
            }
        }
        return false;
    }

    public function existUser()
    {
        $row = $this->modelsManager->createBuilder()
            ->columns(['id','login','password','created_at'])
            ->from('Users')
            ->where('login = :login:',["login"=>$this->login])
            ->limit(1)
            ->getQuery()
            ->execute()
            ->toArray();
        if(array_filter($row)){
            return $row[0];
        }else{
            $message = new Message(
                "当前用户不存在",
                "login",
                "NotExists"
            );
            $this->appendMessage($message);
            return false;
        }
    }

    public function setPwd()
    {
        if(!empty($this->password)){
            $this->password = password_hash($this->password, self::HASH, ['cost' => self::COST]);
        }
    }

    public function afterValidation()
    {
        $this->setPwd();
    }

    public function beforeCreate()
    {
        //TODO: 判断该用户是否已存在
        if($this->existUser()){
            $message = new Message(
                "当前用户已存在",
                "login",
                "AlreadyExists"
            );
            $this->appendMessage($message);
            return false;
        }

    }

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(type="string", length=30, nullable=false)
     */
    public $login;

    /**
     *
     * @var string
     * @Column(type="string", length=60, nullable=false)
     */
    public $password;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $created_at;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $updated_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("blog");

        $this->addBehavior(
            new Timestampable(
                [
                    "beforeCreate" => [
                        "field"  => ['created_at','updated_at'],
                        "format" => 'Y-m-d H:i:s'
                    ],
                    'beforeUpdate' => [
                        'field'  => ['updated_at'],
                        'format' => 'Y-m-d H:i:s'
                    ]
                ]
            )
        );
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'users';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
