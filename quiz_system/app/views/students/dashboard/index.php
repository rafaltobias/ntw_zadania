<?php require APP_ROOT . '/views/inc/header.php'; ?>

<h1 class="mb-4">Student Dashboard</h1>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-center dashboard-card h-100">
            <div class="card-body">
                <i class="fas fa-clipboard-list dashboard-icon"></i>
                <h5 class="card-title">Available Tests</h5>
                <p class="card-text display-4"><?php echo $test_count; ?></p>
                <a href="<?php echo URL_ROOT; ?>/students/tests" class="btn btn-primary">View Tests</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-center dashboard-card h-100">
            <div class="card-body">
                <i class="fas fa-check-circle dashboard-icon"></i>
                <h5 class="card-title">Completed Tests</h5>
                <p class="card-text display-4"><?php echo $completed_count; ?></p>
                <a href="<?php echo URL_ROOT; ?>/students/completedTests" class="btn btn-primary">View Results</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card text-center dashboard-card h-100">
            <div class="card-body">
                <i class="fas fa-users dashboard-icon"></i>
                <h5 class="card-title">Your Classes</h5>
                <p class="card-text display-4"><?php echo $class_count; ?></p>
                <a href="<?php echo URL_ROOT; ?>/students/classes" class="btn btn-primary">View Classes</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Available Tests</h5>
                <a href="<?php echo URL_ROOT; ?>/students/tests" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if(!empty($tests)) : ?>
                    <div class="list-group">
                        <?php foreach(array_slice($tests, 0, 3) as $test) : ?>
                            <a href="<?php echo URL_ROOT; ?>/students/takeTest/<?php echo $test->id; ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><?php echo $test->title; ?></h6>
                                    <small><?php echo !empty($test->description) ? $test->description : 'No description'; ?></small>
                                </div>
                                <span class="badge bg-primary rounded-pill">Take Test</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <p class="text-center">No available tests.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Results</h5>
                <a href="<?php echo URL_ROOT; ?>/students/completedTests" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if(!empty($completed_tests)) : ?>
                    <div class="list-group">
                        <?php foreach(array_slice($completed_tests, 0, 3) as $test) : ?>
                            <a href="<?php echo URL_ROOT; ?>/students/viewResult/<?php echo $test->id; ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><?php echo $test->title; ?></h6>
                                    <small>Completed: <?php echo date('M j, Y', strtotime($test->completed_at)); ?></small>
                                </div>
                                <span class="badge bg-<?php echo ($test->score / $test->total_questions) * 100 >= 70 ? 'success' : 'warning'; ?> rounded-pill">
                                    <?php echo $test->score; ?>/<?php echo $test->total_questions; ?>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <p class="text-center">No completed tests yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
