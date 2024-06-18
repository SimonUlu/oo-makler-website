@php
    $userId = $estate["benutzer"] ?? null;
@endphp
@livewire('user-detail-show', ['lazy' => true, 'estateId' => $estateId, 'userId' => $userId])
