<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessagesTableSeeder extends Seeder
{
    private function randDate()
    {
        $nbJours = rand(-2800, 0);
        return Carbon::now()->addDays($nbJours);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 1; $i <= 100; $i++) {
            $date = $this->randDate();
            DB::table('messages')->insert([
                'content' => 'Message ' . $i,
                'user_id' => rand(1, 10),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
