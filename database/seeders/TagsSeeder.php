<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $tags = [
                ['name' => 'Labrador'],
                ['name' => 'Husky'],
                ['name' => 'Siames'],
                ['name' => 'Angora'],
                ['name' => 'Doberman']
            ];
    
            DB::table('tags')->insert($tags);
        }
    }
}
