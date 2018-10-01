<?=$this->Flash->render(); ?>
<?php $lastfid = count($query->toArray()); ?>
<?php use Cake\I18n\Time; ?>
<div class="row">
    <div class="col-md-4">
      <div class="heading">
          <h3 class="bevelled">Recent activity</h3>
        </div>
        <div class="main-content">
          <ul class="list-unstyled">
           <?php foreach( $recent_activity as $threads ): ?>
           <?php $username = $this->cell('Forum::getUsername', [$threads->last_post_uid]); ?> 
            <li class="cutoff">
              <a href="../../threads/view/<?= h($threads->id); ?>"><?= h($threads->title); ?></a> 
              <p>
              <a href="../../users/profile/<?= h($threads->last_post_uid); ?>"><?= h($username); ?></a>
              <span class="float-right"><?= $this->Time->timeAgoInWords($threads->last_post_date); ?></span>
              </p>
              </li>
              <hr />
            <?php endforeach; ?>
            <?php if ($recent_activity->isEmpty()): ?>  
                <li>No data to display.</li>
            <?php endif; ?>
            </ul>
        </div>
        <br />
    </div>
    
<!--- Sub Forum !-->
<div class="col-md-8 order-md-first">
    <?php $len = count($query->threads); ?>
      <div class="forum-group">
        <div class="heading">
          <h3 class="bevelled"><?= h($query->title); ?><?php if (isset($user)) { echo '<a href="../../threads/add/'.$query->id.'" class="btn btn-sm bevelled float-right">add</a>'; } ?></h3>
        </div>
        <div class="main-content">
        <?php for ($i = 0; $i < $len; $i++): ?>
        <?php $now = new Time($query->threads[$i]->last_post_date); ?>
          <div class="topic-list">
            <div class="topic-small bevelled d-flex flex-row">
                <img src="<?= h($this->cell('Forum::getAvatar', [$query->threads[$i]->last_post_uid])); ?>" width="64px" height="64px" style="margin-left: 25px">
    <div class="d-flex flex-column" style="flex-grow: 1; justify-content: center;">
        <a href="../../threads/view/<?=h($query->threads[$i]->id); ?>" class="title"><?=h($query->threads[$i]->title); ?></a>
    <div>
        <span class="author">by  <a href="../../users/profile/<?=h($query->threads[$i]->last_post_uid); ?>"><?php echo h($this->cell('Forum::getUsername', [$query->threads[$i]->last_post_uid])); ?></a></span>
        <span class="date"><span class="fa fa-calendar"></span> <?php echo $now->timeAgoInWords(
    ['format' => 'MMM d, YYY', 'end' => '+1 year']
           ); ?></span>
           </div>
           </div>
          <div class="forum-posts">
          <div>99</div>
           <div>Posts</div>
          </div>
          <div class="forum-views">
          <div>99</div>
          <div>Views</div>
           </div>
            </div>
          </div>

      <?php endfor; ?>

          <?php if (!$len): ?>
            <div class="alert alert-warning" style="margin-bottom: unset;"><span>No threads in this subforum</span></div>
          <?php endif; ?> 
        </div>
      </div>
      </div>
</div>