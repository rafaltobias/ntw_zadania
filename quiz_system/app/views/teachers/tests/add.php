<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-10 mx-auto">
        <a href="<?php echo URL_ROOT; ?>/teachers/tests" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Tests
        </a>

        <div class="card">
            <div class="card-header">
                <h4><?php echo $page_title; ?></h4>
            </div>
            <div class="card-body">
                <form action="<?php echo URL_ROOT; ?>/teachers/addTest" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Test Title</label>
                                <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" 
                                       value="<?php echo $title; ?>" placeholder="Enter test title">
                                <span class="invalid-feedback"><?php echo $title_err; ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-muted">(Optional)</span></label>
                        <textarea name="description" class="form-control" rows="3" 
                                  placeholder="Enter test description..."><?php echo $description; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Questions</label>
                        <?php if(!empty($all_questions)) : ?>
                            <div class="border rounded p-3" style="max-height: 400px; overflow-y: auto;">
                                <?php foreach($all_questions as $question) : ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="questions[]" 
                                               value="<?php echo $question->id; ?>" id="question_<?php echo $question->id; ?>"
                                               <?php echo (in_array($question->id, $questions)) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="question_<?php echo $question->id; ?>">
                                            <div class="question-preview">
                                                <strong>Question:</strong> <?php echo substr($question->content, 0, 100) . (strlen($question->content) > 100 ? '...' : ''); ?>
                                                <div class="small text-muted mt-1">
                                                    <i class="fas fa-calendar"></i> Created: <?php echo date('M j, Y', strtotime($question->created_at)); ?>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if(!empty($questions_err)) : ?>
                                <div class="text-danger mt-2">
                                    <?php echo $questions_err; ?>
                                </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <div class="alert alert-info">
                                <p class="mb-0">You haven't created any questions yet. <a href="<?php echo URL_ROOT; ?>/teachers/addQuestion">Create a question</a> first to build a test.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if(!empty($all_questions)) : ?>
                        <div class="d-grid">
                            <input type="submit" value="Create Test" class="btn btn-success">
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add some JavaScript to show question count
    const checkboxes = document.querySelectorAll('input[name="questions[]"]');
    const createButton = document.querySelector('input[type="submit"]');
    
    function updateButtonText() {
        const checkedCount = document.querySelectorAll('input[name="questions[]"]:checked').length;
        if (createButton) {
            createButton.value = `Create Test (${checkedCount} questions selected)`;
        }
    }
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateButtonText);
    });
    
    // Initial update
    updateButtonText();
});
</script>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
