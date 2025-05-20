<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Question Bank</h1>
    <a href="<?php echo URL_ROOT; ?>/teachers/addQuestion" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Question
    </a>
</div>

<?php if(!empty($questions)) : ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="70%">Question</th>
                            <th>Created On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($questions as $question) : ?>
                            <tr>
                                <td><?php echo substr($question->content, 0, 100); echo (strlen($question->content) > 100) ? '...' : ''; ?></td>
                                <td><?php echo date('M j, Y', strtotime($question->created_at)); ?></td>
                                <td class="table-actions">
                                    <a href="<?php echo URL_ROOT; ?>/teachers/viewQuestion/<?php echo $question->id; ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo URL_ROOT; ?>/teachers/editQuestion/<?php echo $question->id; ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form class="d-inline" action="<?php echo URL_ROOT; ?>/teachers/deleteQuestion/<?php echo $question->id; ?>" method="post">
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
        <p>You haven't created any questions yet. Click the "Add New Question" button to get started.</p>
    </div>
<?php endif; ?>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
