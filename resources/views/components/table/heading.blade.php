@props([
    'sortable' => null,
    'direction' => null
 ])

<th {{ $attributes->merge(['class' => 'text-xs-left']) }}>
    @unless($sortable)
        <span>{{ $slot }}</span>
    @else
        <button type="button" class="btn btn-link livewire-table-direction-button">
            <span>{{ $slot }}</span>
            <span>
                @if($direction == 'asc')
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill align-bottom" viewBox="0 0 16 16">
                        <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                    </svg>
                @elseif($direction == 'desc')
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                        <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up align-bottom livewire-table-direction-button-both-icon" viewBox="0 0 16 16">
                        <path d="M3.204 11h9.592L8 5.519 3.204 11zm-.753-.659 4.796-5.48a1 1 0 0 1 1.506 0l4.796 5.48c.566.647.106 1.659-.753 1.659H3.204a1 1 0 0 1-.753-1.659z"/>
                    </svg>
                @endif

            </span>
        </button>

   @endif
</th>