<?php

namespace App\Providers;

use App\Models\Note;
use App\Models\NoteBook;
use App\Policies\NoteBookPolicy;
use App\Policies\NotePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(NoteBook::class, NoteBookPolicy::class);
        Gate::policy(Note::class, NotePolicy::class);
    }
}