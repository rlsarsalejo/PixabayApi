<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - Smart Video Search</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .navbar-brand {
            font-weight: bold;
        }
        .active {
            font-weight: bold;
            color: #007bff !important;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,.1);
            margin-bottom: 20px; /* Added margin to separate cards */
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 15px 15px 0 0 !important;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-primary {
            border-radius: 5px;
            padding: 10px 30px;
        }
        .profile-pic-container {
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
            position: relative;
            overflow: hidden;
            border-radius: 50%;
            border: 3px solid #007bff;
        }
        .profile-pic {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-pic-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0,0,0,0.5);
            overflow: hidden;
            width: 100%;
            height: 0;
            transition: .5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .profile-pic-container:hover .profile-pic-overlay {
            height: 100%;
        }
        .profile-pic-text {
            color: white;
            font-size: 16px;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('dashboard'); ?>">Smart Search</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('smart-search'); ?>">Smart Search</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('auth/updateProfile'); ?>">Update Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('auth/logout'); ?>">Sign Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Update Profile</h4>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                        <?php endif; ?>

                                  <?php if (isset($validation)): ?>
                            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                        <?php endif; ?>

                        <form action="<?= base_url('auth/update') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="form-group text-center">
                                <div class="profile-pic-container">
                                    <img src="<?= $user['profile_pic'] ? base_url($user['profile_pic']) : base_url('assets/images/default-profile.png') ?>" alt="Profile Picture" class="profile-pic" id="profile-pic-preview">
                                    <div class="profile-pic-overlay">
                                        <div class="profile-pic-text">
                                            <label for="profile_pic" style="cursor: pointer;">
                                                <i class="fas fa-camera"></i> Change Photo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <input type="file" class="form-control-file d-none" id="profile_pic" name="profile_pic" accept="image/*">
                            </div>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username', $user['username']) ?>">
                            </div>

                            <div class="form-group">
                                <label for="full_name">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" value="<?= set_value('full_name', $user['full_name']) ?>">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email', $user['email']) ?>">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Password Update Card -->   
                <div class="card">
                 <?php if (session()->has('validation')): ?>
                            <div class="alert alert-danger">
                                <?= session('validation')->listErrors() ?>
                            </div>
                        <?php endif; ?>
                    <div class="card-header">
                        <h4 class="mb-0">Change Password</h4>
                    </div>
                    <div class="card-body">
                        <!-- Password change form goes here -->
                        <form action="<?= base_url('auth/update-password') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password">
                            </div>

                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End Password Update Card -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('profile_pic').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-pic-preview').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    </script>
</body>
</html>
