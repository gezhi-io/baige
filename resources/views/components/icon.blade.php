@props(['path' => asset('images/tabler-sprite.svg'), 'icon', 'withStroke' => true])

@php
$path = $withStroke ? $path : asset('images/tabler-sprite-nostroke.svg');
@endphp
<svg width="24" height="24" {{ $attributes }} {{$withStroke}}>
    <use xlink:href="{{ $path . '#tabler-' . $icon }}" />
</svg>
