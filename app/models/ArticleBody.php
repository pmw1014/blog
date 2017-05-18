<?php

class ArticleBody extends Base
{

    public function validation()
    {
        if (empty(trim($this->body))) {
            $message = new Message(
                "please enter the body",
                "body",
                "validate"
            );
            $this->appendMessage($message);
            return false;
        }

        return true;
    }

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $a_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $body;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("blog");
        $this->belongsTo(
            'articles_id',
            'Articles',
            'id'
        );
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'article_body';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ArticleBody[]|ArticleBody
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ArticleBody
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
