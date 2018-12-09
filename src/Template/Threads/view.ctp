<?php use Cake\App\App;
  require_once(ROOT . '/webroot' . DS  . '/ForumDirectParsedown.php');
?>
<?php echo $this->Flash->render(); ?>  

<nav aria-label="Page navigation">
    <ul class="pagination flex-wrap">
        <?php
        $this->Paginator->templates([
            'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
            'prevDisabled' => '<li class="page-item disabled"><a class="page-link" href="{{url}}">{{text}}</a></li>',
            'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
            'current' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
            'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
            'nextDisabled' => '<li class="page-item disabled"><a class="page-link" href="{{url}}">{{text}}</a></li>'
        ]); ?>
        <?= $this->Paginator->prev() ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next() ?>
    </ul>
</nav>

<?php if (!$page): ?>
<?php $username = $this->cell('Forum::getUsername', [$thread->author_id]); ?>
<?php $role = $this->cell('Forum::getRole', [$thread->author_id]); ?>
<div class="row">
    <div class="col-md-12">
      <div class="heading">
        <h3 class="bevelled"><?= h($thread->title) ?></h3>
      </div>
      <div class="main-content">
        <div class="row">
          <div class="col-md-2">
            <div class="text-center">
              <h6><a href="../../users/profile/<?= h($thread->author_id) ?>"><?= h($username) ?></a></h6>
              <img src="<?= h($this->cell('Forum::getAvatar', [$thread->author_id])); ?>" width="120px" height="120px">
              <p>
                <small><?= h($this->cell('Forum::getUserTitle', [$thread->author_id])); ?></small>
                <br>
                <span class="badge badge-default"><?= h($role) ?></span>
              </p>
            </div>
          </div>
          <div class="col-md-10">
            <small class="text-muted"><?= $this->Time->timeAgoInWords($thread->created); ?> <?php if($thread->modified): ?><i>modified: <?= $this->Time->timeAgoInWords($thread->modified); ?></i><?php endif; ?> <div class="float-right"><?php if($this->request->getSession()->read('Auth.User')): ?><a href="../../threads/quote/<?= $thread->id ?>">quote</a><?php endif; ?> <?php if(!$thread->closed && $thread->author_id == $this->request->getSession()->read('Auth.User.id')): ?><a href="../../threads/edit/<?= $thread->id ?>">edit</a><?php elseif($this->request->getSession()->read('Auth.User.role') == 2 || $this->request->getSession()->read('Auth.User.role') == 3): ?><a href="../edit/<?= $thread->id ?>">edit</a><?php endif; ?><?php if($this->request->getSession()->read('Auth.User.role') == 2 || $this->request->getSession()->read('Auth.User.role') == 3): ?> <?php if(!$thread->closed): ?><a href="../threads/close/<?= $thread->id ?>" onclick="return confirm('Are you sure?')">close</a><?php else: ?> <a href="../threads/open/<?= $thread->id ?>" onclick="return confirm('Are you sure?')">open</a> <?php endif; ?><?php endif; ?></div></small>
            <?php 
              $parsedown = new ForumDirectParsedown();
              $source = $parsedown->setMarkupEscaped(true);
            ?>
            <?php echo $source->text("$thread->body"); ?>
          </div>
        </div>

        <br>

        <?php foreach($posts as $row): ?>

        <?php $username = $this->cell('Forum::getUsername', [$row->author_id]); ?>
        <?php $role = $this->cell('Forum::getRole', [$row->author_id]); ?>

        <div class="row">
          <div class="col-md-2">
            <div class="text-center">
              <h6><a href="../../users/profile/<?= h($row->author_id) ?>"><?= h($username) ?></a></h6>
              <img src="<?= h($this->cell('Forum::getAvatar', [$row->author_id])); ?>" width="120px" height="120px">
              <p>
                <small><?= h($this->cell('Forum::getUserTitle', [$row->author_id])); ?></small>
                <br>
                <span class="badge badge-default"><?= h($role) ?></span>
              </p>
            </div>
          </div>
          <div class="col-md-10" id="pid<?= $row->id; ?>">
            <small class="text-muted"><?= $this->Time->timeAgoInWords($row->created); ?> <?php if($row->modified): ?><i>modified: <?= $this->Time->timeAgoInWords($row->modified); ?></i><?php endif; ?> <div class="float-right"><?php if($this->request->getSession()->read('Auth.User')): ?><a href="../../posts/quote/<?= $row->id ?>">quote</a><?php endif; ?> <?php if(!$thread->closed && $row->author_id == $this->request->getSession()->read('Auth.User.id')): ?><a href="../../posts/edit/<?= $row->id ?>">edit</a><?php elseif($this->request->getSession()->read('Auth.User.role') == 2 || $this->request->getSession()->read('Auth.User.role') == 3): ?><a href="../posts/edit/<?= $row->id ?>">edit</a><?php endif; ?></div></small>
            <?php 
              $parsedown = new ForumDirectParsedown();
              $source = $parsedown->setMarkupEscaped(true);
            ?>
            <?php echo $source->text("$row->body"); ?>
          </div>
        </div>
        <br>

        <?php endforeach; ?>

        <?php else: ?>

        <div class="row">
        <div class="col-md-12">
        <div class="heading">
            <h3 class="bevelled"><?= h($thread->title) ?></h3>
        </div>
        <div class="main-content">

        <?php foreach($posts as $row): ?>

        <?php $username = $this->cell('Forum::getUsername', [$row->author_id]); ?>
        <?php $role = $this->cell('Forum::getRole', [$row->author_id]); ?>

        <div class="row">
          <div class="col-md-2">
            <div class="text-center">
              <h6><a href="../../users/profile/<?= h($row->author_id) ?>"><?= h($username) ?></a></h6>
              <img src="<?= h($this->cell('Forum::getAvatar', [$row->author_id])); ?>" width="120px" height="120px">
              <p>
                <small><?= h($this->cell('Forum::getUserTitle', [$row->author_id])); ?></small>
                <br>
                <span class="badge badge-default"><?= h($role) ?></span>
              </p>
            </div>
          </div>
          <div class="col-md-10" id="pid<?= $row->id; ?>">
            <small class="text-muted"><?= $this->Time->timeAgoInWords($row->created); ?> <?php if($row->modified): ?><i>modified: <?= $this->Time->timeAgoInWords($row->modified); ?></i><?php endif; ?> <div class="float-right"><?php if($this->request->getSession()->read('Auth.User')): ?><a href="../../posts/quote/<?= $row->id ?>">quote</a><?php endif; ?> <?php if(!$thread->closed && $row->author_id == $this->request->getSession()->read('Auth.User.id')): ?><a href="../../posts/edit/<?= $row->id ?>">edit</a><?php elseif($this->request->getSession()->read('Auth.User.role') == 2 || $this->request->getSession()->read('Auth.User.role') == 3): ?><a href="../posts/edit/<?= $row->id ?>">edit</a><?php endif; ?></div></small>
            <?php 
              $parsedown = new ForumDirectParsedown();
              $source = $parsedown->setMarkupEscaped(true);
            ?>
            <?php echo $source->text("$row->body"); ?>
          </div>
        </div>
        <br>

        <?php endforeach; ?>

        <?php endif; ?>

        <?php if (isset($user) && !$thread->closed): ?>

        <div class="heading">
            <h3 class="bevelled">Quick reply</h3>
        </div>
        <div class="main-content">
         <?php echo $this->Form->create('post', ['url' => 'threads/post/' . $thread->id . '']); ?>
         <div class="form-group">
         <?php echo $this->Form->control('body', ['rows' => '4', 'class' => 'form-control']); ?>
         </div>
         <?php echo $this->Form->button(__('Save post') , ['class' => 'btn bevelled']); ?>
         <?php echo $this->Form->end(); ?>
        </div>
        <?php elseif(!$thread->closed): ?>
    	<div class="alert alert-info"><span>Please <a href="../../users/add">register</a> or <a href="../../users/login?redirect=%2Fthreads%2Fview%2F<?= h($thread->id) ?>">login</a> to post a reply to this thread.</span>
    	</div>
        <?php endif; ?>
        <?php if($thread->closed): ?>
        <div class="alert alert-danger">This topic is closed.</div>
        <?php endif; ?>
    </div>
</div>