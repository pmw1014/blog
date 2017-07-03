<?php
use App\Models\Base;
use Phalcon\Mvc\Model\Behavior\Timestampable;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Message;

class Catalogs extends Base
{
    const DELETED = 0;

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
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $user_id;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    public $title;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $parent_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $state;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $created_at;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $updated_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("blog");

        $this->hasMany(
            "id",
            "Articles",
            "catalog_id"
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
        return 'catalogs';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Catalogs[]|Catalogs
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Catalogs
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
