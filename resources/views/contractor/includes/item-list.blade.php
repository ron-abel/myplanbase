<div class="modal fade" id="color-list-modal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Paint Color Options</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form method="POST" action="{{ route('contractor.items.colors.store', ['subdomain' => $subdomain]) }}">
                    @csrf
                    @php
                    $items = App\Helpers\ManageItems::get_items($contractor, $floorplan);
                    @endphp
                    @foreach ($items as $key => $item)
                    @php
                    $product = App\Models\Product::find($item['product_id']);
                    @endphp
                    <div class="form-group">
                        <label for="item{{ $key }}">{{ $product->pdt_name }}</label>
                        <input type="text" id="item{{ $key }}" name="colors[{{ $key }}][color]" class="form-control form-control-solid @error('colors.' . $key . '.color') is-invalid @enderror" value="{{ old('colors.' . $key . '.color', $item['color']) }}">
                        @error('colors.' . $key . '.color')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary float-right" style="height: auto;">SAVE</button>
                </form>
            </div>
        </div>
    </div>
</div>