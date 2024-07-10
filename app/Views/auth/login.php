<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Login</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
  <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
  <?php endif; ?>
  <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
  <?php endif; ?>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-primary text-white">
            User Login
          </div>
          <div class="card-body">
            <form method="post" action="<?= base_url('authenticate'); ?>">
              <?= csrf_field(); ?>
              
              <!-- Username (or Email) -->
              <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" class="form-control <?= isset($validation) && $validation->hasError('username') ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= set_value('username'); ?>" placeholder="Enter your username or email">
                <div class="invalid-feedback">
                <?= isset($validation) ? $validation->getError('username') : '' ?>
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
              
              <button type="submit" class="btn btn-primary">Login</button>
            </form>
          </div>
          <div class="p-2">
          <p>No Account? <a href="<?= base_url('auth/register'); ?>">Create Account</a> </p>
          </div>
        
        </div>
      </div>
    </div>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
