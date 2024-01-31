<div class="form-group">
    <label for="pdt_group_id">PRODUCT GROUP :</label>
    <select name="pdt_group_id" id="pdt_group_id" class="form-control form-control-solid custom-select @error('pdt_group_id') is-invalid @enderror">
        <option value="" {{ old("pdt_group_id", $product["pdt_group_id"]) == "" ? "selected" : "" }}></option>
        @foreach ($productgroups as $productgroup)
        <option value="{{ $productgroup->id }}" {{ old("pdt_group_id", $product["pdt_group_id"]) == $productgroup->id ? "selected" : "" }}>{{ $productgroup->pdt_group_name }}</option>
        @endforeach
    </select>
    @error('pdt_group_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="pdt_name">PRODUCT NAME :</label>
    <input id="pdt_name" name="pdt_name" class="form-control form-control-solid @error('pdt_name') is-invalid @enderror" placeholder="Enter product name" value="{{ old('pdt_name', $product['pdt_name']) }}">
    @error('pdt_name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="pdt_description">PRODUCT DESCRIPTION :</label>
    <input id="pdt_description" name="pdt_description" class="form-control form-control-solid @error('pdt_description') is-invalid @enderror" placeholder="Enter product description" value="{{ old('pdt_description', $product['pdt_description']) }}">
    @error('pdt_description')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="pdt_additional_text">ADDITIONAL PRODUCT TEXT :</label>
    <textarea id="pdt_additional_text" name="pdt_additional_text" class="form-control form-control-solid @error('pdt_additional_text') is-invalid @enderror" placeholder="Enter additional information" rows="10">{{ old('pdt_additional_text', $product['pdt_additional_text']) }}</textarea>
    @error('pdt_additional_text')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@for ($i = 0; $i < old('image_cnt', $image_cnt); $i++) <div class="row align-items-start image-row" tabindex="{{ $i + 1 }}">
    <div class="form-group col-md-6 col-sm-12">
        <label for="pic_name{{ $i + 1 }}">{{ $i == 0 ? "Key Pic Name" : "Pic" . ($i + 1) . "Name" }} :</label>
        <input id="pic_name{{ $i + 1 }}" name="images[{{ $i + 1 }}][pic_name]" class="form-control form-control-solid @error('images.' . ($i + 1) . '.pic_name') is-invalid @enderror" placeholder="{{ $i == 0 ? 'Enter key pic name' : 'Enter picture' . ($i + 1) . 'name' }}" value="{{  old('images.' . ($i + 1) . '.pic_name', isset($product['images'][$i]['pic_name']) ? $product['images'][$i]['pic_name'] : '') }}">
        @error('images.' . ($i + 1) . '.pic_name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-5 col-11">
        <label for="">&nbsp;</label>
        <div class="custom-file">
            <input type="hidden" name="images[{{ $i + 1 }}][pic_url]" value="{{ old('images.' . ($i + 1) . '.pic_url', isset($product['images'][$i]['pic_url']) ? $product['images'][$i]['pic_url'] : '') }}">
            <input type="file" class="custom-file-input @error('images.' . ($i + 1) . '.pic_url') is-invalid @enderror" id="customFile">
            <label class="custom-file-label" for="customFile">{{ (old('images.' . ($i + 1) . '.pic_url', isset($product['images'][$i]['pic_url']) ? $product['images'][$i]['pic_url'] : '')) == "" ? "Drag Picture Here" : "File attached" }}</label>
            @error('images.' . ($i + 1) . '.pic_url')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @if (old('images.' . ($i + 1) . '.pic_url', isset($product['images'][$i]['pic_url']) ? $product['images'][$i]['pic_url'] : '') != '')
        <div class="preview-image">
            <img class="img-thumbnail" src="{{ old('images.' . ($i + 1) . '.pic_url', isset($product['images'][$i]['pic_url']) ? $product['images'][$i]['pic_url'] : '') }}">
        </div>
        @endif
    </div>
    @unless ($i == 0)
    <div class="form-group col-1">
        <button type="button" class="btn btn-sm btn-clean btn-icon image-delete"><i class="icon-xl la la-trash-o"></i></button>
    </div>
    @endunless
    </div>
    @endfor

    <div class="d-flex justify-content-end mb-5">
        <input type="hidden" name="image_cnt" value="{{ old('image_cnt', $image_cnt) }}">
        <button type="button" class="btn btn-info add-more-image">ADD MORE IMAGES</button>
    </div>

    <!-- <div class="row align-items-start">
    <div class="col-lg-2 col-md-3">
        <label for="keyvideoname">KEY VIDEO NAME :</label>
    </div>
    <div class="form-group col-lg-6 col-lg-5">
        <input id="keyvideoname" name="keyvideoname" class="form-control @error('keyvideoname') is-invalid @enderror" placeholder="Enter key video name" value="{{ old('keyvideoname', $product['keyvideoname']) }}">
        @error('keyvideoname')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-lg-4 col-lg-4">
        <div class="custom-file">
            <input type="hidden" name="keyvideolink" value="{{ old('keyvideolink', $product['keyvideolink']) }}">
            <input type="file" class="custom-file-input @error('keyvideolink') is-invalid @enderror" id="customFile">
            <label class="custom-file-label" for="customFile">{{ old('keyvideolink', $product['keyvideolink']) == "" ? "DRAG PICTURE HERE" : "File attached" }}</label>
            @error('keyvideolink')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row align-items-start">
    <div class="col-lg-2 col-md-3">
        <label for="video2name">VIDEO 2 NAME :</label>
    </div>
    <div class="form-group col-lg-6 col-lg-5">
        <input id="video2name" name="video2name" class="form-control @error('video2name') is-invalid @enderror" placeholder="Enter video 2 name" value="{{ old('video2name', $product['video2name']) }}">
        @error('video2name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-lg-4 col-lg-4">
        <div class="custom-file">
            <input type="hidden" name="video2link" value="{{ old('video2link', $product['video2link']) }}">
            <input type="file" class="custom-file-input @error('video2link') is-invalid @enderror" id="customFile">
            <label class="custom-file-label" for="customFile">{{ old('video2link', $product['video2link']) == "" ? "DRAG PICTURE HERE" : "File attached" }}</label>
            @error('video2link')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div> -->

    <!-- <div class="d-flex justify-content-end mb-5">
    <button type="button" class="btn btn-info">ADD MORE VIDEOS</button>
</div> -->