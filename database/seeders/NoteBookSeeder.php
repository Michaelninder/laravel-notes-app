<?php

namespace Database\Seeders;

use App\Models\NoteBook;
use App\Models\User;
use Illuminate\Database\Seeder;

class NoteBookSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            return;
        }

        NoteBook::create([
            'user_id' => $user->id,
            'name' => 'Work Notes',
            'slug' => 'work-notes',
            'icon' => 'briefcase',
        ]);

        NoteBook::create([
            'user_id' => $user->id,
            'name' => 'Personal',
            'slug' => 'personal',
            'icon' => 'user',
        ]);

        NoteBook::create([
            'user_id' => $user->id,
            'name' => 'Ideas',
            'slug' => 'ideas',
            'icon' => 'lightbulb',
        ]);
    }
}