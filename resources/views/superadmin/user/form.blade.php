<div class="row align-items-start">
    <div class="form-group col-lg-12 col-sm-12">
        <label for="first_name">Fist Name :</label>
        <input id="first_name" name="first_name" class="form-control form-control-solid @error('first_name') is-invalid @enderror" placeholder="Enter first name" value="{{ old('first_name', $user['first_name']) }}">
        @error('first_name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row align-items-start">
    <div class="form-group col-lg-12 col-sm-12">
        <label for="last_name">Last Name :</label>
        <input id="last_name" name="last_name" class="form-control form-control-solid @error('last_name') is-invalid @enderror" placeholder="Enter last name" value="{{ old('last_name', $user['last_name']) }}">
        @error('last_name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row align-items-start">
    <div class="form-group col-lg-12 col-sm-12">
        <label for="email">Email :</label>
        <input id="email" name="email" class="form-control form-control-solid @error('email') is-invalid @enderror" placeholder="Enter email" value="{{ old('email', $user['email']) }}">
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row align-items-start">
    <div class="form-group col-lg-12 col-sm-12">
        <label for="password">Password :</label>
        <input type="password" id="password" name="password" class="form-control form-control-solid @error('password') is-invalid @enderror" placeholder="Enter password" value="{{ old('password') }}">
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>