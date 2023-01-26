<div class="row">
    @forelse ($items as $item)
        <div class="col-lg-3">
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
                <div class="shop-item-footer">
                    <div class="shop-item-footer-category">
                        <a href="{{ $item->shopCategory->category_url }}">
                            <i class="fa fa-tag" aria-hidden="true"></i>
                            {{ $item->shopCategory->title }}
                        </a>
                    </div>
                    <div class="shop-item-footer-">

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
</div>

<div class="col-lg-12 text-xs-center">
    {{ $items->render() }}
</div>
