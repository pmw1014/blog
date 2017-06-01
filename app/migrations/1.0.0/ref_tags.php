<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class RefTagsMigration_100
 */
class RefTagsMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('ref_tags', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
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
                            'size' => 50,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'color',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'default' => "blue",
                            'size' => 10,
                            'after' => 'title'
                        ]
                    ),
                    new Column(
                        'state',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'size' => 1,
                            'after' => 'color'
                        ]
                    ),
                    new Column(
                        'create_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'default' => "2000-01-01 00:00:00",
                            'size' => 1,
                            'after' => 'state'
                        ]
                    ),
                    new Column(
                        'update_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'default' => "2000-01-01 00:00:00",
                            'size' => 1,
                            'after' => 'create_at'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY')
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '3',
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
