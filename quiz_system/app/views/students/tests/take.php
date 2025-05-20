<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Taking Test: <?php echo $test->title; ?></h1>
    <div class="badge bg-primary p-2" id="test-timer" data-duration="0">
        <i class="fas fa-clock me-1"></i> No time limit
    </div>
</div>

<form id="test-form" action="<?php echo URL_ROOT; ?>/students/submitTest" method="post">
    <input type="hidden" name="test_id" value="<?php echo $test->id; ?>">
    
    <?php foreach($questions as $index => $question) : ?>
        <div class="card question-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Question <?php echo $index + 1; ?></h5>
                <span class="badge bg-secondary"><?php echo count($questions); ?> questions in total</span>
            </div>
            <div class="card-body">
                <p class="lead"><?php echo $question['content']; ?></p>
                
                <div class="answers mt-4">
                    <?php foreach($question['answers'] as $answer_index => $answer) : ?>
                        <div class="answer-option">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question_<?php echo $question['id']; ?>" 
                                    id="q<?php echo $question['id']; ?>_a<?php echo $answer->id; ?>" value="<?php echo $answer->id; ?>">
                                <label class="form-check-label w-100" for="q<?php echo $question['id']; ?>_a<?php echo $answer->id; ?>">
                                    <?php echo $answer->content; ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    
    <div class="card">
        <div class="card-body text-center">
            <p>Once you submit, you won't be able to change your answers.</p>
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-paper-plane me-2"></i> Submit Test
            </button>
        </div>
    </div>
</form>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
