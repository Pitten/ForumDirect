<?php echo $this->Flash->render(); ?>  
<div class="row row-offcanvas row-offcanvas-left">

  <div class="col-6 col-md-3 sidebar-offcanvas" id="sidebar">
    <div class="list-group">
      <a href="./admin/" class="list-group-item active">Admin</a>
      <a href="./admin/change-profile" class="list-group-item">Change profile</a>
    </div>
  </div>

<div class="col-12 col-md-9">
          
    <div class="row">
    <div class="col-md-12">

    <?php echo $this->Form->create($edit_profile); ?>
    <div class="form-group">
    <?php echo $this->Form->control('email', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('user_title', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('avatar', ['class' => 'form-control']); ?>
    <?php echo $this->Form->control('role', ['class' => 'form-control']); ?>
    </div>
    <?php echo $this->Form->button(__('Edit profile') , ['class' => 'btn bevelled']); ?>
    <?php echo $this->Form->end(); ?>

    </div>

    </div>
          
    </div><!--/span-->

  <!--/span-->
  </div>