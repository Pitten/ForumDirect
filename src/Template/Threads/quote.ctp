<?php echo $this->Flash->render(); ?>  
<h1>Quote Post</h1>
<?php
    $username = $this->cell('Forum::getUsername', [$thread->author_id]);
    $user = $username .= ":\n\n";
    echo $this->Form->create($quote);
    echo '<div class="form-group">';
    echo $this->Form->control('body', ['rows' => '8', 'class' => 'form-control', 'default' => $user .= $default]);
    echo '</div>';
    echo $this->Form->button(__('Quote Post'), ['class'=>'btn bevelled']);
    echo $this->Form->end();
?>

<script>
    $('#body').val(function() {
    return $('#body').val().split('\n').map(function(line) {
        return '> '+line;
    }).join('\n');
});
</script>