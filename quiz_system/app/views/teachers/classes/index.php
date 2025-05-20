<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Classes</h1>
    <a href="<?php echo URL_ROOT; ?>/teachers/addClass" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Class
    </a>
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
                            <i class="fas fa-user-graduate me-2"></i>
                            <span><?php echo $class->student_count; ?> students</span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="btn-group w-100">
                            <a href="<?php echo URL_ROOT; ?>/teachers/viewClass/<?php echo $class->id; ?>" class="btn btn-outline-primary">
                                <i class="fas fa-users"></i> View
                            </a>
                            <a href="<?php echo URL_ROOT; ?>/teachers/editClass/<?php echo $class->id; ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form class="d-inline" action="<?php echo URL_ROOT; ?>/teachers/deleteClass/<?php echo $class->id; ?>" method="post" style="width: 33.333%">
                                <button type="submit" class="btn btn-outline-danger w-100 btn-delete">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <div class="alert alert-info">
        <p>You haven't created any classes yet. Click the "Add New Class" button to get started.</p>
    </div>
<?php endif; ?>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
