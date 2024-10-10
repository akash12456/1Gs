@extends ('admin/index')
@section('title', 'User-List')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <i><h1 class="m-0">User-list</h1></i>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Add User</li>
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
                            <a href="{{ route('user.create') }}" class="btn btn-primary float-left"><b>Add User</b></a>
                        </div> 
                    </div>
                        <div class="card-body">
                            <table id="subadminlisting" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>S.no</th> 
                                    <th>User Name</th>
                                    <th>Email</th> 
                                    <th>Gender</th> 
                                    <th>Status</th> 
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($allUsers as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td> 
                                    <td>{{ ucwords($user->first_name .' '.$user->last_name ) }}</td>
                                    <td>{{ ($user->email) }}</td> 
                                    <td>{{ ($user->gender) }}</td> 
                                    <td>
                                        @if ($user->status == 'active')
                                        <div class="btn btn-success btn-sm user_status" data-status="{{ $user->status }}" data-user_id="{{ $user->id }}">{{ ucwords($user->status) }}</div>
                                        @else
                                        <div class="btn btn-danger btn-sm user_status" data-status="{{ $user->status }}" data-user_id="{{ $user->id }}">{{ ucwords($user->status) }}</div>
                                        @endif
                                    </td>
                                     
                                    <td>
                                        <a href="{{route('user.update',$user->id)}}" id="edit_user_btn"  class="btn btn-warning btn-sm">Edit</a> 
                                        <a href="{{ route('user.delete', $user->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                    
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
