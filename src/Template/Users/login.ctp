<?php echo $this->Flash->render(); ?>  
<?= $this->Flash->render('auth') ?>
<?= $this->Form->create() ?>
<h1><?= __('Login') ?></h1>
<div class="form-group">
<?= $this->Form->input('username', array('class' => 'form-control')) ?>
<?= $this->Form->input('password', array('class' => 'form-control')) ?>
<?= $this->Html->link("Forgot password?", ['controller' => 'users', 'action' => 'forgot']) ?>
</div>
<?= $this->Form->button(__('Inloggen'), ['class'=>'btn bevelled']); ?>
<?= $this->Form->end() ?>