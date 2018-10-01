<?php echo $this->Flash->render(); ?>  

<?php if (isset($username)) { echo '<div class="alert alert-info">Hello, '.$username.'!</div>'; } ?>

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
              <a href="threads/view/<?= h($threads->id); ?>"><?= h($threads->title); ?></a> 
              <p>
              <a href="users/profile/<?= h($threads->last_post_uid); ?>"><?= h($username); ?></a>
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

    <div class="col-md-8 order-md-first">
    <?php foreach( $query as $forums ): ?>
    <?php $len = count($forums->sub_forums); ?>
      <div class="forum-group">
        <div class="heading">
          <h3 class="bevelled"><?= $forums['title']; ?></h3>
        </div>
        <div class="main-content">
        <?php for ($i = 0; $i < $len; $i++): ?>
          <div class="topic-list">
            <div class="topic-small bevelled d-flex flex-row">
              <div class="forum-name">
                <a href="subforums/view/<?= h($forums->sub_forums[$i]->id); ?>"><?= h($forums->sub_forums[$i]->title); ?></a>
              </div>
              <?= $this->cell('Forum::get_latest_thread', [$forums->sub_forums[$i]->id]); ?>
            </div>
          </div>
          <?php endfor; ?>

          <?php if (!$len): ?>
            <div class="alert alert-warning" style="margin-bottom: unset;"><span>No subforums in this category</span></div>
          <?php endif; ?> 
        </div>
      </div>
      <br />
      <?php endforeach; ?>
      <div class="heading">
        <h3 class="bevelled">Statistics</h3>
      </div>
      <div class="main-content">
        <b>User roles</b>
        <p>
        <span>member</span>, <span>moderator</span>, <span>administrator</span>, <span>banned</span>
        </p>
        <small>Powered on ForumDirect</small>
      </div>
      <br>
    </div>
    </div>
</div>
