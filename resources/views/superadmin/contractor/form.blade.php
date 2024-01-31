<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="row align-items-start">
            <div class="form-group col-lg-12 col-sm-12">
                <label for="company_name">Company name :</label>
                <input id="company_name" name="company_name" class="form-control form-control-solid @error('company_name') is-invalid @enderror" placeholder="Enter company name" value="{{ old('company_name', $contractor['company_name']) }}">
                @error('company_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row align-items-start">
            <div class="form-group col-lg-12 col-sm-12">
                <label for="sub_domain">Sub domain :</label>
                <input id="sub_domain" name="sub_domain" class="form-control form-control-solid @error('sub_domain') is-invalid @enderror" placeholder="Enter sub domain" value="{{ old('sub_domain', $contractor['sub_domain']) }}">
                @error('sub_domain')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row align-items-start">
            <div class="form-group col-lg-12 col-sm-12">
                <label for="company_website">Company website :</label>
                <input id="company_website" name="company_website" class="form-control form-control-solid @error('company_website') is-invalid @enderror" placeholder="Enter company website" value="{{ old('company_website', $contractor['company_website']) }}">
                @error('company_website')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row align-items-start">
            <div class="form-group col-lg-12 col-sm-12">
                <label for="address">Address :</label>
                <input id="address" name="address" class="form-control form-control-solid @error('address') is-invalid @enderror" placeholder="Enter address" value="{{ old('address', $contractor['address']) }}">
                @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row align-items-start">
            <div class="form-group col-lg-12 col-sm-12">
                <label for="state">State :</label>
                <select name="state" class="form-control form-control-solid custom-select @error('state') is-invalid @enderror">
                    <option value="" {{ old('state', $contractor['state']) == "" ? "checked" : "" }}></option>
                    @foreach ($states as $state)
                    <option value="{{ $state }}" {{ old('state', $contractor['state']) == $state ? "checked" : "" }}>{{ $state }}</option>
                    @endforeach
                </select>
                @error('state')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row align-items-start">
            <div class="form-group col-lg-12 col-sm-12">
                <label for="country">Country :</label>
                <input id="country" name="country" class="form-control form-control-solid @error('country') is-invalid @enderror" placeholder="Enter country" value="{{ old('country', $contractor['country']) }}">
                @error('country')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row align-items-start">
            <div class="form-group col-lg-12 col-sm-12">
                <label for="zip">Zip :</label>
                <input id="zip" name="zip" class="form-control form-control-solid @error('zip') is-invalid @enderror" placeholder="Enter zip" value="{{ old('zip', $contractor['zip']) }}">
                @error('zip')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row align-items-start">
            <div class="form-group col-{{ old('logo', $contractor['logo']) == '' ? 12 : 11 }}">
                <label for="logo">Logo :</label>
                <div class="custom-file logo-file">
                    <input type="hidden" name="logo" value="{{ old('logo', $contractor['logo']) }}">
                    <input type="file" class="custom-file-input @error('logo') is-invalid @enderror" id="logo" accept=".jpg, .jpeg, .png, .gif">
                    <label class="custom-file-label" for="logo">{{ old('logo', $contractor['logo']) == "" ? "Drag Picture Here" : "File attached" }}</label>
                    @error("logo")
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @if (old('logo', $contractor['logo']) != "")
                <div class="preview-image">
                    <img class="img-thumbnail" src="{{ old('logo', $contractor['logo']) }}" width="100" height="100">
                </div>
                @endif
            </div>
            @unless (old('logo', $contractor['logo']) == "")
            <div class="col-1">
                <button type="button" class="btn btn-sm btn-clean btn-icon image-delete"><i class="icon-xl la la-trash-o"></i></button>
            </div>
            @endunless
        </div>

        <div class="row align-items-start">
            <div class="form-group col-lg-12 col-sm-12">
                <label for="business_description">Business description :</label>
                <textarea id="business_description" name="business_description" class="form-control form-control-solid @error('business_description') is-invalid @enderror" placeholder="Enter business description" rows="10">{{ old('business_description', $contractor['business_description']) }}</textarea>
                @error('business_description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="row align-items-start">
            <div class="form-group col-lg-12 col-sm-12">
                <label for="first_name">Fist Name :</label>
                <input id="first_name" name="first_name" class="form-control form-control-solid @error('first_name') is-invalid @enderror" placeholder="Enter first name" value="{{ isset($contractor['owner']) ? $contractor['owner']['first_name'] : old('first_name') }}" {{ isset($contractor['owner']) ? "disabled" : "" }}>
                @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row align-items-start">
            <div class="form-group col-lg-12 col-sm-12">
                <label for="last_name">Last Name :</label>
                <input id="last_name" name="last_name" class="form-control form-control-solid @error('last_name') is-invalid @enderror" placeholder="Enter last name" value="{{ isset($contractor['owner']) ? $contractor['owner']['last_name'] : old('last_name') }}" {{ isset($contractor['owner']) ? "disabled" : "" }}>
                @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row align-items-start">
            <div class="form-group col-lg-12 col-sm-12">
                <label for="email">Email :</label>
                <input id="email" name="email" class="form-control form-control-solid @error('email') is-invalid @enderror" placeholder="Enter email" value="{{ isset($contractor['owner']) ? $contractor['owner']['email'] : old('email') }}" {{ isset($contractor['owner']) ? "disabled" : "" }}>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        @isset($contractor['owner'])
        @else
        <div class="row align-items-start">
            <div class="form-group col-lg-12 col-sm-12">
                <label for="password">Password :</label>
                <input type="password" id="password" name="password" class="form-control form-control-solid @error('password') is-invalid @enderror" placeholder="Enter password">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        @endisset

    </div>
</div>