<?php require APP_ROOT . '/views/inc/header.php'; ?>

<h1 class="mb-4">Student Dashboard</h1>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Available Tests</h5>
            </div>
            <div class="card-body">
                <?php if(!empty($available_tests)) : ?>
                    <div class="list-group">
                        <?php foreach($available_tests as $test) : ?>
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
                    <p class="text-center">No tests available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Recent Results</h5>
            </div>
            <div class="card-body">
                <?php if(!empty($recent_results)) : ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Test</th>
                                    <th>Score</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($recent_results as $result) : ?>
                                    <tr>
                                        <td><?php echo $result->test_title; ?></td>
                                        <td><?php echo $result->score; ?>%</td>
                                        <td><?php echo date('M j, Y', strtotime($result->completed_at)); ?></td>
                                        <td>
                                            <a href="<?php echo URL_ROOT; ?>/students/viewResult/<?php echo $result->id; ?>" 
                                               class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <p class="text-center">No test results yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
