<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?php echo $class->name; ?></h1>
    <a href="<?php echo URL_ROOT; ?>/students/classes" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back to Classes
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Class Information</h5>
            </div>
            <div class="card-body">
                <p class="mb-3"><?php echo !empty($class->description) ? $class->description : 'No description available.'; ?></p>
                <div class="d-flex align-items-center">
                    <i class="fas fa-users me-2"></i>
                    <span><?php echo $class->student_count; ?> students enrolled</span>
                </div>
            </div>
        </div>

        <?php if(!empty($class->students)) : ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Classmates</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php foreach($class->students as $student) : ?>
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-graduate me-3"></i>
                                    <div>
                                        <h6 class="mb-0"><?php echo $student->name; ?></h6>
                                        <small class="text-muted"><?php echo $student->email; ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Assigned Tests</h5>
            </div>
            <div class="card-body">
                <?php if(!empty($class->tests)) : ?>
                    <div class="list-group">
                        <?php foreach($class->tests as $test) : ?>
                            <a href="<?php echo URL_ROOT; ?>/students/takeTest/<?php echo $test->id; ?>" 
                               class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?php echo $test->title; ?></h6>
                                    <small><?php echo $test->question_count; ?> questions</small>
                                </div>
                                <p class="mb-1"><?php echo $test->description; ?></p>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <p class="text-center">No tests assigned to this class yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
