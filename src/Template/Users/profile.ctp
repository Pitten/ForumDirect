<div class="row row-offcanvas row-offcanvas-left">

    <div class="col-12 col-md-12">

        <div class="row">
            <div class="col-md-6">

                <div class="heading">
                    <h3 class="bevelled"><?= h($user->username); ?></h3>
                    <div class="main-content">
                        <div class="row">
                            <div class="col-md-10 col-lg-5"> <img alt="User Pic" src="<?= h($user->avatar); ?>" width="120px" height="120px">
                            </div>
                            <div class=" col-md-12 col-lg-5">
                                <ul class="list-unstyled">
                                    <li>Posts:
                                        <?= count($posts); ?>
                                    </li>
                                    <li>Threads:
                                        <?= count($threads); ?>
                                    </li>
                                    <br />
                                    <li>Bio: <i>This user doesn't have a bio apparantly</i></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="col-md-6">

                <div class="heading">
                    <h3 class="bevelled">Badges</h3>
                    <div class="main-content">
                        <div class="container">
                            asdf
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">

                <div class="heading">
                    <h3 class="bevelled">Friends</h3>
                    <div class="main-content">
                        <div class="container">
                            asdf
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>