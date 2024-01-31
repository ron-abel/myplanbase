    <div class="form-group">
        <label for="pdt_group_name">Product Group Name :</label>
        <input id="pdt_group_name" name="pdt_group_name" class="form-control form-control-solid @error('pdt_group_name') is-invalid @enderror" placeholder="Enter product group name" value="{{ old('pdt_group_name', $productgroup['pdt_group_name']) }}">
        @error('pdt_group_name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="pdt_group_description">Description :</label>
        <input id="pdt_group_description" name="pdt_group_description" class="form-control form-control-solid @error('pdt_group_description') is-invalid @enderror" placeholder="Enter product group description" value="{{ old('pdt_group_description', $productgroup['pdt_group_description']) }}">
        @error('pdt_group_description')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="pdt_group_additional_text">Additional Product Group Text :</label>
        <textarea id="pdt_group_additional_text" name="pdt_group_additional_text" class="form-control form-control-solid @error('pdt_group_additional_text') is-invalid @enderror" placeholder="Enter additional information" rows="10">{{ old('pdt_group_additional_text', $productgroup['pdt_group_additional_text']) }}</textarea>
        @error('pdt_group_additional_text')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    @for ($i = 0; $i < old('image_cnt', $image_cnt); $i++) <div class="row align-items-start image-row" tabindex="{{ $i + 1 }}">
        <div class="form-group col-md-6 col-sm-12">
            <label for="pic_name{{ $i + 1 }}">{{ $i == 0 ? "Key Pic Name" : "Pic" . ($i + 1) . "Name" }} :</label>
            <input id="pic_name{{ $i + 1 }}" name="images[{{ $i + 1 }}][pic_name]" class="form-control form-control-solid @error('images.' . ($i + 1) . '.pic_name') is-invalid @enderror" placeholder="{{ $i == 0 ? 'Enter key pic name' : 'Enter picture' . ($i + 1) . 'name' }}" value="{{  old('images.' . ($i + 1) . '.pic_name', isset($productgroup['images'][$i]['pic_name']) ? $productgroup['images'][$i]['pic_name'] : '') }}">
            @error('images.' . ($i + 1) . '.pic_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group col-md-5 col-11">
            <label for="">&nbsp;</label>
            <div class="custom-file">
                <input type="hidden" name="images[{{ $i + 1 }}][pic_url]" value="{{ old('images.' . ($i + 1) . '.pic_url', isset($productgroup['images'][$i]['pic_url']) ? $productgroup['images'][$i]['pic_url'] : '') }}">
                <input type="file" class="custom-file-input @error('images.' . ($i + 1) . '.pic_url') is-invalid @enderror" id="customFile">
                <label class="custom-file-label" for="customFile">{{ (old('images.' . ($i + 1) . '.pic_url', isset($productgroup['images'][$i]['pic_url']) ? $productgroup['images'][$i]['pic_url'] : '')) == "" ? "Drag Picture Here" : "File attached" }}</label>
                @error('images.' . ($i + 1) . '.pic_url')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if (old('images.' . ($i + 1) . '.pic_url', isset($productgroup['images'][$i]['pic_url']) ? $productgroup['images'][$i]['pic_url'] : '') != '')
            <div class="preview-image">
                <img class="img-thumbnail" src="{{ old('images.' . ($i + 1) . '.pic_url', isset($productgroup['images'][$i]['pic_url']) ? $productgroup['images'][$i]['pic_url'] : '') }}">
            </div>
            @endif
        </div>
        @unless ($i == 0)
        <div class="col-1">
            <button type="button" class="btn btn-sm btn-clean btn-icon image-delete"><i class="icon-xl la la-trash-o"></i></button>
        </div>
        @endunless
        </div>
        @endfor

        <div class="d-flex justify-content-end mb-5">
            <input type="hidden" name="image_cnt" value="{{ old('image_cnt', $image_cnt) }}">
            <button type="button" class="btn btn-info add-more-image">Add More Images</button>
        </div>