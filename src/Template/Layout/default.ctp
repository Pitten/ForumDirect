<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        ForumDirect:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('https://fonts.googleapis.com/css?family=Audiowide|Iceland|Monoton|Pacifico|Press+Start+2P|Vampiro+One|Roboto') ?>

    <?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css') ?>
    <?= $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css') ?>

    <?= $this->Html->css('app.css') ?>

    <?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <header class="container">  
        <div class="row">
            <div class="col-md-4 logo">
                <a href="/"><!-- <span class="heading1">D</span> --><span class="heading2">ForumDirect</span></a>
            </div>
            <div class="col-md-8">
                <div class="logreg-info pull-right">
                <?php if (!isset($username)): ?>
                    <a class="register-btn bevelled" href="../users/add"><i class="fa fa-pencil-square-o"></i> <span>Register</span></a>
                    <a class="login-btn bevelled" href="../users/login" data-toggle="tooltip"> <i class="fa fa-lock"></i> <span>Sign in</span></a>
                <?php else: ?>
                    <a class="register-btn bevelled" href="./users/settings"><i class="fa fa-cog"></i> <span>Settings</span></a>
                    <?= $this->Form->postLink(' <i class="fa fa-unlock"></i> <span>Logout</span>', ['controller' => 'users', 'action' => 'logout'], ['escape'   => false, 'class' => 'login-btn bevelled', 'confirm' => __('Are you sure you want to logout?')]) ?>
                <?php endif; ?>   
                </div>           
            </div>
        </div>
    </header>   
    <?= $this->Flash->render() ?>
    <div class="container main-content">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
