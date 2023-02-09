<?php

use yii\bootstrap4\ActiveForm;
?>

<script src="https://cdn.ckeditor.com/ckeditor5/35.2.1/super-build/ckeditor.js"></script>


<div class="page-wrap">
    <div class="top-panel">
        <div class="logo">
            <img src="/backend/web/img/idea-logo-white.png" alt="">
        </div>
        <div class="notification-wrap">
            <a href="#">
                <div class="icon active">
                    <img src="/backend/web/img/notification-icon.png" alt="notification">
                </div>
            </a>
            <div class="exit-wrap">
                <a href="<?php echo \yii\helpers\Url::to(['site/logout']) ?>">
                    <div class="exit-icon"></div>
                    <div class="exit-text">
                        Выйти
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="content-wrap">
        <div class="top-nav">
            <div class="nav-back">
                <a href="<?php echo \yii\helpers\Url::to(['/site/index'])  ?>">
                    Все опросы
                </a>
            </div>
        </div>
        <div class="create-pool-wrap">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'form-valid'],
                'fieldConfig' => [
                    'options' => [
                        'tag' => false,
                    ],
                ],
            ]); ?>
            <div class="create-form">
                <div class="form-group">
                    <div class="question">
                        Введите название опроса
                    </div>
                    <div class="input-group">
                        <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'placeholder' => '', 'data-reqired' => 'reqired', 'class' => ''])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="question">
                        Введите описание опроса
                    </div>
                    <div class="input-group">
                        <?= $form->field($model, 'description')->textarea(['autofocus' => true, 'placeholder' => '', 'data-reqired' => 'reqired', 'class' => ''])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="question">
                        Выберите тип опроса
                    </div>
                    <div class="input-group">
                        <?php echo $form->field($model, 'type')->dropdownList(
                            $itemsTypes,
                            ['prompt' => 'Тип опроса', 'class' => 'customselect']
                            // ['prompt'=>'Тип опроса', 'class' => 'customselect', 'options'=>['audio'=>['disabled'=>true]]]
                            //    ['prompt'=>'Тип опроса', 'class' => 'customselect']
                        )->label(false);  ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="question">
                        Добавьте обложку/баннер
                    </div>
                    <div class="input-file">
                        <label>
                            <?= $form->field($model, 'imageFile')->fileInput(['class' => 'add-banner', 'accept' => 'image/png, image/gif, image/jpeg'])->label(false) ?>
                        </label>
                    </div>
                    <div class="img-container"></div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="question">
                            Добавьте файлы для опроса
                        </div>
                        <div class="files-container">
                        </div>
                        <div class="input-check">
                            <label class="switch">
                                <?= $form->field($model, 'is_survey_file')->checkbox(['class' => 'add-exel'])->label(false) ?>
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="input-exel">
                            <label>
                                <?php  // echo $form->field($model, 'is_contact_form')->fileInput(['class' => 'add-pool-files', 'accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'])->label(false) 
                                ?>
                                <input type="file" name="filePool-1" class="add-pool-files" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="question">
                        Использовать стандартную контактную форму
                    </div>
                    <div class="input-check">
                        <label class="switch">
                            <input type="checkbox" name="q-6">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="question">
                        Добавить в конце опроса ссылку на сайт
                    </div>
                    <div class="input-check">
                        <label class="switch">
                            <input type="checkbox" name="q-7" class="show-hidden" data-hidden=".link-hidden">
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="hidden link-hidden">
                        <div class="input-group">
                            <input type="text" name="q-8" class="link-input" placeholder="Введите ссылку">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="question">
                        Включить нумерацию вопросов
                    </div>
                    <div class="input-check">
                        <label class="switch">
                            <input type="checkbox" name="has_numbering"  <?php echo  $model->has_numbering ? "checked" : ''; ?>   class="show-hidden" data-hidden=".link-hidden">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="question">
                        Дополнтельный критерий
                    </div>
                    <div class="input-group">
                        <?= $form->field($model, 'extra')->textInput(['autofocus' => true, 'placeholder' => 'Дополнтельный критерий', 'class' => ''])->label(false) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="question">
                        Дополнтельный критерий 1
                    </div>
                    <div class="input-group">
                        <?= $form->field($model, 'extra1')->textInput(['autofocus' => true, 'placeholder' => 'Дополнтельный критерий 1', 'class' => ''])->label(false) ?>
                    </div>
                </div>
            </div>

            <div class="btn-wrap">
                <button class="btn-submit">
                    Далее
                </button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="popup-wrap file-popup">
    <div class="popup-body">
        <div class="file-row">
            <div class="label">
                Добавьте файл
            </div>
            <div class="file-icon">
                <div class="exel-delete"></div>
            </div>
        </div>
        <div class="btn-wrap">
            <button class="btn-default close-popup">Добавить</button>
        </div>
    </div>
</div>
<div class="load-wrapper">
    <div class="shape">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>
    <div class="bottom-shadow">
        <div class="shape-shadow"></div>
        <div class="shape-shadow"></div>
        <div class="shape-shadow"></div>
    </div>
