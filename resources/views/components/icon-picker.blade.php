{{--
  Icon Picker Component
  Props:
    $name        – form field name (default: 'icon')
    $selected    – currently selected icon slug (default: '')
    $label       – label text (default: 'Icon')
--}}
@props([
    'name'     => 'icon',
    'selected' => '',
    'label'    => 'Icon',
])

@php
$icons = [
    // Writing & documents
    'file-text','file-pen','file-plus-2','file-check','notebook-pen','notebook','book-open',
    'book-marked','book-copy','book-heart','book-lock','book-x','library','scroll-text',
    'clipboard','clipboard-list','clipboard-check','clipboard-pen',

    // Organisation & structure
    'folder','folder-open','folder-heart','folder-lock','folder-plus','folder-check',
    'layers','layout-dashboard','layout-grid','list','list-checks','list-ordered',
    'kanban','table-2','columns-2','inbox','archive',

    // Tags & labels
    'tag','tags','bookmark','bookmark-check','star','star-half','flag','badge',
    'award','trophy','crown','medal',

    // Time & calendar
    'calendar','calendar-check','calendar-clock','calendar-days','calendar-heart',
    'clock','timer','hourglass','alarm-clock',

    // People & social
    'user','user-round','users','user-check','user-heart','user-cog',
    'contact','person-standing','baby','graduation-cap',

    // Communication
    'message-circle','message-square','mail','mail-open','send','phone',
    'bell','bell-ring','megaphone','rss',

    // Tech & code
    'code','code-2','terminal','braces','cpu','server','database','cloud',
    'wifi','bluetooth','monitor','smartphone','tablet','laptop','keyboard',
    'globe','link','link-2','qr-code',

    // Ideas & creativity
    'lightbulb','pen-tool','pencil','brush','palette','wand-2','sparkles',
    'zap','flame','rocket','telescope','microscope','atom',

    // Finance & work
    'briefcase','building-2','factory','store','shopping-cart','credit-card',
    'wallet','banknote','trending-up','trending-down','bar-chart-2','pie-chart',
    'calculator','receipt','coins',

    // Nature & places
    'tree','trees','flower','sun','moon','cloud-sun','mountain','waves','droplets',
    'snowflake','leaf','sprout','globe-2','map','map-pin','compass','navigation',

    // Health & fitness
    'heart','heart-pulse','activity','stethoscope','pill','apple','dumbbell',
    'bike','footprints','brain','eye',

    // Food & drink
    'coffee','cup-soda','wine','beer','pizza','sandwich','salad','beef','cake',

    // Home & lifestyle
    'home','sofa','bed','bath','key','lock','door-open','lamp','music','tv',
    'film','camera','image','mic','headphones','gamepad-2','dice-5',

    // Misc
    'settings','settings-2','sliders','wrench','hammer','scissors','paperclip',
    'pin','thumbs-up','thumbs-down','share-2','download','upload','refresh-cw',
    'search','filter','sort-asc','sort-desc','more-horizontal','grid-2x2',
    'minus','plus','x','check','circle-check','circle-x','alert-triangle',
    'help-circle','info','bug','shield','shield-check',
];
$total = count($icons);
@endphp

<div class="icon-picker-wrap" data-icon-picker>
    <label>
        <i data-lucide="shapes" style="width:13px;height:13px;vertical-align:middle;"></i>
        {{ $label }}
    </label>

    {{-- Hidden input that stores the value --}}
    <input type="hidden" name="{{ $name }}" value="{{ old($name, $selected) }}">

    {{-- Search --}}
    <div class="icon-picker-search-row">
        <input type="text"
               class="icon-picker-search"
               placeholder="Search icons…"
               autocomplete="off"
               style="font-size:.85rem;padding:.5rem .8rem;">
    </div>

    {{-- Selected preview --}}
    <div class="icon-picker-selected" style="{{ old($name, $selected) ? '' : 'display:none;' }}">
        <div class="icon-picker-selected-preview">
            <i data-lucide="{{ old($name, $selected) ?: 'star' }}" style="width:14px;height:14px;"></i>
        </div>
        <span class="icon-picker-selected-name">{{ old($name, $selected) ?: '' }}</span>
        <button type="button" class="icon-picker-clear" title="Clear icon">
            <i data-lucide="x" style="width:14px;height:14px;"></i>
        </button>
    </div>

    {{-- Grid --}}
    <div class="icon-picker-grid-wrap">
        <div class="icon-picker-grid">
            @foreach ($icons as $icon)
                <button type="button"
                        class="icon-btn {{ old($name, $selected) === $icon ? 'selected' : '' }}"
                        data-icon="{{ $icon }}"
                        title="{{ $icon }}">
                    <i data-lucide="{{ $icon }}" style="width:16px;height:16px;"></i>
                </button>
            @endforeach
        </div>
        <div class="icon-picker-footer">
            <span><i data-lucide="info" style="width:11px;height:11px;vertical-align:middle;"></i> Click an icon to select</span>
            <span class="ip-count">{{ $total }} icons</span>
        </div>
    </div>
</div>