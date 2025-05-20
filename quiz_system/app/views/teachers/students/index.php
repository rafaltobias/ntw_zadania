<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Students</h1>
    <a href="<?php echo URL_ROOT; ?>/teachers/addStudent" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Student
    </a>
</div>

<?php if(!empty($students)) : ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($students as $student) : ?>
                            <tr>
                                <td><?php echo $student->username; ?></td>
                                <td><?php echo $student->name; ?></td>
                                <td><?php echo $student->email; ?></td>
                                <td class="table-actions">
                                    <a href="<?php echo URL_ROOT; ?>/teachers/editStudent/<?php echo $student->id; ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form class="d-inline" action="<?php echo URL_ROOT; ?>/teachers/deleteStudent/<?php echo $student->id; ?>" method="post">
                                        <button type="submit" class="btn btn-sm btn-danger btn-delete">
                                            <i class="fas fa-trash"></i> Delete
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
        <p>No students found. Click the "Add New Student" button to add a student.</p>
    </div>
<?php endif; ?>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
