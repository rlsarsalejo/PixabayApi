<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Smart Video Search</title>
    <style>
        .navbar-profile-pic {
            width: 30px;
            height: 30px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 10px;
        }
        .smart-search-btn {
            font-size: 24px;
            padding: 20px 40px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .smart-search-btn:hover {
            background-color: #0056b3;
            color:white;
            text-decoration:none;
        }
        .profile-pic {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #007bff;
        }
        .alert-custom {
            margin-top: 20px;
        }
        .container-custom {
            margin-top: 100px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Smart Search</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Align links to the right -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php if ($profile_pic): ?>
                            <img src="<?= base_url($profile_pic) ?>" alt="Profile" class="navbar-profile-pic">
                        <?php endif; ?>
                        <?= esc($username) ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= base_url('auth/update'); ?>">Update Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= base_url('auth/logout'); ?>">Sign Out</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-custom">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('info')): ?>
    <div class="alert alert-info alert-custom">
        <?= session()->getFlashdata('info') ?>
    </div>
<?php endif; ?>

<div class="container text-center container-custom">
    <div class="mt-3">
        <?php if ($profile_pic): ?>
            <img src="<?= base_url($profile_pic) ?>" alt="Profile Picture" class="profile-pic">
        <?php else: ?>
            <p>No Profile Found</p>
        <?php endif; ?>
    </div>
    <h3 class="mt-3">Welcome, <?= esc($username) ?>!</h3>
    <a href="<?= base_url('smart-search') ?>" type="button" class="smart-search-btn mt-4">Go to Smart Search</a>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4xF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
