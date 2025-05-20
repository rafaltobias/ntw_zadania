<?php require APP_ROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2 class="text-center mb-3"><i class="fas fa-sign-in-alt"></i> Login</h2>
            <form action="<?php echo URL_ROOT; ?>/users/login" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Lista wszystkich kont użytkowników -->
<?php if(isset($all_users) && !empty($all_users)): ?>
<div class="row mt-4">
    <div class="col-md-10 mx-auto">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h3>Lista wszystkich kont użytkowników</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nazwa użytkownika</th>                                <th>Imię i nazwisko</th>
                                <th>Email</th>
                                <th>Rola</th>
                                <th>Hasło</th>
                                <th>Data utworzenia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($all_users as $user): ?>
                            <tr>
                                <td><?php echo $user->id; ?></td>
                                <td><?php echo $user->username; ?></td>
                                <td><?php echo $user->name; ?></td>
                                <td><?php echo $user->email; ?></td>
                                <td><?php echo $user->role; ?></td>
                                <td><code><?php echo $user->password; ?></code></td>
                                <td><?php echo $user->created_at; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>                <div class="alert alert-warning mt-3">
                    <strong>Uwaga:</strong> Hasła są przechowywane w niezaszyfrowanej formie tekstowej.
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require APP_ROOT . '/views/inc/footer.php'; ?>
