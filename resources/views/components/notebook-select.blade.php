{{--
  Notebook Select Component
  Props:
    $notableType   – current notable_type value
    $notableId     – current notable_id value
    $notebooks     – collection of NoteBook models
    $userId        – auth user id (for personal notes)
--}}
@props([
    'notableType' => '',
    'notableId'   => null,
    'notebooks'   => collect(),
    'userId'      => null,
])

@php
    use App\Models\NoteBook;
    use App\Models\User;

    $effectiveType = old('notable_type', $notableType);
    $effectiveId   = (int) old('notable_id', $notableId);

    // Determine currently selected option
    $isPersonal     = $effectiveType === User::class || $effectiveType === '';
    $selectedNb     = !$isPersonal
        ? $notebooks->firstWhere('id', $effectiveId)
        : null;

    // Trigger display values
    $triggerIcon    = $isPersonal ? 'folder' : ($selectedNb?->icon ?: 'book-open');
    $triggerLabel   = $isPersonal ? 'Personal Notes' : ($selectedNb?->name ?? 'Personal Notes');
    $triggerSub     = $isPersonal ? 'Personal' : ($selectedNb ? $selectedNb->notes_count . ' notes' : '');
    $triggerPersonal = $isPersonal;
@endphp

<div class="nb-select-wrap" data-nb-select>

    {{-- Hidden inputs --}}
    <input type="hidden" name="notable_type"
           value="{{ $effectiveType ?: \App\Models\User::class }}">
    <input type="hidden" name="notable_id"
           value="{{ $effectiveId ?: $userId }}"
           data-user-id="{{ $userId }}">

    {{-- Trigger button --}}
    <button type="button" class="nb-select-trigger" aria-haspopup="listbox" aria-expanded="false">
        <div class="nb-select-icon {{ $triggerPersonal ? 'personal' : '' }}">
            <i data-lucide="{{ $triggerIcon }}" style="width:15px;height:15px;"></i>
        </div>
        <div style="flex:1;min-width:0;">
            <div class="nb-select-label">{{ $triggerLabel }}</div>
            <div class="nb-select-sublabel">{{ $triggerSub }}</div>
        </div>
        <i data-lucide="chevron-down" class="nb-select-chevron" style="width:16px;height:16px;"></i>
    </button>

    {{-- Dropdown --}}
    <div class="nb-select-dropdown" role="listbox">

        {{-- Personal Notes option --}}
        <div class="nb-select-option {{ $isPersonal ? 'selected' : '' }}"
             role="option"
             data-notable-type="{{ \App\Models\User::class }}"
             data-notable-id="{{ $userId }}"
             data-icon="folder"
             data-label="Personal Notes"
             data-personal="1"
             data-count="">
            <div class="nb-select-icon personal">
                <i data-lucide="folder" style="width:15px;height:15px;"></i>
            </div>
            <div style="flex:1;min-width:0;">
                <div class="nb-select-label">Personal Notes</div>
                <div class="nb-select-sublabel">Not in any notebook</div>
            </div>
            <i data-lucide="check" class="nb-select-option-check" style="width:15px;height:15px;"></i>
        </div>

        {{-- Notebook options --}}
        @foreach ($notebooks as $notebook)
            @php
                $isSelected = !$isPersonal && $effectiveId === $notebook->id;
                $nbIcon     = $notebook->icon ?: 'book-open';
                $nbCount    = $notebook->notes_count ?? $notebook->notes()->count();
            @endphp
            <div class="nb-select-option {{ $isSelected ? 'selected' : '' }}"
                 role="option"
                 data-notable-type="{{ \App\Models\NoteBook::class }}"
                 data-notable-id="{{ $notebook->id }}"
                 data-icon="{{ $nbIcon }}"
                 data-label="{{ $notebook->name }}"
                 data-personal="0"
                 data-count="{{ $nbCount }}">
                <div class="nb-select-icon">
                    <i data-lucide="{{ $nbIcon }}" style="width:15px;height:15px;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="nb-select-label">{{ $notebook->name }}</div>
                    <div class="nb-select-sublabel">{{ $nbCount }} {{ Str::plural('note', $nbCount) }}</div>
                </div>
                <i data-lucide="check" class="nb-select-option-check" style="width:15px;height:15px;"></i>
            </div>
        @endforeach
    </div>
</div>