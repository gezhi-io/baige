@props(['id'])

<button id="{{ $id }}" {{ $attributes }}>
    {{ $text }}
</button>
@pushOnce('js')
    <script>
        window.onload=function(){
            tippy("{{ '#' . $id }}", {
            content: `{{ $content }}`,
            allowHTML: true,
            trigger: "click",
            placement: "right-end",
            arrow: true,
            theme:'light',
            interactive: true,
        });
        }
    </script>
@endPushOnce
