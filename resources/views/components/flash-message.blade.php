<div x-data="{show: true}" x-init="setTimeout(() => show = false, 2000)">
    <div x-show="show" x-transition.duration.1000ms {!! $attributes->merge(['class' => 'absolute top-1 left-1 right-1 rounded-md p-8 bg-green-600 text-white shadow']) !!}>
        {{ $slot }}
    </div>
</div>