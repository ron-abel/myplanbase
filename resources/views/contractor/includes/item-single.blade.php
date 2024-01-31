<form method="POST" action="{{ route('contractor.items.store', ['subdomain' => $subdomain, 'floorplan' => $floorplan->id]) }}" id="product-form">
    @csrf
    <input type="hidden" name="product_id" value="{{ old('product_id') }}">
    <input type="hidden" name="comment" value="{{ old('comment') }}">
    <input type="hidden" name="color" value="{{ old('color') }}">
</form>