@extends ('admin/index')
@section('title', 'Affiliate-Category-List')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <i><h1 class="m-0">All Affiliate</h1></i>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Affiliate-Category</li>
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
                        <button type="button" id="vertical_add_btn" class="btn btn-primary float-left" data-toggle="modal" data-target="#affiliate_modal">
                        <b>Add Affiliate </b>
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="subadminlisting" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Name</th> 
                                    <th>Image</th> 
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allUsers as $affiliate)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucwords($affiliate->affiliate_name) }}</td>
                                    <td>
                                        <img style="width: 54px;" src="{{$affiliate->image}}" alt="image">
                                    </td>

                                    <td>
                                        @if ($affiliate->status == 'active')
                                        <div class="btn btn-success btn-sm">{{ ucwords($affiliate->status) }}
                                        </div>
                                        @else
                                        <div class="btn btn-danger btn-sm">{{ ucwords($affiliate->status) }}
                                        </div>
                                        @endif
                                    </td>
                                    <td> 
                                        <a href="" id="edit_affiliate_btn" data-affiliate_link="{{ $affiliate->affiliate_links }}"  data-id="{{ $affiliate->id }}" data-affiliate_image="{{$affiliate->image}}" data-img_path="{{ asset('admin-assets/uploads/affiliate/') }}" data-affiliate_name="{{ $affiliate->affiliate_name }}"   data-status="{{ $affiliate->status }}" class="btn btn-warning btn-sm edit_post edit_affiliate_btn">Edit</a>
                                        <a href="{{ route('affiliate.delete', $affiliate->id) }}" class="btn btn-danger btn-sm">Delete</a>
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
<!-- Modal -->
<div class="modal fade" id="affiliate_modal" tabindex="-1" role="dialog" aria-labelledby="affiliate_modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title affiliate_modal_title" id="affiliate_modal_title">Add Affiliate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('affiliate.store') }}" method="post" enctype="multipart/form-data" id="affiliate_store">
                    @csrf
                    <div class="form-group">
                        <label for="affiliate_name">Affiliate Name</label>
                        <input type="text" class="form-control" id="affiliate_name" placeholder="Enter Affiliate name" name="affiliate_name">
                        @error('affiliate_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="affiliate_link">Affiliate Link</label>
                        <input type="text" class="form-control" id="affiliate_link" placeholder="Enter Affiliate Link" name="affiliate_link">
                        @error('affiliate_name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="affiliate_image">Image</label>
                        <input type="file" class="form-control-file" id="affiliate_image" accept="image/*" name="affiliate_image">
                        <img  id="imgPreview" class="img-preview" src="" alt="Image Preview" style="display:none;">
                        @error('affiliate_image')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="Inputusername">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        @error('status')
                        <div class="form-valid-error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="affiliate_submit_btn">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>
<script>
    document.getElementById('affiliate_image').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('imgPreview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });
</script>

<script>
    $(document).ready(function() {
        var table = $('#subadminlisting').DataTable();
    });
</script>

@endsection