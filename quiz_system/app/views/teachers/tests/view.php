<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><?php echo $test->title; ?></h1>
    <div>
        <a href="<?php echo URL_ROOT; ?>/teachers/editTest/<?php echo $test->id; ?>" class="btn btn-primary me-2">
            <i class="fas fa-edit"></i> Edit Test
        </a>
        <a href="<?php echo URL_ROOT; ?>/teachers/tests" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Tests
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Test Information</h5>
            </div>
            <div class="card-body">
                <p class="mb-3"><?php echo !empty($test->description) ? $test->description : 'No description available.'; ?></p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-question-circle me-2"></i>
                            <span><?php echo count($test->questions); ?> questions</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-calendar me-2"></i>
                            <span>Created: <?php echo date('M j, Y', strtotime($test->created_at)); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Questions in This Test</h5>
            </div>
            <div class="card-body">
                <?php if(!empty($test->questions)) : ?>
                    <div class="accordion" id="questionsAccordion">
                        <?php foreach($test->questions as $index => $question) : ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading<?php echo $index; ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $index; ?>" aria-expanded="false" aria-controls="collapse<?php echo $index; ?>">
                                        <strong>Question <?php echo $index + 1; ?>:</strong>&nbsp;<?php echo substr($question->content, 0, 80) . (strlen($question->content) > 80 ? '...' : ''); ?>
                                    </button>
                                </h2>
                                <div id="collapse<?php echo $index; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $index; ?>" data-bs-parent="#questionsAccordion">
                                    <div class="accordion-body">
                                        <p><strong>Question:</strong> <?php echo $question->content; ?></p>
                                        <div class="list-group">
                                            <?php foreach($question->answers as $answerIndex => $answer) : ?>
                                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <strong><?php echo chr(65 + $answerIndex); ?>)</strong> <?php echo $answer->content; ?>
                                                    </span>
                                                    <?php if($answer->is_correct) : ?>
                                                        <span class="badge bg-success">Correct</span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <p class="text-center">No questions in this test yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Test Results</h5>
            </div>
            <div class="card-body">
                <?php if(!empty($results)) : ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Score</th>
                                    <th>Percentage</th>
                                    <th>Completed On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($results as $result) : ?>
                                    <tr>
                                        <td><?php echo $result->student_name; ?></td>
                                        <td><?php echo $result->score; ?>/<?php echo count($test->questions); ?></td>
                                        <td>
                                            <?php 
                                            $percentage = count($test->questions) > 0 ? round(($result->score / count($test->questions)) * 100, 1) : 0;
                                            echo $percentage; 
                                            ?>%
                                        </td>
                                        <td><?php echo date('M j, Y g:i A', strtotime($result->completed_at)); ?></td>
                                        <td>
                                            <a href="<?php echo URL_ROOT; ?>/teachers/viewResult/<?php echo $result->id; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> View Details
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <p class="text-center">No results available for this test yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Test Statistics</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6>Total Questions</h6>
                    <p class="display-6"><?php echo count($test->questions); ?></p>
                </div>
                <div class="mb-3">
                    <h6>Students Completed</h6>
                    <p class="display-6"><?php echo count($results); ?></p>
                </div>
                <?php if(!empty($results)) : ?>
                    <div class="mb-3">
                        <h6>Average Score</h6>
                        <?php 
                        $totalScore = 0;
                        foreach($results as $result) {
                            $totalScore += $result->score;
                        }
                        $averageScore = count($results) > 0 ? round($totalScore / count($results), 1) : 0;
                        $averagePercentage = count($test->questions) > 0 ? round(($averageScore / count($test->questions)) * 100, 1) : 0;
                        ?>
                        <p class="display-6"><?php echo $averagePercentage; ?>%</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Assign Test</h5>
            </div>
            <div class="card-body">
                <h6>Assign to Class</h6>
                <?php if(!empty($classes)) : ?>
                    <form action="<?php echo URL_ROOT; ?>/teachers/assignTestToClass" method="post" class="mb-3">
                        <input type="hidden" name="test_id" value="<?php echo $test->id; ?>">
                        <div class="mb-2">
                            <select name="class_id" class="form-select" required>
                                <option value="">Select a class...</option>
                                <?php foreach($classes as $class) : ?>
                                    <option value="<?php echo $class->id; ?>">
                                        <?php echo $class->name; ?> (<?php echo $class->student_count; ?> students)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary w-100">
                            <i class="fas fa-users"></i> Assign to Class
                        </button>
                    </form>
                <?php else : ?>
                    <p class="text-muted">No classes available.</p>
                <?php endif; ?>

                <h6>Assign to Individual Student</h6>
                <?php if(!empty($students)) : ?>
                    <form action="<?php echo URL_ROOT; ?>/teachers/assignTestToStudent" method="post">
                        <input type="hidden" name="test_id" value="<?php echo $test->id; ?>">
                        <div class="mb-2">
                            <select name="student_id" class="form-select" required>
                                <option value="">Select a student...</option>
                                <?php foreach($students as $student) : ?>
                                    <option value="<?php echo $student->id; ?>">
                                        <?php echo $student->name; ?> (<?php echo $student->username; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-secondary w-100">
                            <i class="fas fa-user"></i> Assign to Student
                        </button>
                    </form>
                <?php else : ?>
                    <p class="text-muted">No students available.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo URL_ROOT; ?>/teachers/deleteTest/<?php echo $test->id; ?>" method="post">
                    <button type="submit" class="btn btn-danger w-100 btn-delete">
                        <i class="fas fa-trash"></i> Delete Test
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
