<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="jumbotron p-5 mb-4 bg-light rounded-3">
    <div class="container">
        <h1 class="display-4">Welcome to Quiz System</h1>
        <p class="lead">A comprehensive system for managing single-choice quiz tests.</p>
        <?php if(!isset($_SESSION['user_id'])) : ?>
            <a href="<?php echo URL_ROOT; ?>/users/login" class="btn btn-primary btn-lg">Login to Continue</a>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-chalkboard-teacher fa-4x mb-3 text-primary"></i>
                <h5 class="card-title">For Teachers</h5>
                <p class="card-text">Create and manage questions, tests, students, and classes. Review test results and monitor student progress.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-user-graduate fa-4x mb-3 text-primary"></i>
                <h5 class="card-title">For Students</h5>
                <p class="card-text">Take tests assigned to you, review your results, and track your own progress.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-random fa-4x mb-3 text-primary"></i>
                <h5 class="card-title">Randomized Tests</h5>
                <p class="card-text">Tests present questions and answers in random order for a fresh experience every time.</p>
            </div>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
