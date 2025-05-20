<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?php echo $class->name; ?></h1>
    <div>
        <a href="<?php echo URL_ROOT; ?>/teachers/editClass/<?php echo $class->id; ?>" class="btn btn-primary me-2">
            <i class="fas fa-edit"></i> Edit Class
        </a>
        <a href="<?php echo URL_ROOT; ?>/teachers/classes" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Classes
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Class Information</h5>
            </div>
            <div class="card-body">
                <p class="mb-3"><?php echo !empty($class->description) ? $class->description : 'No description available.'; ?></p>
                <div class="d-flex align-items-center">
                    <i class="fas fa-users me-2"></i>
                    <span><?php echo count($class->students); ?> students enrolled</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Enrolled Students</h5>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                    <i class="fas fa-plus"></i> Add Student
                </button>
            </div>
            <div class="card-body">
                <?php if(!empty($class->students)) : ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($class->students as $student) : ?>
                                    <tr>
                                        <td><?php echo $student->name; ?></td>
                                        <td><?php echo $student->username; ?></td>
                                        <td><?php echo $student->email; ?></td>
                                        <td>
                                            <form class="d-inline" action="<?php echo URL_ROOT; ?>/teachers/removeStudentFromClass/<?php echo $student->id; ?>/<?php echo $class->id; ?>" method="post">
                                                <button type="submit" class="btn btn-sm btn-danger btn-delete">
                                                    <i class="fas fa-user-minus"></i> Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <p class="text-center">No students enrolled in this class yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Class Statistics</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6>Total Students</h6>
                    <p class="display-4"><?php echo count($class->students); ?></p>
                </div>
                <!-- Additional statistics can be added here -->
            </div>
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStudentModalLabel">Add Student to Class</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if(!empty($available_students)) : ?>
                    <form action="<?php echo URL_ROOT; ?>/teachers/addStudentToClass" method="post">
                        <input type="hidden" name="class_id" value="<?php echo $class->id; ?>">
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Select Student</label>
                            <select name="student_id" id="student_id" class="form-select" required>
                                <option value="">Choose a student...</option>
                                <?php foreach($available_students as $student) : ?>
                                    <option value="<?php echo $student->id; ?>">
                                        <?php echo $student->name; ?> (<?php echo $student->username; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add to Class
                            </button>
                        </div>
                    </form>
                <?php else : ?>
                    <p class="text-center">No available students to add.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
