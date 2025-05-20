<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-10 mx-auto">
        <a href="<?php echo URL_ROOT; ?>/teachers/questions" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Questions
        </a>
        
        <div class="card">
            <div class="card-header">
                <h4>Add New Question</h4>
            </div>
            <div class="card-body">
                <form action="<?php echo URL_ROOT; ?>/teachers/addQuestion" method="post">
                    <div class="mb-3">
                        <label for="content" class="form-label">Question Text</label>
                        <textarea name="content" id="content" rows="3" class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>"><?php echo $content; ?></textarea>
                        <span class="invalid-feedback"><?php echo $content_err; ?></span>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Answer Options</label>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="correct_answer" id="answer0" value="0" <?php echo ($correct_answer == 0) ? 'checked' : ''; ?>>
                                    <label class="form-check-label w-100" for="answer0">
                                        <input type="text" name="answer1" class="form-control <?php echo (!empty($answers_err)) ? 'is-invalid' : ''; ?>" placeholder="Option 1" value="<?php echo $answers[0]; ?>">
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="correct_answer" id="answer1" value="1" <?php echo ($correct_answer == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label w-100" for="answer1">
                                        <input type="text" name="answer2" class="form-control" placeholder="Option 2" value="<?php echo $answers[1]; ?>">
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="correct_answer" id="answer2" value="2" <?php echo ($correct_answer == 2) ? 'checked' : ''; ?>>
                                    <label class="form-check-label w-100" for="answer2">
                                        <input type="text" name="answer3" class="form-control" placeholder="Option 3" value="<?php echo $answers[2]; ?>">
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="correct_answer" id="answer3" value="3" <?php echo ($correct_answer == 3) ? 'checked' : ''; ?>>
                                    <label class="form-check-label w-100" for="answer3">
                                        <input type="text" name="answer4" class="form-control" placeholder="Option 4" value="<?php echo $answers[3]; ?>">
                                    </label>
                                </div>
                                
                                <small class="text-muted mt-2 d-block">Select the radio button next to the correct answer.</small>
                                <span class="text-danger"><?php echo $answers_err; ?></span>
                                <span class="text-danger"><?php echo $correct_answer_err; ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Save Question</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
