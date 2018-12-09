<?php echo $this->Flash->render(); ?>  
<h1>Edit Thread</h1>
<?php
    echo $this->Form->create($edit);
    echo '<div class="form-group">';
    echo $this->Form->control('title', array('class' => 'form-control'));
    echo $this->Form->control('body', ['rows' => '8', 'class' => 'form-control']);
    echo '</div>';
    echo $this->Form->button(__('Edit Thread'), ['class'=>'btn bevelled']);
    echo $this->Form->end();
?>