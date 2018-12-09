<?php echo $this->Flash->render(); ?>  
<?= $this->Form->create($user) ?>
<h1><?= __('Add user') ?></h1>
<div class="form-group">
<?= $this->Form->input('username', array('class' => 'form-control')) ?>
</div>
<div class="form-group">
<?= $this->Form->input('email', array('class' => 'form-control')) ?>
</div>
<div class="form-group">
<?= $this->Form->input('password', array('class' => 'form-control')) ?>
</div>
<div class="form-check">
<?= $this->Html->link('Already have an account? Log in!', ['controller' => 'users', 'action' => 'login']) ?>
</div>
<?= $this->Form->button(__('Aanmelden'), ['class'=>'btn bevelled']); ?>
<?= $this->Form->end() ?>