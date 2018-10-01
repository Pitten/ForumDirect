<?php echo $this->Flash->render(); ?>  
<h1>Add Post</h1>
<?php
    echo $this->Form->create($post);
    echo '<div class="form-group">';
    echo $this->Form->control('body', ['rows' => '8', 'class' => 'form-control']);
    echo '</div>';
    echo $this->Form->button(__('Save Post'), ['class'=>'btn bevelled']);
    echo $this->Form->end();
?>