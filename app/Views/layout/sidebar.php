    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <?php if (session()->get('is_admin') == '1') : ?>

                <!-- End Dashboard Nav -->

                <li class="nav-item">
                    <a class="nav-link <?= $title == 'Dashboard' ? '' : 'collapsed'; ?>" href="/">
                        <i class="bi bi-grid"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $title == 'Employees' ? '' : 'collapsed'; ?>" href="/employees">
                        <i class="bi bi-people"></i>
                        <span>Employees</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $title == 'Departments' ? '' : 'collapsed'; ?>" href="/departments">
                        <i class="bi bi-building"></i>
                        <span>Departments</span>
                    </a>
                </li>



            <?php endif ?>


            <li class="nav-item">
                <a class="nav-link <?= $title == 'Attendance' ? '' : 'collapsed'; ?>" href="/attendance">
                    <i class="bi bi-clock"></i>
                    <span>Attendance</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?= str_contains($title, 'Timesheets') ? '' : 'collapsed'; ?>" data-bs-target="#components-nav" data-bs-toggle="collapse" href="/timesheets">
                    <i class="bi bi-table"></i><span>Timesheet</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse <?= str_contains($title, 'Timesheets') ? 'show' : ''; ?> " data-bs-parent="#sidebar-nav">
                    <?php if (session()->get('is_admin') == '1') : ?>
                        <li>
                            <a href="/timesheets_employee" class="<?= $title == 'Timesheets - Employee' ? 'active' : ''; ?>">
                                <i class="bi bi-circle"></i><span>By Employee</span>
                            </a>
                        </li>
                        <li>
                            <a href="/timesheets_date" class="<?= $title == 'Timesheets - Date' ? 'active' : ''; ?>">
                                <i class="bi bi-circle"></i><span>By Date</span>
                            </a>
                        </li>
                    <?php endif ?>
                    <li>
                        <a href="/user_timesheets" class="<?= $title == 'My Timesheets' ? 'active' : ''; ?>">
                            <i class="bi bi-circle"></i><span>My Timesheets</span>
                        </a>
                    </li>
                </ul>
            </li>



        </ul>

    </aside><!-- End Sidebar-->