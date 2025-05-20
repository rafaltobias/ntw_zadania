<?php require APP_ROOT . '/views/inc/header.php'; ?>

<h1 class="mb-4">Teacher Dashboard</h1>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-center dashboard-card h-100">
            <div class="card-body">
                <i class="fas fa-user-graduate dashboard-icon"></i>
                <h5 class="card-title">Students</h5>
                <p class="card-text display-4"><?php echo $student_count; ?></p>
                <a href="<?php echo URL_ROOT; ?>/teachers/students" class="btn btn-primary">Manage</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-center dashboard-card h-100">
            <div class="card-body">
                <i class="fas fa-users dashboard-icon"></i>
                <h5 class="card-title">Classes</h5>
                <p class="card-text display-4"><?php echo $class_count; ?></p>
                <a href="<?php echo URL_ROOT; ?>/teachers/classes" class="btn btn-primary">Manage</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-center dashboard-card h-100">
            <div class="card-body">
                <i class="fas fa-question-circle dashboard-icon"></i>
                <h5 class="card-title">Questions</h5>
                <p class="card-text display-4"><?php echo $question_count; ?></p>
                <a href="<?php echo URL_ROOT; ?>/teachers/questions" class="btn btn-primary">Manage</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-center dashboard-card h-100">
            <div class="card-body">
                <i class="fas fa-clipboard-list dashboard-icon"></i>
                <h5 class="card-title">Tests</h5>
                <p class="card-text display-4"><?php echo $test_count; ?></p>
                <a href="<?php echo URL_ROOT; ?>/teachers/tests" class="btn btn-primary">Manage</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Tests</h5>
                <a href="<?php echo URL_ROOT; ?>/teachers/tests" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if(!empty($recent_tests)) : ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Questions</th>
                                    <th>Created On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($recent_tests as $test) : ?>
                                    <tr>
                                        <td><?php echo $test->title; ?></td>
                                        <td><?php echo $test->question_count; ?></td>
                                        <td><?php echo date('M j, Y', strtotime($test->created_at)); ?></td>
                                        <td class="table-actions">
                                            <a href="<?php echo URL_ROOT; ?>/teachers/viewTest/<?php echo $test->id; ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo URL_ROOT; ?>/teachers/editTest/<?php echo $test->id; ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <p class="text-center">No tests created yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>