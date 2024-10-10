@extends('admin/index')
@section('title', 'View User Profile')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">View User Profile</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">User Profile</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <style>
            .profile-container {
                max-width: 800px;
                margin: auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 10px;
            }

            .profile-group {
                margin-bottom: 15px;
            }

            .profile-group label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }

            .profile-group p {
                margin: 0;
            }

            .image-view-row {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-bottom: 15px;
            }

            .image-view-row .image-view-item {
                flex: 1 1 calc(33.333% - 10px);
                border: 1px solid #ccc;
                padding: 10px;
                text-align: center;
                border-radius: 5px;
            }

            .image-view-row .image-view-item img {
                width: 100%;
                height: auto;
                border-radius: 5px;
                margin-top: 10px;
            }
        </style>

        <div class="profile-container">
            <!-- Profile Information -->
            <div class="profile-group">
                <label for="first_name">First Name:</label>
                <p>{{ $user->first_name }}</p>
            </div>

            <div class="profile-group">
                <label for="last_name">Last Name:</label>
                <p>{{ $user->last_name }}</p>
            </div>

            <div class="profile-group">
                <label for="email">Email:</label>
                <p>{{ $user->email }}</p>
            </div>

            <div class="profile-group">
                <label for="phone">Phone Number:</label>
                <p>{{ $user->phone_number }}</p>
            </div>

            <div class="profile-group">
                <label for="age">Age:</label>
                <p>{{ $user->age }}</p>
            </div>

            <div class="profile-group">
                <label for="gender">Gender:</label>
                <p>{{ $user->gender }}</p>
            </div>

            <!-- Profile Pictures -->
            <div class="image-view-row">
                @foreach ($user->images as $index => $imagePath)
                    <div class="image-view-item">
                        <p>Profile Picture {{ $index + 1 }}</p>
                        <img style="width: 150px;" class="img_height_width" src="{{ asset($imagePath) }}" alt="Profile Picture {{ $index + 1 }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- /. Main content -->

@endsection
