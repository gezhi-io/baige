@props(['id', 'placement' => 'bottom'])

<button id="{{ $id }}" {{ $attributes }}>{{ $inner }}</button>
@push('js')
    <script>
        $(document).ready(function() {
            tippy('#{{ $id }}', {
                content: `{{ $content }}`,
                allowHTML: true,
                trigger: 'click',
                placement: '{{ $placement }}',
                arrow: true,
                theme: 'light',
                interactive: true,
            });
        });
    </script>
@endpush
