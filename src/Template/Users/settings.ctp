<div class="row row-offcanvas row-offcanvas-left">

  <div class="col-6 col-md-3 sidebar-offcanvas" id="sidebar">
    <div class="list-group">
      <a href="./settings" class="list-group-item active">Settings</a>
      <a href="./change-profile" class="list-group-item">Change profile</a>
      <a href="#" class="list-group-item">Change password</a>
      <a href="#" class="list-group-item">Change signature</a>
      <a href="#" class="list-group-item">Sessions</a>
    </div>
  </div>

<div class="col-12 col-md-9">
          
    <div class="row">
    <div class="col-md-12">

      <div class="heading">
          <h3 class="bevelled"><?= h($user->username); ?></h3>
        <div class="main-content">
          <div class="row">
            <div class="col-md-12 col-lg-7"> <img alt="User Pic" src="<?= h($user->avatar); ?>" width="120px" height="120px"> </div>
            <div class=" col-md-12 col-lg-5"> 
            <ul class="list-unstyled">
            <li>Posts: <?= count($posts); ?></li>
            <li>Threads: <?= count($threads); ?></li>
            <li>Warning level: 0%</li>
            </ul>
            </div>
          </div>
        </div>
    </div>
    <br>
    </div>
     <div class="col-md-12">

      <div class="heading">
          <h3 class="bevelled">Warnings</h3>
        <div class="main-content">
        <div class="container">
          asdf
        </div>
        </div>
    </div>
    </div>
    </div>
          
    </div><!--/span-->

  <!--/span-->
  </div>