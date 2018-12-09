<?php 
use Cake\I18n\Time;
?>
<?php foreach( $query as $threads ): ?>
<?php $now = new Time($threads->last_post_date); ?>

<?php $duplicateSlug = $this->cell('Forum::checkDuplicateSlugs', [$threads->slug, $threads->id]); ?>

<img src="<?= h($this->cell('Forum::getAvatar', [$threads->last_post_uid])); ?>" width="64px" height="64px" style="margin-left: 25px">
    <div class="d-flex flex-column" style="flex-grow: 1; justify-content: center;">
        <a href="thread/<?php if($duplicateSlug == "yes"){ echo $threads->id . '-' . h($threads->slug); } else { echo h($threads->slug); } ?>?action=lastpost" class="title"><?= h($threads->title) ?></a>
    <div>
        <span class="author">by <a href="users/profile/<?= h($threads->last_post_uid) ?>"><?php echo h($this->cell('Forum::getUsername', [$threads->last_post_uid])); ?></a></span>
        <span class="date"><span class="fa fa-calendar"></span> <?php echo $now->timeAgoInWords(
    ['format' => 'MMM d, YYY', 'end' => '+1 year']
); ?></span>
    </div>
</div>
<div class="forum-posts">
    <div><?= count($posts_query); ?></div>
    <div>Posts</div>
</div>

<?php endforeach; ?>

<?php if ($query->isEmpty()) {
    echo '<div class="d-flex flex-column" style="flex-grow: 1; justify-content: center;">';
    echo '<span> - </span>';
    echo '</div>';
}
?>