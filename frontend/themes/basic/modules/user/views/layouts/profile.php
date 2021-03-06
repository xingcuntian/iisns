<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\themes\basic\modules\user\ProfileAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

ProfileAsset::register($this);

//关注按钮
$done = Yii::$app->db
    ->createCommand("SELECT 1 FROM {{%user_follow}} WHERE user_id=:user_id AND people_id=:id LIMIT 1")
    ->bindValues([':user_id' => Yii::$app->user->id, ':id' => $this->params['user']['id']])->queryScalar();
if ($done) {
    $followBtn = '<span class="glyphicon glyphicon glyphicon-eye-close"></span> ' . Yii::t('app', 'Unfollow');
} else {
    $followBtn = '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('app', 'Follow');
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web') ?>/favicon.ico">
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
      <div class="btn-panel">
        <?= Html::a(Yii::$app->setting->get('siteName'), ['/'], ['class' => 'btn btn-warning']) ?>
      </div>
      <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <div class="row">
          <div class="col-sm-3">
            <img src="<?= Yii::getAlias('@avatar') . $this->params['user']['avatar'] ?>" class="thumbnail img-responsive" alt="user-avatar">
            <div class="panel m-top-md">
              <div class="panel-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <span class="block font-14"><?= $this->params['userData']['following_count'] ?></span><br>
                    <small class="text-muted"><?= Yii::t('app', 'Following') ?></small>
                  </div><!-- /.col -->
                  <div class="col-xs-4 text-center">
                    <span class="block font-14"><?= $this->params['userData']['follower_count'] ?></span><br>
                    <small class="text-muted"><?= Yii::t('app', 'Follower') ?></small>
                  </div><!-- /.col -->
                  <div class="col-xs-4 text-center">
                    <span class="block font-14"><?= $this->params['userData']['post_count'] ?></span><br>
                    <small class="text-muted"><?= Yii::t('app', 'Posts') ?></small>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div>
            </div>
            <?php if (!empty($this->params['profile']['description'])): ?>
              <h5 class="subtitle">About me</h5>
              <p class="mb30"><?= Html::encode($this->params['profile']['description']) ?></p>
            <?php endif ?>
          </div>
          <div class="col-sm-9">
            <div class="profile-header">
              <h2 class="profile-name"><?= Html::a(Html::encode($this->params['user']['username']), ['/user/view', 'id' => Html::encode($this->params['user']['username'])]) ?></h2>
              <div class="profile-location"><i class="glyphicon glyphicon-map-marker"></i> <?= Html::encode($this->params['profile']['address']) ?></div>
              <div class="profile-signature"><i class="glyphicon glyphicon-pushpin"></i> <?= Html::encode($this->params['profile']['signature']) ?></div>
              <div class="mb20"></div>
              <a class="btn btn-success follow" href="<?= Url::toRoute(['/user/user/follow', 'id' => $this->params['user']['id']]) ?>"><?= $followBtn ?></a>
              <a class="btn btn-default"><i class="glyphicon glyphicon-envelope"></i> <?= Yii::t('app', 'Message') ?></a>
            </div>
            <ul class="nav nav-tabs nav-justified nav-profile">
              <li class="active"><a href="#timeline" data-toggle="tab"><strong><i class="glyphicon glyphicon-time"></i> <?= Yii::t('app', 'Timeline') ?></strong></a></li>
              <li class=""><a href="#photo" data-toggle="tab"><strong><i class="glyphicon glyphicon-picture"></i> <?= Yii::t('app', 'Photo') ?></strong></a></li>
<!--               <li class=""><a href="#music" data-toggle="tab"><strong><i class="glyphicon glyphicon-music"></i> Music</strong></a></li>
              <li class=""><a href="#video" data-toggle="tab"><strong><i class="glyphicon glyphicon-facetime-video"></i> Video</strong></a></li> -->
              <li class=""><a href="#profile" data-toggle="tab"><strong><i class="glyphicon glyphicon-user"></i> <?= Yii::t('app', 'Profile') ?></strong></a></li>
            </ul>
            <?= $content ?>
          </div>
        </div>
      </div>
    </div>
    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; iiSNS <?= date('Y') ?>
          <?= Html::a (' 中文简体 ', '?lang=zh-CN') . '| ' . 
            Html::a (' English ', '?lang=en') ;  
          ?>
        </p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
    <?php $this->endBody() ?>
    <script>
      $('.follow').on('click', function() {
          var a = $(this);
          $.ajax({
              url: a.attr('href'),
              success: function(data) {
                  if(data.action == 'create') {
                      a.html('取消关注');
                  } else {
                      a.html('点击关注');
                  }
              },
              error: function (XMLHttpRequest, textStatus) {
                  location.href="<?= Url::toRoute(['/site/login']) ?>";
              }
          });
          return false;
      });
    </script>
</body>
</html>
<?php $this->endPage() ?>