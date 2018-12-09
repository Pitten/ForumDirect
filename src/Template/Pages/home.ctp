<?php
use Emojione\Client;

$client = new Client();
$client->ascii = true;
$client->unicodeAlt = true;
?>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/emojione/2.2.7/lib/js/emojione.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-linkify/2.1.7/linkify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-linkify/2.1.7/linkify-string.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-linkify/2.1.7/linkify-jquery.min.js"></script>
<script type="text/javascript" src="js/chatclient.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  connect();
});
</script>

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
           <?php $duplicateSlug = $this->cell('Forum::checkDuplicateSlugs', [$threads->slug, $threads->id]); ?>
            <li class="cutoff"> 
              <a href="thread/<?php if($duplicateSlug == "yes"){ echo $threads->id . '-' . h($threads->slug); } else { echo h($threads->slug); } ?>?action=lastpost"><?= $this->Text->truncate(h($threads->title), 75, array('ending' => '...', 'exact' => true)); ?></a> 
              <p>
              <a href="users/profile/<?= h($threads->last_post_uid); ?>"><?= h($username); ?></a>
              <span class="float-right"><?= $this->Text->truncate($this->Time->timeAgoInWords($threads->last_post_date), 18, array('ending' => '...', 'exact' => true)); ?></span>
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
    <?php if($user): ?>
    <div class="heading">
          <h3 class="bevelled">Chatbox</h3>
    </div>
    <div class="main-content">
      <ul class="list-unstyled" id="chatbox">
        <?php foreach($chats as $messages): ?>
          <li><b class="float-left"><?= $messages->username ?></b>: <span class="date float-right"><?php echo $messages->created->format('H:i:s') ?></span><div class="chat"><?= $client->toImage($this->Text->autoLink($messages->body, array('escape' => false))) ?></div></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="card-footer bevelled">
      <div class="form-group">
        <input type="text" id="session" class="form-control" value="<?= $this->request->session()->id(); ?>" style="display:none">
      </div>
      <div class="form-group">
        <label>Message</label>
        <input type="text" id="text" name="text" class="form-control" placeholder="Enter message" autocomplete="off"onkeyup="handleKey(event)" disabled>
        <input type="button" id="send" name="send" value="Send" onclick="send()" style="display: none">
      </div>
      </div>
      <br />
    <?php endif; ?>
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
        <?php $resultstr = array(); ?>
        <?php foreach($roles_home as $role): ?>
        <?php $resultstr[] = $role->name; ?>
        <?php endforeach; ?>
        <span><?= implode(", ",$resultstr); ?></span>
        </p>
        <small>Powered on ForumDirect</small>
      </div>
      <br>
    </div>
    </div>
</div>
