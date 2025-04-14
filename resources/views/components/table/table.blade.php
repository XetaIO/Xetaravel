@props([
    'containerClass' => ''
])
<div class="overflow-x-auto w-full {{ $containerClass }}">
    <table {{ $attributes->merge(['class' => 'table w-full']) }}>
        <thead>
            <tr>
                {{ $head }}
            </tr>
        </thead>
        <tbody x-auto-animate.linear>
            {{ $body }}
        </tbody>
    </table>
</div>
