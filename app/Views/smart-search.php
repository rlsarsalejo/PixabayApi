<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Search</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .search-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }
        .search-title {
            color: #343a40;
            margin-bottom: 30px;
        }
        .search-form .form-control {
            border-radius: 20px;
        }
        .search-btn {
            border-radius: 20px;
            padding: 10px 30px;
        }
        .results-container {
            margin-top: 50px;
        }
        .result-item {
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }
        .result-item:hover {
            transform: scale(1.05);
        }
        .result-item img, .result-item video {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .active{
            border-bottom: 2px solid black;
        }
        .navbar-profile-pic {
            width: 30px;
            height: 30px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 10px;
        }
        .profile-pic {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #007bff;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('dashboard') ?>">Smart Search</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Align links to the right -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if (isset($profile_pic)): ?>
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
<?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger mt-3"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
    <div class="container">
        <div class="search-container">
            <h1 class="search-title text-center"><i class="fas fa-search mr-3"></i>Smart Search</h1>
            <form action="<?= base_url('smartsearch/search') ?>" method="get" class="search-form">
                <div class="form-row">
                    <div class="col-md-8 mb-3">
                        <input type="text" class="form-control" id="query" name="query" placeholder="Enter your search query" value="<?= isset($query) ? $query : '' ?>" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <select class="form-control" id="type" name="type">
                            <option value="image" <?= isset($type) && $type == 'image' ? 'selected' : '' ?>>Image</option>
                            <option value="video" <?= isset($type) && $type == 'video' ? 'selected' : '' ?>>Video</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary btn-block search-btn">Search</button>
                    </div>
                </div>
            </form>
        </div>

        <?php if (isset($results)): ?>
            <div class="results-container">
                <h2 class="mb-4">Search Results for "<?= $query ?>"</h2>
                <div class="row">
                    <?php foreach ($results as $result): ?>
                        <div class="col-md-4 result-item">
                            <?php if ($type === 'image' && isset($result['webformatURL'])): ?>
                                <img src="<?= $result['webformatURL'] ?>" alt="<?= $result['tags'] ?>" class="img-fluid">
                            <?php elseif ($type === 'video' && isset($result['videos']['medium']['url'])): ?>
                                <video controls class="img-fluid">
                                    <source src="<?= $result['videos']['medium']['url'] ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>