</div>
<script src="/backend/web/js/custom_select.js"></script>
<script src="/backend/web/js/script.js?876564587"></script>
<script src="/backend/web/js/form-script.js?345345345"></script>

<script>

       ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
       CKEDITOR.ClassicEditor.create(document.querySelector( '#survey-description' ), {
           // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
           toolbar: {
               items: [
                   'exportPDF','exportWord', '|',
                   'findAndReplace', 'selectAll', '|',
                   'heading', '|',
                   'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                   'bulletedList', 'numberedList', 'todoList', '|',
                   'outdent', 'indent', '|',
                   'undo', 'redo',
                   '-',
                   'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                   'alignment', '|',
                   'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                   'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                   'textPartLanguage', '|',
                   'sourceEditing'
               ],
               shouldNotGroupWhenFull: true
           },
           // Changing the language of the interface requires loading the language file using the <script> tag.
           // language: 'es',
           list: {
               properties: {
                   styles: true,
                   startIndex: true,
                   reversed: true
               }
           },
           // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
           heading: {
               options: [
                   { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                   { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                   { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                   { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                   { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                   { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                   { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
               ]
           },
           // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
           placeholder: 'Welcome to CKEditor 5!',
           // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
           fontFamily: {
               options: [
                   'default',
                   'Arial, Helvetica, sans-serif',
                   'Courier New, Courier, monospace',
                   'Georgia, serif',
                   'Lucida Sans Unicode, Lucida Grande, sans-serif',
                   'Tahoma, Geneva, sans-serif',
                   'Times New Roman, Times, serif',
                   'Trebuchet MS, Helvetica, sans-serif',
                   'Verdana, Geneva, sans-serif'
               ],
               supportAllValues: true
           },
           // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
           fontSize: {
               options: [ 10, 12, 14, 'default', 18, 20, 22 ],
               supportAllValues: true
           },
           // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
           // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
           htmlSupport: {
               allow: [
                   {
                       name: /.*/,
                       attributes: true,
                       classes: true,
                       styles: true
                   }
               ]
           },
           // Be careful with enabling previews
           // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
           htmlEmbed: {
               showPreviews: true
           },
           // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
           link: {
               decorators: {
                   addTargetToExternalLinks: true,
                   defaultProtocol: 'https://',
                   toggleDownloadable: {
                       mode: 'manual',
                       label: 'Downloadable',
                       attributes: {
                           download: 'file'
                       }
                   }
               }
           },
           // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
           mention: {
               feeds: [
                   {
                       marker: '@',
                       feed: [
                           '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                           '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                           '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                           '@sugar', '@sweet', '@topping', '@wafer'
                       ],
                       minimumCharacters: 1
                   }
               ]
           },
           // The "super-build" contains more premium features that require additional configuration, disable them below.
           // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
           removePlugins: [
               // These two are commercial, but you can try them out without registering to a trial.
               // 'ExportPdf',
               // 'ExportWord',
               'CKBox',
               'CKFinder',
               'EasyImage',
               // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
               // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
               // Storing images as Base64 is usually a very bad idea.
               // Replace it on production website with other solutions:
               // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
               // 'Base64UploadAdapter',
               'RealTimeCollaborativeComments',
               'RealTimeCollaborativeTrackChanges',
               'RealTimeCollaborativeRevisionHistory',
               'PresenceList',
               'Comments',
               'TrackChanges',
               'TrackChangesData',
               'RevisionHistory',
               'Pagination',
               'WProofreader',
               // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
               // from a local file system (file://) - load this site via HTTP server if you enable MathType
               'MathType'
           ]
       });

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

</script>

<style>
    .ck.ck-editor__main>.ck-editor__editable {
        min-height: 200px;
    }
    b, strong {
        font-weight: bold;
    }
    i {
        font-style: italic;
    }
    h1 {
        display: block;
        font-size: 2em;
        margin-top: 0.67em;
        margin-bottom: 0.67em;
        margin-left: 0;
        margin-right: 0;
        font-weight: bold;
    }
    h2 {
        display: block;
        font-size: 1.5em;
        margin-top: 0.83em;
        margin-bottom: 0.83em;
        margin-left: 0;
        margin-right: 0;
        font-weight: bold;
    }
    h3 {
        display: block;
        font-size: 1.17em;
        margin-top: 1em;
        margin-bottom: 1em;
        margin-left: 0;
        margin-right: 0;
        font-weight: bold;
    }
    p {
        display: block;
        margin-top: 1em;
        margin-bottom: 1em;
        margin-left: 0;
        margin-right: 0;
    }
    ul {
        display: block;
        list-style-type: disc;
        margin-top: 1em;
        margin-bottom: 1 em;
        margin-left: 0;
        margin-right: 0;
        padding-left: 40px;
    }
    ol {
        display: block;
        list-style-type: auto;
        margin-top: 1em;
        margin-bottom: 1 em;
        margin-left: 0;
        margin-right: 0;
        padding-left: 40px;
    }
</style>