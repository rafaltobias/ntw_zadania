<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2 class="text-center mb-3"><i class="fas fa-user"></i> Profile</h2>
            <div class="text-center mb-3">
                <i class="fas fa-user-circle fa-5x text-primary"></i>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Name:</strong>
                </div>
                <div class="col-md-6">
                    <?php echo $user->name; ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Username:</strong>
                </div>
                <div class="col-md-6">
                    <?php echo $user->username; ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Email:</strong>
                </div>
                <div class="col-md-6">
                    <?php echo $user->email; ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Role:</strong>
                </div>
                <div class="col-md-6">
                    <?php echo ucfirst($user->role); ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a href="<?php echo URL_ROOT; ?>/users/edit" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
