<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .preview-container {
      margin-top: 10px;
    }
    .preview-image {
      max-width: 200px;
      max-height: 200px;
      display: none;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-primary text-white">
            Register Your Account
          </div>
          <div class="card-body">
            <form method="post" action="<?= base_url('auth/save'); ?>" enctype="multipart/form-data">
              <?= csrf_field(); ?>
                
              <!-- Profile Picture -->
              <div class="form-group">
                <label for="profile_pic">Profile Picture</label>
                <input type="file" class="form-control-file <?= isset($validation) && $validation->hasError('profile_pic') ? 'is-invalid' : '' ?>" id="profile_pic" name="profile_pic" accept="image/*" onchange="previewImage()">
                <div class="invalid-feedback">
                  <?= isset($validation) ? $validation->getError('profile_pic') : '' ?>
                </div>
              </div>
              <div class="preview-container">
                <img id="preview" class="preview-image" src="#" alt="Preview">
              </div>

              <!-- Full Name -->
              <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" class="form-control <?= isset($validation) && $validation->hasError('full_name') ? 'is-invalid' : '' ?>" id="full_name" name="full_name" value="<?= set_value('full_name'); ?>" placeholder="Enter your full name">
                <div class="invalid-feedback">
                  <?= isset($validation) ? $validation->getError('full_name') : '' ?>
                </div>
              </div>

              <!-- Username -->
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= set_value('username'); ?>" placeholder="Choose a username">
                <div class="invalid-feedback">
                  <?= isset($validation) ? $validation->getError('username') : '' ?>
                </div>
              </div>

              <!-- Email -->
              <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control <?= isset($validation) && $validation->hasError('email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= set_value('email'); ?>" placeholder="Enter your email">
                <div class="invalid-feedback">
                  <?= isset($validation) ? $validation->getError('email') : '' ?>
                </div>
              </div>

              <!-- Password -->
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control <?= isset($validation) && $validation->hasError('password') ? 'is-invalid' : '' ?>" id="password" name="password" placeholder="Password">
                <div class="invalid-feedback">
                  <?= isset($validation) ? $validation->getError('password') : '' ?>
                </div>
              </div>

              <!-- Confirm Password -->
              <div class="form-group">
                <label for="cpassword">Confirm Password</label>
                <input type="password" class="form-control <?= isset($validation) && $validation->hasError('cpassword') ? 'is-invalid' : '' ?>" id="cpassword" name="cpassword" placeholder="Confirm Password">
                <div class="invalid-feedback">
                  <?= isset($validation) ? $validation->getError('cpassword') : '' ?>
                </div>
              </div>

              <button type="submit" class="btn btn-primary">Register</button>
            </form> 
          </div>
          <div class="p-2">
            <p>Already have an account? <a href="<?= base_url('/') ?>">Sign in</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
  
  <script>
    function previewImage() {
      var preview = document.getElementById('preview');
      var file = document.getElementById('profile_pic').files[0];
      var reader = new FileReader();

      reader.onloadend = function() {
        preview.src = reader.result;
        preview.style.display = 'block';
      }

      if (file) {
        reader.readAsDataURL(file);
      } else {
        preview.src = "#";
        preview.style.display = 'none';
      }
    }
  </script>
</body>
</html>