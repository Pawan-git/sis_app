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
            ->addColumn('user_type', 'string', ['limit' => 255])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addIndex(['user_email'], ['unique' => true])
            ->create();

        /* Create Table: contacts */
        $user_table = $this->table('emp_expense', ['engine' => 'InnoDB', 'id' => false, 'primary_key' => ['expense_id']]);
        $user_table->addColumn('expense_id', 'integer', ['limit' => 11, 'identity' => true])
            ->addColumn('expense_category', 'string', ['limit' => 255])
            ->addColumn('expense_description', 'string', ['limit' => 255])
            ->addColumn('pre_tax_amount', 'string', ['limit' => 255])
            ->addColumn('tax_amount', 'string', ['limit' => 255])
            ->addColumn('expense_date', 'date', ['null' => true])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('user_ref', 'integer', ['limit' => 11])
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
