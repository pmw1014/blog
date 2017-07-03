<?php
use App\Models\Base;
use Phalcon\Mvc\Model\Message;

class RefTags extends Base
{

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
     * @Column(type="string", length=50, nullable=true)
     */
    public $title;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=true)
     */
    public $state;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $create_at;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $update_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("blog");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'ref_tags';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return RefTags[]|RefTags
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return RefTags
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
