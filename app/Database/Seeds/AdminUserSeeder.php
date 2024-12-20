<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'admin',
            'password' => password_hash( '12345678', PASSWORD_BCRYPT),
            'email'    => 'admin123@yopmail.com',
        ];

        // Using Query Builder
        $this->db->table('users')->insert($data);
    }
}
