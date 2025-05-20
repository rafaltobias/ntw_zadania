<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Test Results</h1>
</div>

<?php if(!empty($results)) : ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Test</th>
                            <th>Score</th>
                            <th>Completed</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($results as $result) : ?>
                            <tr>
                                <td><?php echo $result->student_name; ?></td>
                                <td><?php echo $result->test_title; ?></td>
                                <td>
                                    <span class="badge <?php 
                                        if ($result->score >= 80) echo 'bg-success';
                                        else if ($result->score >= 60) echo 'bg-info';
                                        else if ($result->score >= 40) echo 'bg-warning';
                                        else echo 'bg-danger';
                                    ?>">
                                        <?php echo $result->score; ?>%
                                    </span>
                                </td>
                                <td><?php echo date('M j, Y, g:i a', strtotime($result->completed_at)); ?></td>
                                <td>
                                    <a href="<?php echo URL_ROOT; ?>/teachers/viewResult/<?php echo $result->id; ?>" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View Details
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
        <p>No test results available yet.</p>
    </div>
<?php endif; ?>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
