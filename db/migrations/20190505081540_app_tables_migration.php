<?php


use Phinx\Migration\AbstractMigration;

class AppTablesMigration extends AbstractMigration
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
            ->addColumn('username', 'string', ['limit' => 255])
            ->addColumn('fullname', 'string', ['limit' => 255])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('address', 'text', ['limit' => 255])
            ->addColumn('user_type', 'enum',['values' =>['ADMIN', 'EMP']])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addIndex(['username'], ['unique' => true])
            ->create();

         /* Create Table: emp_expense */
        $emp_expense = $this->table('emp_expense', ['engine' => 'InnoDB', 'id' => false, 'primary_key' => ['expense_id']]);
        $emp_expense->addColumn('expense_id', 'integer', ['limit' => 11, 'identity' => true])
                ->addColumn('expense_category', 'string', ['limit' => 255])
                ->addColumn('expense_description', 'text', ['limit' => 255])
                ->addColumn('pre_tax_amount', 'decimal', ['precision' => 10, 'scale'=>2])
                ->addColumn('tax_amount', 'decimal', ['precision' => 10, 'scale'=>2])
                ->addColumn('expense_date', 'date', ['null' => true])
                ->addColumn('created_at', 'datetime', ['null' => true])
                ->addColumn('user_ref', 'integer', ['limit' => 11])
                ->create();
				
		$refTable = $this->table('emp_expense');
        $refTable->addForeignKey('user_ref', 'user', 'user_id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])
                 ->save();
			
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
