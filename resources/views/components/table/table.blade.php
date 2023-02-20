<div class="overflow-x-auto w-full">
    <table {{ $attributes->merge(['class' => 'table w-full']) }}>
        <thead>
            <tr>
                {{ $head }}
            </tr>
        </thead>
        <tbody>
            {{ $body }}
        </tbody>
    </table>
</div>