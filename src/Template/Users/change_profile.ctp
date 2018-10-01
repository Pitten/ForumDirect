<?php echo $this->Flash->render(); ?>  
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
      <?php echo $this->Form->create($change_profile); ?>
      <div class="form-group">
         <div class="row">
            <div class="col-md-8">
               <?php echo $this->Form->control('email', ['class' => 'form-control']); ?>
            </div>
            <div class="col-md-4">
               <?php echo $this->Form->control('user_title', ['class' => 'form-control']); ?>
            </div>
            <div class="col-md-12">
               <?php echo $this->Form->control('avatar', ['class' => 'form-control']); ?>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12">
            <?php echo $this->Form->button(__('Change profile') , ['class' => 'btn bevelled']); ?>
            <?php echo $this->Form->end(); ?>
         </div>
      </div>
   </div>
</div>
</div><!--/span-->
</div><!--/span-->