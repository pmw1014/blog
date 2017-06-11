<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class ArticlesMigration_101
 */
class ArticlesMigration_101 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('articles', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'title',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "",
                            'notNull' => true,
                            'size' => 100,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'description',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "",
                            'notNull' => true,
                            'size' => 200,
                            'after' => 'title'
                        ]
                    ),
                    new Column(
                        'state',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "1",
                            'size' => 1,
                            'after' => 'description'
                        ]
                    ),
                    new Column(
                        'cover',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "",
                            'size' => 200,
                            'after' => 'state'
                        ]
                    ),
                    new Column(
                        'tag_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'cover'
                        ]
                    ),
                    new Column(
                        'catalog_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'size' => 11,
                            'after' => 'tag_id'
                        ]
                    ),
                    new Column(
                        'user_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'catalog_id'
                        ]
                    ),
                    new Column(
                        'viewed',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'user_id'
                        ]
                    ),
                    new Column(
                        'create_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'default' => "2000-01-01 00:00:00",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'viewed'
                        ]
                    ),
                    new Column(
                        'update_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'default' => "2000-01-01 00:00:00",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'create_at'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('tags', ['tag_id'], null),
                    new Index('menu_id', ['catalog_id'], null)
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '38',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8mb4_general_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
