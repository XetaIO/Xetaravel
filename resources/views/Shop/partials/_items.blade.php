@forelse ($items as $item)
    <div class="col-lg-4 mb-2">
        <div class="shop-item">
            <div class="shop-item-header">
                <a href="{{ $item->item_url }}">
                    {{ Str::limit($item->title, 150) }}
                </a>
            </div>
            <hr>
            <div class="shop-item-body">
                <img class="shop-item-body-icon mb-1" src="{{ $item->item_icon }}" alt="Item icon">
            </div>
            <hr>
            <div class="shop-item-footer text-xs-center">
                <div class="shop-item-footer-category">
                    <a href="{{ $item->shopCategory->category_url }}" class="d-inline">
                        <i class="fa fa-tag" aria-hidden="true"></i>
                        {{ $item->shopCategory->title }}
                    </a>
                </div>
                <hr>
                <div class="shop-item-footer-price">
                    {{ $item->price }} <i class="fa fa-diamond text-primary" aria-hidden="true"></i>
                </div>
                <div class="shop-item-footer-buy">
                    @auth
                        {{-- Check is there's unlimited quantity or still an available quantity --}}
                        @if($item->quantity == -1 || $item->quantity >= 1)
                            {{-- Check if the start-at or end-at is not null and there are still available quantity --}}
                            @if((!is_null($item->start_at) !== null || !is_null($item->end_at)) && $item->quantity !== 0)
                                @if(!is_null($item->start_at) && $item->start_at->timestamp >= time())
                                    <div>
                                        Start in
                                        <time datetime="{{ $item->start_at->format('Y-m-d H:i:s') }}" title="{{ $item->start_at->format('Y-m-d H:i:s') }}" data-toggle="tooltip">
                                            {{ $item->start_at->diffForHumans(now(), Carbon\CarbonInterface::DIFF_ABSOLUTE, false, 2) }}
                                        </time>
                                    </div>
                                @endif
                                @if(!is_null($item->end_at) && $item->end_at->timestamp >= time() && (is_null($item->start_at) || $item->start_at->timestamp <= time()))
                                    <div>
                                        End in
                                        <time datetime="{{ $item->end_at->format('Y-m-d H:i:s') }}" title="{{ $item->end_at->format('Y-m-d H:i:s') }}" data-toggle="tooltip">
                                            {{ $item->end_at->diffForHumans(now(), Carbon\CarbonInterface::DIFF_ABSOLUTE, false, 2) }}
                                        </time>
                                    </div>
                                @endif
                            @endif

                            {{-- If there's an available quantity, display the remaining quantity --}}
                            @if($item->quantity >= 1)
                                    <div class="mb-1">
                                <span class="tag tag-info">
                                    {{ $item->quantity }} Remaining
                                </span>
                                    </div>
                            @endif
                        {{-- Display the Buy button only if the start_at is null or
                        if the date of the start_at is smaller than the current time and the end_at is bigger than the current time :  start_at < now() > null|end_at
                        or if the date of end_at is bigger than the current time and the start_at is null or is smaller than the current time :  end_at > now() < null|start_at --}}
                            @if((is_null($item->start_at) && is_null($item->end_at)) ||
                                    (!is_null($item->start_at) && $item->start_at->timestamp <= time() && (is_null($item->end_at) || $item->end_at->timestamp >= time())) ||
                                    ((!is_null($item->end_at) && $item->end_at->timestamp >= time()) && (is_null($item->start_at) || $item->start_at->timestamp <= time()))
                                    )

                                {{-- We must create a form for the Buy button to avoid CSRF exploit --}}
                                {!! Form::open([
                                    'route' => 'shop.item.buy',
                                    'method' => 'post'
                                ]) !!}
                                    {!! Form::hidden('item_id', $item->getKey()) !!}
                                    {!! Form::button(
                                        '<i class="fas fa-shopping-basket"></i> Buy',
                                        ['type' => 'submit', 'class' => 'btn btn-primary']
                                    ) !!}
                                {!! Form::close() !!}
                            @endif
                        @else
                            <span class="tag tag-danger">Sold Out</span>
                        @endif
                    @else
                        <a class="btn btn-primary" href="{{ route('users.auth.login') }}">
                            <i class="fas fa-shopping-basket"></i> Buy
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-lg-12">
        <div class="alert alert-primary" role="alert">
            <i class="fa fa-exclamation" aria-hidden="true"></i>
            There's no items yet, come back later !
        </div>
    </div>
@endforelse

<div class="col-lg-12 text-xs-center">
    {{ $items->render() }}
</div>
