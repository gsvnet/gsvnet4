<div x-data="{show: true}" x-init="setTimeout(() => show = false, 2000)">
    <div x-show="show" x-transition.duration.1000ms {!! $attributes->merge(['class' => 'z-[1000] absolute top-2 left-2 right-2 rounded-md p-8 bg-green-600/90 text-white shadow max-w-5xl mx-auto']) !!}>
        {{ $slot }}
    </div>
</div>