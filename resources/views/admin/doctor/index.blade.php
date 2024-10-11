@extends ('admin/index')
@section('title', 'User-List')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <i>
                    <h1 class="m-0">Doctor-list</h1>
                </i>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Add Doctor</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('doctor.create') }}" class="btn btn-primary float-left"><b>Add Doctor</b></a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="subadminlisting" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S.no</th>
                                <th>Doctor Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th>verify</th>
                                <th>abaility</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allDoctors as $doctor)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ ucwords($doctor->first_name .' '.$doctor->last_name ) }}
                                </td>
                                <td>
                                    {{ ($doctor->email) }}
                                </td>
                                <td>
                                    {{ ($doctor->gender) }}
                                </td>
                                <td>
                                    @if ($doctor->status == 'active')
                                    <div class="btn btn-success btn-sm driver_status" data-status="{{ $doctor->status }}" data-driver_id="{{ $doctor->id }}">{{ ucwords($doctor->status) }}</div> @else
                                    <div class="btn btn-danger btn-sm driver_status" data-status="{{ $doctor->status }}" data-driver_id="{{ $doctor->id }}">{{ ucwords($doctor->status) }}</div>
                                    @endif

                                </td>
                                <td>
                                    @if ($doctor->verifyStatus == '1')
                                    <div class="btn btn-success btn-sm driver_status" data-status="{{ $doctor->verifyStatus }}">Verify</div> @else
                                    <div class="btn btn-danger btn-sm driver_status" data-status="{{ $doctor->verifyStatus }}">Unverify</div>
                                    @endif

                                </td>
                                <td>
                                    @if ($doctor->abaility == 1)
                                    <div class="btn btn-success btn-sm driver_status" data-status="{{ $doctor->abaility }}">True</div> @else
                                    <div class="btn btn-danger btn-sm driver_status" data-status="{{ $doctor->abaility }}">False</div>
                                    @endif

                                </td>

                                <td>
                                    {{-- <a href="{{route('doctor.view',$doctor->id)}}" id="view_driver_btn" class="btn btn-success btn-sm">View</a> --}}
                                    <a href="{{route('doctor.update',$doctor->id)}}" id="edit_driver_btn" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="{{ route('doctor.delete', $doctor->id) }}" class="btn btn-danger btn-sm">Delete</a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    </div>
</section>
<!-- /. Main content -->

<script>
    $(document).ready(function() {
        var table = $('#subadminlisting').DataTable();
    });

</script>

@endsection
