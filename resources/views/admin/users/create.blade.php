@extends('admin/index')
@section('title', 'Create/Edit User')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- Content Header Title -->
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">User</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <style>
            .form-container {
                max-width: 800px;
                margin: auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 10px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .form-group label {
                display: block;
                margin-bottom: 5px;
            }

            .form-group input,
            .form-group select,
            .form-group textarea {
                width: 100%;
                padding: 6px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .image-upload-row {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .image-upload-row .image-upload-item {
                flex: 1 1 calc(50% - 10px);
                /* Adjusted for col-md-6 layout */
                border: 1px dashed #ccc;
                padding: 10px;
                text-align: center;
                border-radius: 5px;
            }

            .image-upload-row .image-upload-item img {
                width: 100%;
                height: auto;
                border-radius: 5px;
                margin-top: 10px;
            }

            .image-upload-row .image-upload-item input {
                display: none;
            }

            .image-upload-row .image-upload-item label {
                cursor: pointer;
                display: block;
                margin-bottom: 10px;
            }

            .img_height_width {
                height: 200px !important;
                width: 200px !important;
            }

            .select2-container--default .select2-search--inline .select2-search__field {
                display: none !important;
            }

            .input_box_section {
                background: #fff;
                box-shadow: 0 0 20px #b7b7b7;
                border-radius: 20px;
                padding: 20px;
                margin-bottom: 20px;
            }

        </style>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <form  id="userForm" action="{{ route('user.store', $user->id ?? '') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @if(isset($user))
                        @method('PUT')
                        @endif

                        <section class="input_box_section">
                            <div>
                                <div class="row">


                                    <div class="form-group col-md-4">
                                        <label for="InputFirstName">First Name</label>

                                        <input type="hidden" name="user_id" id="user_id" class="form-control" value="{{ $user->id ?? '' }}">
                                        <input type="text" name="first_name" id="InputFirstName" class="form-control" value="{{ $user->first_name ?? '' }}" placeholder="Enter First name">
                                        <div id="first_name_error" class="error mt-1" style="color:red;display: none;"> Please Enter First Name</div>
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="InputLastName">Last Name</label>
                                        <input type="text" name="last_name" id="InputLastName" class="form-control" value="{{ $user->first_name ?? '' }}" placeholder="Enter Last Name">
                                        <div id="last_name_error" class="error mt-1" style="color:red;display: none;"> Please Enter Last Name</div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="InputEmail">Email</label>
                                        <input type="email" name="email" id="InputEmail" class="form-control"
                                            value="{{ $user->email ?? '' }}" placeholder="Enter email">
                                        <div id="email_address_error" class="error mt-1"
                                            style="color:red;display: none;">
                                            Please Enter Email</div>
                                        <div id="email_address_length_error" class="error mt-1"
                                            style="color:red;display: none;">Please Enter Valid Email</div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="Inputusername">Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="">Select Status</option>
                                            <option value="active"
                                                {{ (isset($user) && $user->status == 'active') ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive"
                                                {{ (isset($user) && $user->status == 'inactive') ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                        <div id="status_error" class="error" style="color:red;display: none;">Select
                                            Status.</div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="InputPhone">Phone Number</label>
                                        <input type="tel" name="phone_number" id="InputPhone" class="form-control"
                                            value="{{ $user->phone_number ?? '' }}" placeholder="Enter phone number">
                                        <div id="phone_number_error" class="error" style="color:red;display: none;">
                                            Phone number is required.</div>
                                    </div>



                                    <div class="form-group col-md-4">
                                        <label for="InputGender">Gender</label>
                                        <select name="gender" id="InputGender" class="form-control" >>
                                            <option value="">Select gender</option>
                                            <option value="male"
                                                {{ (isset($user) && $user->gender == 'male') ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female"
                                                {{ (isset($user) && $user->gender == 'female') ? 'selected' : '' }}>
                                                Female
                                            </option>
                                            <option value="other"
                                                {{ (isset($user) && $user->gender == 'other') ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                        <div id="gender_error" class="error" style="color:red;display: none;">Please Select Gender.</div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="Inputdob">Date of birth</label>
                                        <input type="date" name="dob" id="dob" class="form-control"
                                        value="{{ $user->dob ?? '' }}" >
                                        <div id="dob_error" class="error" style="color:red;display: none;">
                                            dob number is required.</div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="Inputaddress">Address</label>
                                        <textarea  name="address" id="address" class="form-control"
                                            value="" >{{$user->address}}</textarea>
                                        <div id="address_error" class="error" style="color:red;display: none;">
                                            Address  is required.</div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="profilePhoto">Profile photo</label>
                                        <input type="file" name="profilephoto" id="profilephoto" class="form-control"
                                             placeholder="Enter phone number" onchange="imagePreview(this)">
                                            <input type="hidden" name="oldprofilephoto"  value="{{$user->profilephoto??""  }}">
                                            {{-- @if (isset($driver)) --}}
                                            <img id="profilephotoPreview" src="{{ asset('user_images/').'/'.(isset($user)?$user->profilephoto:'') }}" height="100px" width="100px" alt="">
                                            {{-- @endif --}}
                                        <div id="profilephoto_error" class="error" style="color:red;display: none;">
                                            Phone number is required.</div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="Inputnationality">Nationality</label>
                                        <input type="text" name="nationality" id="nationality" class="form-control"
                                            value="{{$user->nationality}}" >
                                        <div id="nationality_error" class="error" style="color:red;display: none;">
                                            Nationality  is required.</div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="Inputpassword">Password</label>
                                        <input type="text" name="password" id="password" class="form-control"
                                            value="" >
                                        <div id="password_error" class="error" style="color:red;display: none;">
                                            Password is required.</div>
                                    </div>
                                </div>
                            </div>
                        </section>

                </div>
            </div>

            <div class="card-footer">
                <input class="btn btn-primary" id="submit" type="submit"value="{{ isset($user) ? 'Update' : 'Submit' }}">
            </div>

            </form>
        </div>
    </div>
</section>

<div class="col-md-6">
    <!-- Additional content can go here -->
</div>
</div>
</div>


<script>
function previewImage(event, previewId) {
    console.log("Preview Image function called");
    const reader = new FileReader();
    reader.onload = function() {
        console.log("File read successfully");
        const output = document.getElementById(previewId);
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}
function imagePreview(image) {
    const file = image.files[0];
    if (file) {
        // Allowed file extensions
        const allowedExtensions = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];

        // Check the file type (MIME type)
        if (!allowedExtensions.includes(file.type)) {
            alert("Invalid file type. Only jpeg, png, jpg, gif, or webp files are allowed.");
            // Clear the input and reset the preview
            $("#" + $(image).attr('id')).val("");
            $("#" + $(image).attr('id') + "Preview").attr("src", "{{ asset('/admin-assets/assets/img/productimg.jpg') }}");
            return;
        }

        let reader = new FileReader();
        reader.onload = function(event) {
            const img = new Image();
            img.onload = function() {
                // Display the image since the type is valid
                $("#" + $(image).attr('id') + "Preview").attr("src", event.target.result);
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
}
</script>


</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">
    document.getElementById('userForm').addEventListener('submit', function(event) {
        document.getElementById('first_name_error').style.display = 'none';
        document.getElementById('last_name_error').style.display = 'none';
        document.getElementById('email_address_error').style.display = 'none';
        document.getElementById('phone_number_error').style.display = 'none';
        document.getElementById('status_error').style.display = 'none';
        document.getElementById('gender_error').style.display = 'none';

        const first_name  = document.getElementById('InputFirstName').value.trim();
        const last_name   = document.getElementById('InputFirstName').value.trim();
        const email       = document.getElementById('InputEmail').value.trim();
        const phoneNumber = document.getElementById('InputPhone').value.trim();
        const status      = document.getElementById('status').value;
        const gender      = document.getElementById('InputGender').value;

        let valid = true;

        if (!first_name) {
            document.getElementById('first_name_error').style.display = 'block';
            valid = false;
        }

        if (!last_name) {
            document.getElementById('last_name_error').style.display = 'block';
            valid = false;
        }


        if (!email) {
            document.getElementById('email_address_error').style.display = 'block';
            valid = false;
        } else if (!validateEmail(email)) {
            document.getElementById('email_address_length_error').style.display = 'block';
            valid = false;
        }


        if (!phoneNumber) {
            document.getElementById('phone_number_error').style.display = 'block';
            valid = false;
        }

        if (!status) {
            document.getElementById('status_error').style.display = 'block';
            valid = false;
        }

        if (!gender) {
            document.getElementById('gender_error').style.display = 'block';
            valid = false;
        }

        // Prevent form submission if validation fails
        if (!valid) {
            event.preventDefault();
        }
    });

    // Simple email validation function
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }
</script>

@endsection
