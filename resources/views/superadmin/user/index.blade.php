@extends("superadmin.layouts.default")

@section("content")
<div class="main-content container">
    <!--begin::Card-->
    <div class=" card card-custom mt-6">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Users</h3>
            </div>
            <div class="card-toolbar">
                
                <!--begin::Button-->
                <a href="{{ route('super.users.create') }}" class="btn btn-primary font-weight-bolder">
                    <i class="icon-xl la la-plus"></i>
                    Add Admin User
                </a>
                <!--end::Button-->
            </div>
        </div>

        <div class="card-body">
            @if (session()->has('success'))
            <div class="alert alert-primary" role="alert"> {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @elseif(session()->has('error'))
            <div class="alert alert-danger" role="alert"> {{ session()->get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <div class="overlay loading d-none"></div>
            <div class="spinner-border text-primary loading d-none" role="status">
                <span class="sr-only">Loading...</span>
            </div>

            <!--begin::Search Form-->
            <div class="mb-7">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="input-icon">
                                    <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                                    <span>
                                        <i class="flaticon2-search-1 text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Search Form-->
            <!--end: Search Form-->
            <!--begin: Datatable-->
            <table class="datatable datatable-bordered table-responsive datatable-head-custom" id="kt_datatable">
                <thead>
                    <tr>
                        <th title="Field #1">First Name</th>
                        <th title="Field #2">Last Name</th>
                        <th title="Field #3">Email</th>
                        <th title="Field #4">Role</th>
                        <th title="Field #5">Actions</th>
                    </tr>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->user_role_name }}</td>
                        <td class="d-flex justify-content-end">
                            <a href="{{ route('super.users.edit', ['user' => $user->id]) }}" class="btn btn-sm btn-clean btn-icon"><i class="icon-xl la la-pen"></i></a>
                            <a href="{{ route('super.users.destroy', ['user' => $user->id]) }}" class="btn btn-sm btn-clean btn-icon delete"><i class="icon-xl la la-trash-o"></i></a>
                        </td>
                    </tr>
                    @empty
                    <!-- <div class="alert alert-warning">No users added yet</div> -->
                    @endforelse
                </tbody>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
    <!--end::Card-->
</div>
@endsection