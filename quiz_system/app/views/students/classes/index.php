<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Your Classes</h1>
</div>

<?php if(!empty($classes)) : ?>
    <div class="row">
        <?php foreach($classes as $class) : ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $class->name; ?></h5>
                        <p class="card-text text-muted"><?php echo !empty($class->description) ? $class->description : 'No description'; ?></p>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-users me-2"></i>
                            <span><?php echo $class->student_count; ?> students</span>
                        </div>
                        <a href="<?php echo URL_ROOT; ?>/students/viewClass/<?php echo $class->id; ?>" class="btn btn-primary">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <div class="alert alert-info">
        <p>You are not enrolled in any classes yet.</p>
    </div>
<?php endif; ?>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
