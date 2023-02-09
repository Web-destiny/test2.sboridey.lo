<div class="pools-table-wrap">
    <div class="pools-table">
        <div class="table-head">
            <div class="table-row">
                <div class="table-group">
                    <div class="table-col">
                        Статус
                    </div>
                    <div class="table-col">
                        Название
                    </div>
                    <div class="table-col">
                        Тип рассылки
                    </div>
                    <div class="table-col">
                        Статус <br>
                        рассылки
                    </div>
                    <div class="table-col">
                        Отправлено
                    </div>
                    <div class="table-col">
                        Получено
                    </div>
                    <div class="table-col">
                        Просмотров <br>
                        E-mail
                    </div>
                    <div class="table-col">
                        Перешли <br>
                        по ссылке
                    </div>
                    <div class="table-col">
                        Прошли <br>
                        опрос
                    </div>
                    <div class="table-col">
                        Создание <br>
                        опроса
                    </div>
                    <div class="table-col">
                        Последний <br>
                        ответ
                    </div>
                </div>
                <div class="table-col-menu"></div>
            </div>
        </div>
        <div class="table-body">
            <?php use yii\helpers\Url;

            foreach($surveys as $survey): ?>



                <div class="table-row">
                    <a href="" >
                        <div class="table-col">
                            <label class="switch">
                                <input type="checkbox" <?php echo ($survey->status == 1) ? 'checked' : ''?>   name="q-1">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="table-col pool-name">
                            <?php echo $survey->name; ?>
                        </div>
                        <div class="table-col">
                            Нет данных рассылки
                        </div>
                        <div class="table-col">
                            Нет данных рассылки
                        </div>
                        <div class="table-col">
                            16
                        </div>
                        <div class="table-col">
                            10
                        </div>
                        <div class="table-col">
                            8
                        </div>
                        <div class="table-col">
                            5
                        </div>
                        <div class="table-col">
                            5
                        </div>
                        <div class="table-col">
                            <?php echo  Yii::$app->formatter->asDate($survey->created_at, 'dd-MM-yyyy') ?> <br>
                            <?php echo date('H:i', $survey->updated_at) ?>
                        </div>
                        <div class="table-col">
                            14:05
                        </div>
                    </a>
                    <div class="table-col-menu">
                        <div class="pool-menu-wrap">
                            <div class="menu-icon">
                                <div class="dot"></div>
                                <div class="dot"></div>
                                <div class="dot"></div>
                            </div>
                            <div class="hidden-menu">
                                <div class="menu-wrap">
                                    <div class="menu-list">
                                        <a href="<?php echo Url::to(['site/preview', 'id' => $survey->id]);  ?>" class="menu-item">
                                            <div class="icon">
                                                <div class="icon-watch"></div>
                                            </div>
                                            <div class="text">
                                                Открыть
                                            </div>
                                        </a>
                                        <a href="<?php echo Url::to(['site/constructor', 'id' => $survey->id]);  ?>" class="menu-item">
                                            <div class="icon">
                                                <div class="icon-pen"></div>
                                            </div>
                                            <div class="text">
                                                Редактировать
                                            </div>
                                        </a>
                                        <a href="#" class="menu-item">
                                            <div class="icon">
                                                <div class="icon-duplicate"></div>
                                            </div>
                                            <div class="text">
                                                Дублировать
                                            </div>
                                        </a>
                                        <a href="<?php echo Url::to(['site/index', 'id' => $survey->id, 'published' => 'archive']);  ?>" class="menu-item">
                                            <div class="icon">
                                                <div class="icon-basket"></div>
                                            </div>
                                            <div class="text">
                                                Архивировать
                                            </div>
                                        </a>
                                        <a href="<?php echo Url::to(['site/survey-url', 'id' => $survey->id]);  ?>" class="menu-item">
                                            <div class="icon">
                                                <div class="icon-link"></div>
                                            </div>
                                            <div class="text">
                                                Ссылка респонденту
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>