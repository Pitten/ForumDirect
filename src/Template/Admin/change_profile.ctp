<?php echo $this->Flash->render(); ?>

    <div class="row row-offcanvas row-offcanvas-left">

        <div class="col-md-3 sidebar-offcanvas" id="sidebar">
            <div class="list-group">
                <a href="./admin/" class="list-group-item active">Admin</a>
                <a href="./admin/change-profile" class="list-group-item">Change profile</a>
            </div>
        </div>

        <div class="col-12 col-md-9">

            <div class="row">
                <div class="col-md-12">

                    <div class="heading">
                        <h3 class="bevelled">Users</h3>
                        <div class="main-content">
                            <div class="container">
                                <?php foreach($user as $users): ?>
                                    <ul class="list-unstyled">
                                        <li>
                                            <?= h($users->username); ?> <a href="edit-profile/<?= $users->id; ?>" class="btn bevelled float-right">edit</a></li>
                                        <li>
                                            <?= h($users->email); ?>
                                        </li>
                                    </ul>
                                    <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>