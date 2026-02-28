<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\NoteBook;
use App\Models\User;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $notebook = NoteBook::first();

        if (!$user || !$notebook) {
            return;
        }

        // Personal note attached to user
        Note::create([
            'notable_type' => User::class,
            'notable_id' => $user->id,
            'title' => 'My First Personal Note',
            'content' => 'This is a personal note attached directly to my user account.',
        ]);

        // Notes attached to notebook
        Note::create([
            'notable_type' => NoteBook::class,
            'notable_id' => $notebook->id,
            'title' => 'Meeting Notes',
            'content' => 'Discussed project timeline and deliverables.',
        ]);

        Note::create([
            'notable_type' => NoteBook::class,
            'notable_id' => $notebook->id,
            'title' => 'Todo List',
            'content' => "1. Complete feature X\n2. Review PR\n3. Update documentation",
        ]);
    }
}