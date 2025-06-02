<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <a href="<?php echo URL_ROOT; ?>/teachers/questions" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Questions
        </a>

        <div class="card">
            <div class="card-header">
                <h4>Edit Question</h4>
            </div>
            <div class="card-body">
                <form action="<?php echo URL_ROOT; ?>/teachers/editQuestion/<?php echo $id; ?>" method="post">
                    <div class="mb-3">
                        <label for="content" class="form-label">Question Content</label>
                        <textarea name="content" class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>" 
                                  rows="3" placeholder="Enter your question here..."><?php echo $content; ?></textarea>
                        <span class="invalid-feedback"><?php echo $content_err; ?></span>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="answer1" class="form-label">Answer Option 1</label>
                                <input type="text" name="answer1" class="form-control <?php echo (!empty($answers_err)) ? 'is-invalid' : ''; ?>" 
                                       value="<?php echo $answers[0]; ?>" placeholder="First answer option">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="answer2" class="form-label">Answer Option 2</label>
                                <input type="text" name="answer2" class="form-control <?php echo (!empty($answers_err)) ? 'is-invalid' : ''; ?>" 
                                       value="<?php echo $answers[1]; ?>" placeholder="Second answer option">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="answer3" class="form-label">Answer Option 3</label>
                                <input type="text" name="answer3" class="form-control <?php echo (!empty($answers_err)) ? 'is-invalid' : ''; ?>" 
                                       value="<?php echo $answers[2]; ?>" placeholder="Third answer option">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="answer4" class="form-label">Answer Option 4</label>
                                <input type="text" name="answer4" class="form-control <?php echo (!empty($answers_err)) ? 'is-invalid' : ''; ?>" 
                                       value="<?php echo $answers[3]; ?>" placeholder="Fourth answer option">
                            </div>
                        </div>
                    </div>

                    <?php if(!empty($answers_err)) : ?>
                        <div class="alert alert-danger">
                            <?php echo $answers_err; ?>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="correct_answer" class="form-label">Correct Answer</label>
                        <select name="correct_answer" class="form-select <?php echo (!empty($correct_answer_err)) ? 'is-invalid' : ''; ?>">
                            <option value="">Select the correct answer...</option>
                            <option value="0" <?php echo ($correct_answer == 0) ? 'selected' : ''; ?>>Answer Option 1</option>
                            <option value="1" <?php echo ($correct_answer == 1) ? 'selected' : ''; ?>>Answer Option 2</option>
                            <option value="2" <?php echo ($correct_answer == 2) ? 'selected' : ''; ?>>Answer Option 3</option>
                            <option value="3" <?php echo ($correct_answer == 3) ? 'selected' : ''; ?>>Answer Option 4</option>
                        </select>
                        <span class="invalid-feedback"><?php echo $correct_answer_err; ?></span>
                    </div>

                    <div class="d-grid">
                        <input type="submit" value="Update Question" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
