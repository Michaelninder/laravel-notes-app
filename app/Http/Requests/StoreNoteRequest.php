<?php

namespace App\Http\Requests;

use App\Models\NoteBook;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'notable_type' => 'required|string|in:' . User::class . ',' . NoteBook::class,
            'notable_id' => 'required|uuid',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string|max:65535',
        ];
    }
}