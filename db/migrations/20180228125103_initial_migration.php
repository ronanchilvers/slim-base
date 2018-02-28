<?php


use Phinx\Migration\AbstractMigration;

class InitialMigration extends AbstractMigration
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
        // Certificates table
        $certificates = $this->table(
            'certificates',
            [
                'id' => 'certificate_id'
            ]
        );
        $certificates->addColumn('certificate_name', 'string', [ 'length' => 1024 ])
                     ->addColumn('certificate_created', 'timestamp', [ 'default' => 'CURRENT_TIMESTAMP' ])
                     ->addColumn('certificate_updated', 'timestamp', [ 'update' => 'CURRENT_TIMESTAMP' ])
                     ->create();
    }
}
