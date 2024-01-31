<div class="row align-items-center items-table my-2">
    <div class="col-sm-3"><strong>Image</strong></div>
    <div class="col-sm-{{ isset($not_editable) && $not_editable ? '3' : '2' }}"><strong>Option</strong></div>
    <div class="col-sm-3"><strong>Cost</strong></div>
    <div class="col-sm-3"><strong>Comment</strong></div>
    @unless (isset($not_editable) && $not_editable)
    <div class="col-sm-1"></div>
    @endunless

    @if (session()->has('items'))
    @php
    $items = App\Helpers\ManageItems::get_items($contractor, $floorplan);
    @endphp
    @forelse ($items as $key => $item)
    @php
    $product = $contractor->products()->where('product_id', $item['product_id'])->withPivot('is_not_display_price', 'is_enter_price', 'product_price')->first();
    @endphp
    <div class="col-sm-3 item-tiny-image">
        <img src="{{ $product->images[0]['pic_url'] }}" alt="{{ $product->images[0]['pic_name'] }}">
    </div>
    <div class="col-sm-{{ isset($not_editable) && $not_editable ? '3' : '2' }}" style="font-size:0.8em">{{ $product->pdt_name }}</div>
    <div class="col-sm-3">${{ $product->pivot->is_not_display_price || !$product->pivot->is_enter_price ? 0 : $product->pivot->product_price}}</div>
    <div class="col-sm-3">
        @if (isset($not_editable) && $not_editable)
        {{ $item['comment'] }}
        @else
        <input type="text" class="form-control form-control-solid customer-comment" value="{{ $item['comment'] }}" data-product-id="{{ $item['product_id'] }}" data-color="{{ $item['color'] }}">
        @endif
    </div>
    @unless (isset($not_editable) && $not_editable)
    <div class="col-sm-1">
        <a href="{{ route('contractor.items.destroy', ['subdomain' => $subdomain, 'item' => $key]) }}" class="btn btn-sm btn-clean btn-icon delete" data-id="{{ $key }}">
            <i class="icon-xl la la-trash-o text-danger"></i>
        </a>
    </div>
    @endunless
    @empty
    <div class="alert alert-warning w-100">No chosen items</div>
    @endforelse
    @else
    <div class="alert alert-warning w-100">No chosen items</div>
    @endif
</div>