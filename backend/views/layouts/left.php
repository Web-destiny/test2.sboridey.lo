<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Admin</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Список опросов', 'icon' => 'dashboard', 'url' => [\yii\helpers\Url::to('/')]],
                    ['label' => 'Admin Menu', 'options' => ['class' => 'header']],
                    [
                        'label' => 'Опрос цемент',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Города', 'icon' => 'dashboard', 'url' => [\yii\helpers\Url::to('/cement-city/index')],],
                            ['label' => 'Подразделения', 'icon' => 'dashboard', 'url' => [\yii\helpers\Url::to('/cement-departments/index')],],
                            ['label' => 'Руководители', 'icon' => 'dashboard', 'url' => [\yii\helpers\Url::to('/cement-supervisor/index')],],
                                ],
                    ],
//                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
//                    ['label' => 'Debug', 'icon' => 'file-code-o', 'url' => ['/debug']],
//                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                ],
            ]
        ) ?>

    </section>

</aside>
