<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <a href="<?php echo URL_ROOT; ?>/teachers/questions" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Questions
        </a>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Question Details</h4>
                <div>
                    <a href="<?php echo URL_ROOT; ?>/teachers/editQuestion/<?php echo $question->id; ?>" class="btn btn-primary me-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form class="d-inline" action="<?php echo URL_ROOT; ?>/teachers/deleteQuestion/<?php echo $question->id; ?>" method="post">
                        <button type="submit" class="btn btn-danger btn-delete">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5>Question:</h5>
                    <p class="fs-5"><?php echo $question->content; ?></p>
                </div>

                <div class="mb-4">
                    <h5>Answer Options:</h5>
                    <div class="list-group">
                        <?php foreach($question->answers as $index => $answer) : ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    <strong><?php echo chr(65 + $index); ?>)</strong> <?php echo $answer->content; ?>
                                </span>
                                <?php if($answer->is_correct) : ?>
                                    <span class="badge bg-success">Correct Answer</span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6>Created On</h6>
                                <p class="mb-0"><?php echo date('M j, Y g:i A', strtotime($question->created_at)); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h6>Question ID</h6>
                                <p class="mb-0">#<?php echo $question->id; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
