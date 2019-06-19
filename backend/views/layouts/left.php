<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => Yii::t('app', 'Авторы'), 'icon' => 'user', 'url' => ['author/index']],
                    ['label' => Yii::t('app', 'Книги'), 'icon' => 'book', 'url' => ['book/index']],
//                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
//                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],

                ],
            ]
        ) ?>

    </section>

</aside>
