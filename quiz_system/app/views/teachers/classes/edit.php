<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <a href="<?php echo URL_ROOT; ?>/teachers/viewClass/<?php echo $id; ?>" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Class Details
        </a>

        <div class="card">
            <div class="card-header">
                <h4>Edit Class</h4>
            </div>
            <div class="card-body">
                <form action="<?php echo URL_ROOT; ?>/teachers/editClass/<?php echo $id; ?>" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Class Name</label>
                        <input type="text" name="name" id="name" 
                               class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" 
                               value="<?php echo $name; ?>" 
                               placeholder="Enter class name">
                        <span class="invalid-feedback"><?php echo $name_err; ?></span>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" 
                                  class="form-control" 
                                  rows="4" 
                                  placeholder="Enter class description (optional)"><?php echo $description; ?></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Class
                        </button>
                        <a href="<?php echo URL_ROOT; ?>/teachers/viewClass/<?php echo $id; ?>" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
