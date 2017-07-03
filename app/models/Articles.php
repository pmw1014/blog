<?php
use App\Models\Base;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Message;

class Articles extends Base
{
    const DELETED = 0;

    public function validation()
    {
        if (empty(trim($this->title))) {
            $message = new Message(
                "请输入标题",
                "title",
                "field"
            );
            $this->appendMessage($message);
            return false;
        }

        return true;
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
     * @Column(type="string", length=100, nullable=false)
     */
    public $title;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=false)
     */
    public $description;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    public $state;

    /**
     *
     * @var string
     * @Column(type="string", length=200, nullable=true)
     */
    public $cover;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $tag_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $catalog_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $user_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $viewed;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $create_at;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $update_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("blog");

        $this->hasOne(
            'id',
            'ArticleBody',
            'articles_id'
        );

        $this->belongsTo(
            'tag_id',
            'RefTags',
            'id'
        );

        $this->belongsTo(
            'catalog_id',
            'Catalogs',
            'id'
        );

        $this->addBehavior(
            new Timestampable(
                [
                    "beforeCreate" => [
                        "field"  => ['create_at','update_at'],
                        "format" => 'Y-m-d H:i:s'
                    ],
                    'beforeUpdate' => [
                        'field'  => ['update_at'],
                        'format' => 'Y-m-d H:i:s'
                    ]
                ]
            )
        );
        $this->addBehavior(
            new SoftDelete(
                [
                    "field" => "state",
                    "value" => self::DELETED,
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
        return 'articles';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Articles[]|Articles
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Articles
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
