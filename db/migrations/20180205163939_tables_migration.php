<?php


use Phinx\Migration\AbstractMigration;

class TablesMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        /* Create Table: user */
        $user_table = $this->table('user', ['engine' => 'InnoDB', 'id' => false, 'primary_key' => ['user_id']]);
        $user_table->addColumn('user_id', 'integer', ['limit' => 11, 'identity' => true])
            ->addColumn('user_name', 'string', ['limit' => 50])
            ->addColumn('user_email', 'string', ['limit' => 255])
            ->addColumn('user_password', 'string', ['limit' => 255])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addIndex(['user_email'], ['unique' => true])
            ->create();

        /* Create Table: contacts */
        $user_table = $this->table('contacts', ['engine' => 'InnoDB', 'id' => false, 'primary_key' => ['contact_id']]);
        $user_table->addColumn('contact_id', 'integer', ['limit' => 11, 'identity' => true])
            ->addColumn('contact_name', 'string', ['limit' => 255])
            ->addColumn('contact_number', 'string', ['limit' => 15])
            ->addColumn('contact_note', 'string', ['limit' => 255])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->create();

    }

    /**
     * Migrate Up.
     */
    public function up()
    {

    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
