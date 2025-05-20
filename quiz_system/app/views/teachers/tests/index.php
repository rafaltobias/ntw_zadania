<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Tests</h1>
    <a href="<?php echo URL_ROOT; ?>/teachers/addTest" class="btn btn-primary">
        <i class="fas fa-plus"></i> Create New Test
    </a>
</div>

<?php if(!empty($tests)) : ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Test Title</th>
                            <th>Questions</th>
                            <th>Created On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tests as $test) : ?>
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
                                    <form class="d-inline" action="<?php echo URL_ROOT; ?>/teachers/deleteTest/<?php echo $test->id; ?>" method="post">
                                        <button type="submit" class="btn btn-sm btn-danger btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="alert alert-info">
        <p>You haven't created any tests yet. Click the "Create New Test" button to get started.</p>
    </div>
<?php endif; ?>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
