@props(['id', 'placement' => 'bottom'])

<button id="{{ $id }}" {{ $attributes }}>{{ $inner }}</button>
@push('js-onload')
    // ********tippy start *****************
    let tippy_{{ $id }} = document.getElementById('{{ $id }}');
    tippy(tippy_{{ $id }}, {
    content: `{{ $content }}`,
    allowHTML: true,
    trigger: 'click',
    placement: '{{ $placement }}',
    arrow: true,
    theme: 'light',
    interactive: true,
    });
    // ********tippy end *****************
    
@endpush
