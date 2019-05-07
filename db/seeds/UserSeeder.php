<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        // inserting multiple rows
        $rows = [
            [
                'username'    => 'admin',
                'fullname'  => 'Admin',
                'password'  => sha1('sisadmin'),
                'user_type'  => 'ADMIN',
                'created_at'  => date('Y-m-d H:i:s'),
            ]
        ];

        $user = $this->table('user');
        $user->insert($rows)
            ->save();
    }
}
