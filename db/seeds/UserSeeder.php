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
                'user_name'    => 'Pawan1',
                'user_email'  => 'pawan@testmail.com',
                'user_password'  => sha1('121121'),
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'user_name'    => 'Pawan2',
                'user_email'  => 'pawansarwal@gmail.com',
                'user_password'  => sha1('121121'),
                'created_at'  => date('Y-m-d H:i:s'),
            ]
        ];

        $user = $this->table('user');
        $user->insert($rows)
            ->save();
    }
}
