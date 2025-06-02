<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Available Tests</h1>
</div>

<?php if(!empty($tests)) : ?>
    <div class="row">
        <?php foreach($tests as $test) : ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $test->title; ?></h5>
                        <p class="card-text text-muted"><?php echo !empty($test->description) ? substr($test->description, 0, 100) . (strlen($test->description) > 100 ? '...' : '') : 'No description'; ?></p>
                        
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-question-circle me-2 text-primary"></i>
                                <span><?php echo $test->question_count; ?> questions</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock me-2 text-secondary"></i>
                                <span>Estimated time: <?php echo ceil($test->question_count * 1.5); ?> minutes</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="<?php echo URL_ROOT; ?>/students/takeTest/<?php echo $test->id; ?>" class="btn btn-primary w-100">
                            <i class="fas fa-play"></i> Take Test
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle fa-2x mb-3"></i>
        <h5>No Tests Available</h5>
        <p>There are currently no tests assigned to you. Check back later or contact your teacher.</p>
    </div>
<?php endif; ?>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
