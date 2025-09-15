@php
    $record = $getRecord();
    $backgroundColor = $record->color?->hex_code ?? '#fffdbf';
@endphp

<div class="px-4 py-2 text-center text-white align-middle rounded" style="background-color: {{ $backgroundColor }};">
    Hello
</div>
