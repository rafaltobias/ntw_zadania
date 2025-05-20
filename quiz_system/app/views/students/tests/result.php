<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Test Results</h1>
    <a href="<?php echo URL_ROOT; ?>/students/completedTests" class="btn btn-outline-secondary">
        <i class="fas fa-list"></i> All Results
    </a>
</div>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Summary: <?php echo $result->test_title; ?></h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Date Completed:</strong> <?php echo date('F j, Y, g:i a', strtotime($result->completed_at)); ?></p>
                <p><strong>Total Questions:</strong> <?php echo $result->total_questions; ?></p>
            </div>
            <div class="col-md-6">
                <div class="text-center">
                    <h2 class="display-4">
                        <?php echo $result->score; ?> / <?php echo $result->total_questions; ?>
                    </h2>
                    <p class="lead">
                        <?php 
                        $percentage = ($result->score / $result->total_questions) * 100;
                        echo number_format($percentage, 1) . '%';
                        ?>
                    </p>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar 
                            <?php 
                            if ($percentage >= 80) echo 'bg-success';
                            else if ($percentage >= 60) echo 'bg-info';
                            else if ($percentage >= 40) echo 'bg-warning';
                            else echo 'bg-danger';
                            ?>" 
                            role="progressbar" style="width: <?php echo $percentage; ?>%;" 
                            aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h3 class="mb-3">Detailed Results</h3>

<?php foreach($result->questions as $index => $question) : ?>
    <div class="card mb-4 <?php echo $question->is_correct ? 'border-success' : 'border-danger'; ?>">
        <div class="card-header d-flex justify-content-between align-items-center
            <?php echo $question->is_correct ? 'bg-success text-white' : 'bg-danger text-white'; ?>">
            <h5 class="mb-0">Question <?php echo $index + 1; ?></h5>
            <span class="badge bg-light text-dark">
                <?php echo $question->is_correct ? '<i class="fas fa-check"></i> Correct' : '<i class="fas fa-times"></i> Incorrect'; ?>
            </span>
        </div>
        <div class="card-body">
            <p class="lead"><?php echo $question->content; ?></p>
            
            <div class="answers mt-4">
                <?php foreach($question->answers as $answer) : ?>
                    <div class="answer-option 
                        <?php 
                        if ($answer->id == $question->student_answer_id && $question->is_correct) {
                            echo 'correct';
                        } elseif ($answer->id == $question->student_answer_id && !$question->is_correct) {
                            echo 'incorrect';
                        } elseif ($answer->is_correct) {
                            echo 'correct';
                        }
                        ?>">
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <?php if ($answer->id == $question->student_answer_id) : ?>
                                    <i class="fas fa-circle-check me-1 <?php echo $answer->is_correct ? 'text-success' : 'text-danger'; ?>"></i>
                                    Your answer
                                <?php elseif ($answer->is_correct) : ?>
                                    <i class="fas fa-check-circle me-1 text-success"></i>
                                    Correct answer
                                <?php endif; ?>
                            </div>
                            <div>
                                <?php echo $answer->content; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
