<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Completed Tests</h1>
    <a href="<?php echo URL_ROOT; ?>/students/tests" class="btn btn-outline-primary">
        <i class="fas fa-clipboard-list"></i> Available Tests
    </a>
</div>

<?php if(!empty($tests)) : ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Test</th>
                            <th>Score</th>
                            <th>Completed</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tests as $test) : ?>
                            <tr>
                                <td><?php echo $test->title; ?></td>
                                <td>
                                    <span class="badge <?php 
                                        if ($test->score >= 80) echo 'bg-success';
                                        else if ($test->score >= 60) echo 'bg-info';
                                        else if ($test->score >= 40) echo 'bg-warning';
                                        else echo 'bg-danger';
                                    ?>">
                                        <?php echo $test->score; ?>%
                                    </span>
                                </td>
                                <td><?php echo date('M j, Y, g:i a', strtotime($test->completed_at)); ?></td>
                                <td>
                                    <a href="<?php echo URL_ROOT; ?>/students/viewResult/<?php echo $test->id; ?>" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View Result
                                    </a>
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
        <p>You haven't completed any tests yet.</p>
    </div>
<?php endif; ?>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
