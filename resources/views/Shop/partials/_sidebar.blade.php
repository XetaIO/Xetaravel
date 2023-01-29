<div class="sidebar-module">
    <h2 class="sidebar-module-title font-xeta">
        Latest Xeticons
    </h2>
    <ol class="list-unstyled">
        @foreach ($items as $item)
            <li>
                <a href="{{ $item->shopCategory->category_url }}">
                    {{ $item->title }}
                </a>
            </li>
        @endforeach
    </ol>
</div>
<div class="sidebar-module">
    <h2 class="sidebar-module-title font-xeta">
        Categories
    </h2>
    <ol class="list-unstyled">
        @foreach ($categories as $category)
            <li>
                <a href="{{ $category->category_url }}">
                    {{ $category->title }}
                </a>
                ({{ $category->shop_item_count }})
            </li>
        @endforeach
    </ol>
</div>
