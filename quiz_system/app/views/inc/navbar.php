<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URL_ROOT; ?>"><?php echo SITE_NAME; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URL_ROOT; ?>">Home</a>
                </li>
                <?php if(isset($_SESSION['user_id'])) : ?>
                    <?php if($_SESSION['user_role'] === 'teacher') : ?>
                        <!-- Teacher Navigation -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL_ROOT; ?>/teachers/dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL_ROOT; ?>/teachers/students">Students</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL_ROOT; ?>/teachers/classes">Classes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL_ROOT; ?>/teachers/questions">Questions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL_ROOT; ?>/teachers/tests">Tests</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL_ROOT; ?>/teachers/results">Results</a>
                        </li>
                    <?php elseif($_SESSION['user_role'] === 'student') : ?>
                        <!-- Student Navigation -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL_ROOT; ?>/students/dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL_ROOT; ?>/students/tests">Available Tests</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL_ROOT; ?>/students/completedTests">Completed Tests</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL_ROOT; ?>/students/classes">Your Classes</a>
                        </li>
                    <?php endif; ?>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL_ROOT; ?>/home/about">About</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if(isset($_SESSION['user_id'])) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> <?php echo $_SESSION['user_name']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/users/profile">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/users/logout">Logout</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL_ROOT; ?>/users/login">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
