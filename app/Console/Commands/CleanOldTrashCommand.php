<?php

namespace App\Console\Commands;

use App\Models\Note;
use App\Models\NoteBook;
use Illuminate\Console\Command;

class CleanOldTrashCommand extends Command
{
    protected $signature = 'trash:clean {--days=30}';
    protected $description = 'Permanently delete items in trash older than specified days';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $date = now()->subDays($days);

        $notebooksDeleted = NoteBook::onlyTrashed()
            ->where('deleted_at', '<', $date)
            ->forceDelete();

        $notesDeleted = Note::onlyTrashed()
            ->where('deleted_at', '<', $date)
            ->forceDelete();

        $this->info("Permanently deleted {$notebooksDeleted} notebooks and {$notesDeleted} notes older than {$days} days.");

        return Command::SUCCESS;
    }
}