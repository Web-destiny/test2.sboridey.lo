jQuery.noConflict();

import {
    showChaptersList,
    addChapter,
    hasChapter,
    deleteChapter,
    addQuestionToChapter,
    addChaptersSettingsSelectOption,
    setChaptersSettingsSelectNames,
    updateChapterQuestionsIndex,
    updateChaptersIndex,
    generatePopupChapters,
    closeChaptersPopup,
    moveChapterOnArrowClick,
    changeNameInput
} from "./chapters.js"
import {
    setQustionSortable,
    setChapterSortable,
    setChaptersSortableInModal,
    setQustionsSortableInChapter
} from "./controller/sortable.controller.js?89411532423409823"
import {
    generateQestionTypeElement,
} from "./constants/el-generator.js?8953153242340983419"
import {
    addedQuestion,
} from "./constants/added-question-generator.js"
import {
    addScalePicture,
    addScaleDiapason,
    setRangeBackground,
    setDiapasonValue,
    setDiapasonMax,
    setClassForScale,
    addScaleRate,
    addNPSscaleRate,
    changeAmountLabel,
    changeNPSamountLabel,
    createNpsOptionBlock,
    createScaleOptionBlock,
    createNpsOption,
    createScaleOption,
    apdateNpsOptionScale,
    checkNpsDiapason,
    checkScaleDiapason,
    scaleFreeAnswer,
    npsFreeAnswer,
    removeNpsOption,
    removeScaleOption,
    refreshNpsElemNames,
    refreshScaleElemNames,
} from "./scale-nps-functions.js"
import {
    setSortbaleRanging,
    refreshRangeId,
} from "./ranging-functions.js"
import {
    addMatrixRow,
    addMatrixCol,
    removeMatrixCol,
    removeMatrixRow,
    refreshMatrixID,
} from "./matrix-functions.js"
import {
    setNewText,
    addListDropdownQuestion,
    addNewOption,
    removeDropdownOption,
    refreshDropdownInputs,
    createDropdownOptionBlock,
    createSelectOfDropdownAnswer,
    createDropdownOption,
    removeDropdownOptionBlock,
    refreshDropdownElemNames,
    moveToQuestionFromDropdown,
    moveToChapterFromDropdown,
    hideQuestionFromDropdown,
    askAditionalQuestionFromDropdown,
    completePollFromDropdown,
    createDropdownMultipleBlock,
    countOfDropdownAnswer,
    checkDropdownDiapason,
    hideChapterFromDropdown,
} from "./dropdown-functions.js"
import {
    addSingleOption,
    addSingleAlternative,
    refreshAlternativesItemIndexes,
    removeSingleOption,
    addListSingleQuestion,
    refreshSingleOptionsId,
    setSortbaleSingleItems,
    createSingleOptionBlock,
    createSingleOption,
    createSelectOfSingleAnswer,
    removeSingleOptionBlock,
    refreshSingleElemNames,
    moveToQuestionFromSingle,
    moveToChapterFromSingle,
    hideQuestionFromSingle,
    askAditionalQuestionFromSingle,
    completePollFromSingle,
    createSingleMultipleBlock,
    countOfSingleAnswer,
    checkSingleDiapason,
    removeAnswerImgSingle,
    hideChapterFromSingle,
    createSingleChoiceToHide,
    removeSingleChoiceBlock,
    createSingleOptionChoice,
    removeSingleChoiceOption,
    refreshSingleChoiceElemNames,
    createSelectOfSingleQuestionsForHide,
    clearSelectStyledHideQuestions,
    insertValueToHiddenInput,
    refreshListAnswersForQuestionsHide,
    updateValueToHiddenInputs,
    clearBeforeRefreshHiddenInput,
    getListAnswersForQuestionsHide,
} from "./single-functionsss.js"

jQuery(document).ready(function () {
    //function for autoresize textarea
    $.fn.autoResize = function () {
        let r = e => {
            e.style.height = '';
            e.style.height = e.scrollHeight + 'px'
        };
        return this.each((i, e) => {
            e.style.overflow = 'hidden';
            r(e);
            $(e).bind('input', e => {
                r(e.target);
            })
        })
    };
    //local settings for datepicker
    $.datepicker.setDefaults({
        closeText: vars.CloseE,
        prevText: '',
        currentText: vars.TodayE,
        monthNames: [vars.January, vars.February, vars.March, vars.April, vars.May, vars.June,  vars.July, vars.August, vars.September, vars.October, vars.November, vars.December],
        monthNamesShort: [vars.Jan, vars.Feb, vars.Mar, vars.Apr, vars.MayE, vars.JuneE, vars.JulyE, vars.Aug, vars.Sept, vars.Oct, vars.Nov, vars.Dec],
        dayNames: [vars.Sunday, vars.Monday, vars.Tuesday, vars.Wednesday, vars.Thursday, vars.Friday, vars.Saturday],
        dayNamesShort: [vars.SuE, vars.MoE, vars.TuE, vars.WeE, vars.ThE, vars.FrE, vars.SaE],
        dayNamesMin: [vars.Su, vars.Mo, vars.Tu, vars.We, vars.Th, vars.Fr, vars.Sa],
        weekHeader: 'Не',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    });

    // Restricts input for the set of matched elements to the given inputFilter function.
    $.fn.inputFilter = function (inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
        });
    };

    //create unique ID
    function getUniqueID() {
        return Date.now().toString(36) + Math.random().toString(36).substr(2);
    }
    //auto height for textarea
    // $('.questions-box textarea').autoResize();
    //activation filter
    $('.content-wrap').on('change', '.filter-item select', function (e) {
        $(this).parents('.filter-item').addClass('picked');
    });
    //change mode view
    $('.content-wrap').on('click', '.mode-view', function (e) {
        if ($(this).hasClass('mode-full') && !$(this).hasClass('active')) {
            $('.listbox').removeClass('icons-mode');
            $('.mode-view.mode-icons').removeClass('active');
            $(this).addClass('active');
        } else if ($(this).hasClass('mode-icons') && !$(this).hasClass('active')) {
            $('.listbox').addClass('icons-mode');
            $('.mode-view.mode-full').removeClass('active');
            $(this).addClass('active');
        }
    });

    //set height for question-box
    setHeightBox();

    function setHeightBox() {
        let box = $('.questions-box');
        let viewHeight = window.innerHeight;
        let panelHeight = $('.top-panel').outerHeight(true);
        let wrapPad = 40;
        let navHeight = $('.top-nav').outerHeight(true);
        let filterHeiht = $('.add-chapter-wrap').outerHeight(true);
        let boxHeight = parseInt(viewHeight - panelHeight - wrapPad - navHeight - filterHeiht);
        box.height(boxHeight + 'px');
    }
    $(window).resize(function () {
        $('.questions-box textarea').autoResize();
        setHeightBox();
    });

    //actions with question
    //sortable questions
    if ($(window).width() > 700) {
        const onEnd = (evt) => {
            let questionsList = $(evt.target);
            refreshQuestionsId(questionsList);
        };
        setQustionSortable(onEnd);
    }


    //show chapters list

    //drag chapter
    $('.add-chapter-wrap .add-chapter').draggable({
        helper: 'clone',
        cursor: 'move',
        connectToSortable: '.questions-box',
        containment: '.constr-wrap',
    });

    //drag question
    $('.listbox .list-item').draggable({
        helper: 'clone',
        cursor: 'move',
        connectToSortable: '.chapter-questions-list',
        containment: '.constr-wrap',
    });

    let fakeInput = '<input type="number" name="fakeInput" class="fakeInput" value="0" hidden>';
    $('.questions-list').append(fakeInput);

    let elements = []

    //dropped question
    $('.questions-box').droppable({
        drop: function (event, ui) {
            if ($(ui.draggable).hasClass('list-item')) {
                var eventTop = event.pageY;
                var offsetY = event.offsetY;
                var children = $('.questions-box').find('.questions-list').children();
                var appendInde = getAppendIndex(children, eventTop, offsetY);
                var type = $(ui.draggable).attr('data-type');
                let id = 1;
                if (hasChapter) {
                    let uniqueId = getUniqueID();
                    const {
                        chapterIndex,
                        chapterQuestionIndex
                    } = getIndexOfDroppableQuestionInChapter(eventTop);

                    let el = generateQestionTypeElement(type, chapterQuestionIndex + 1, uniqueId, chapterIndex + 1);
                    if (chapterIndex !== undefined && chapterQuestionIndex !== undefined) {
                        addQuestionToChapter(el, chapterIndex, chapterQuestionIndex);
                        let allChoices = $('.single-option-choice .single-action .select-options .active')
                        if(allChoices[0]){
                            clearBeforeRefreshHiddenInput()
                            $(allChoices).each(function () {
                                updateValueToHiddenInputs($(this))
                            })
                        }else{
                            clearBeforeRefreshHiddenInput()
                        }

                    }
                    if (type == 'ranging') {
                        setSortbaleRanging();
                    }
                    if (type == 'single') {
                        setSortbaleSingleItems();
                    }
                    if (type == "single") {
                        addListSingleQuestion.call($(el))
                        createSelectOfSingleQuestionsForHide.call($(el))
                    }
                    if (type == "dropdown") {
                        addListDropdownQuestion.call($(el))
                    }
                    let currentCahpter = ($('.chapter-wrapper')[chapterIndex]);
                    $(currentCahpter).find('.chapter-error').remove();
                    $(currentCahpter).find('.chapter-head').removeClass('has-error');
                    customSelectActive();
                } else {

                    if (appendInde === 'last') {
                        id = children.length + 1;
                    } else if (appendInde < 0) {
                        id = 1;
                    } else {
                        makeFakeChapter()
                        id = appendInde + 1;

                    }
                    if (type && id) {
                        // addQuestion(type, appendInde, id);
                        // const onEnd = (evt) => {
                        //     let questionsList = $(evt.target);
                        //     refreshQuestionsId(questionsList);
                        // };
                        // setQustionSortable(onEnd);


                        let uniqueId = getUniqueID();
                        const {
                            chapterIndex,
                            chapterQuestionIndex
                        } = getIndexOfDroppableQuestionInChapter(eventTop);

                        let el = generateQestionTypeElement(type, chapterQuestionIndex + 1, uniqueId, chapterIndex + 1);
                            addQuestionToChapter(el, chapterIndex, chapterQuestionIndex);
                    }
                }
            }
            //dropped chapter
            if ($(ui.draggable).hasClass('add-chapter')) {
                let detectQuestionsLenth = $('.question-wrap').length;
                const insertIndex = $(event.toElement).hasClass('chapter-wrapper') ?
                    $(event.toElement).attr('data-index') :
                    $(event.toElement).parents('.chapter-wrapper').attr('data-index');
                addChapter(insertIndex, detectQuestionsLenth);
                customSelectActive();
                setSortbaleRanging();
                setSortbaleSingleItems();
                $('.chapter-position-btn').fadeIn();
            }
        }
    });

    function makeFakeChapter(){
        let detectQuestionsLenth = $('.question-wrap').length;
        const insertIndex = $(event.toElement).hasClass('chapter-wrapper') ?
            $(event.toElement).attr('data-index') :
            $(event.toElement).parents('.chapter-wrapper').attr('data-index');
        addChapter(insertIndex, detectQuestionsLenth);
        customSelectActive();
        setSortbaleRanging();
        setSortbaleSingleItems();
        $('.chapter-head').attr('hidden', true)
        $('.chapter-wrapper .chapter-questions-list').css({'padding-left': '0'})
        $('.fakeInput').attr('value', 1)
    }

    // if chapter-list > 0 set chapter-position-btn to visible
    if ($('.chapter-wrapper').length > 0) {
        $('.chapter-position-btn').fadeIn();
        setSortbaleRanging();
        setChapterSortable();
        let sortableWrapperList = $('.chapter-questions-list')
        for (let i = 0; i < sortableWrapperList.length; i++) {
            setQustionsSortableInChapter($(sortableWrapperList[i])[0])
        }
    }

    //get index of dropable question
    function getAppendIndex(arr, top, offsetY) {
        if (arr.length === 0) {
            return 'last';
        } else {
            for (var i = 0; i < arr.length; i++) {
                var elTop = $(arr[i]).offset().top,
                    elBottom = $(arr[i]).offset().top + $(arr[i]).outerHeight(true),
                    height = $(arr[i]).outerHeight(true);
                if (top > elTop + height / 2 && top < elBottom + offsetY) {
                    return i;
                } else if (top > elTop && top < elBottom) {
                    return (i - 1);
                }
            }
            return arr.length - 1;
        }
    }
    //get index of dropable chapter
    function getChapterIndex(top) {
        const $chaptersList = $('.chapter-wrapper');
        let chapterIndex;
        $chaptersList.each((index, chapter) => {
            const $chapter = $(chapter);
            const chapterTop = $chapter.offset().top;
            const chapterBot = $chapter.offset().top + $chapter.outerHeight(true);
            if (chapterTop < top && chapterBot > top) {
                chapterIndex = index;
            }
        });

        return chapterIndex;
    }

    function getIndexOfDroppableQuestionInChapter(top) {
        const chapterIndex = getChapterIndex(top);
        const $chapter = $($('.chapter-wrapper')[chapterIndex]);
        const $chaptersQuestionsList = $chapter.find('.chapter-questions-list .question-wrap');

        let chapterQuestionIndex;
        if ($chaptersQuestionsList.length) {
            $chaptersQuestionsList.each((index, chapterQuestion) => {
                const $chapterQuestion = $(chapterQuestion);
                const chapterQuestionTop = $chapterQuestion.offset().top;
                const chapterQuestionBot = $chapterQuestion.offset().top + $chapterQuestion.outerHeight(true);


                const chapterQuestionHalfHeight = $chapterQuestion.outerHeight(true) / 2;
                // console.log(chapterQuestionHalfHeight, chapterQuestionHalfHeight + chapterQuestionHalfHeight);

                if (chapterQuestionTop < top && chapterQuestionBot > top) {
                    chapterQuestionIndex = (chapterQuestionTop + chapterQuestionHalfHeight) > top ?
                        index :
                        index + 1;
                }
            });
        } else {
            chapterQuestionIndex = 0;
        }

        return {
            chapterIndex,
            chapterQuestionIndex
        };
    }

    //add question by click
    $('.constr-wrap').on('click', '.listbox .list-item', function (e) {
        if(!$('.questions-list .chapter-wrapper').length){
            makeFakeChapter()
        }
        let type = $(this).attr('data-type');
        let appendInde = "last";
        let id = hasChapter ?
            $('.questions-list').find('.chapter-wrapper').last().find('.chapter-questions-list').children().length + 1 :
            $('.questions-box').find('.questions-list').children().length;
        let chapterIndex = hasChapter ? $('.questions-list').find('.chapter-wrapper').length : undefined;
        let currentCahpter = ($('.chapter-wrapper')[chapterIndex - 1]);
        $(currentCahpter).find('.chapter-error').remove();
        $(currentCahpter).find('.chapter-head').removeClass('has-error');
        addQuestion(type, appendInde, id, chapterIndex);
        if ($('.questions-box').find('.questions-list .question-wrap').length > 1) {
            const onEnd = (evt) => {
                let questionsList = $(evt.target);
                refreshQuestionsId(questionsList);
            };
            setQustionSortable(onEnd);
        }
    });
    //add chapter by click
    $('.constr-wrap').on('click', '.add-chapter-wrap .add-chapter', function (event) {
        let detectQuestionsLenth = $('.question-wrap').length;
        const insertIndex = $(event.toElement).hasClass('chapter-wrapper') ?
            $(event.toElement).attr('data-index') :
            $(event.toElement).parents('.chapter-wrapper').attr('data-index');
        addChapter(insertIndex, detectQuestionsLenth);
        customSelectActive();
        addChaptersSettingsSelectOption();
        $('.chapter-wrapper .chapter-name-textarea').autoResize();
        $('.chapter-position-btn').fadeIn();
        setSortbaleRanging();
    });
    /** Show popup with chapters */
    $('.constr-wrap').on('click', '.add-chapter-wrap .chapter-position-btn', function () {
        generatePopupChapters();
    });

    /** Move chapter in popup */
    $('body').on('click', '.move-arrows-wrapper .move-arrow', function () {
        let currentCahpter = $(this).closest('.chapters-list__item');
        const oldIndex = $(currentCahpter).attr('data-index') * 1;
        const $arrow = $(this);
        moveChapterOnArrowClick(currentCahpter, $arrow, oldIndex);
    });

    /** Close chapters popup */
    $('.chapters-list-container .chapters-list__popup-close').on('click', function () {
        closeChaptersPopup();
    });

    /** Removing chapters */
    $('.constr-wrap').on('click', '.remove-chapter', function () {
        const $chapter = $(this).parents('.chapter-wrapper');
        deleteChapter($chapter);
        createSelectOfSingleQuestionsForHide()
        if ($('.chapter-wrapper').length === 0) {
            $('.chapter-position-btn').fadeOut();
            $('.questions-box').addClass('empty');
        }
    });

    /** add question to list */
    function addQuestion(type, appendInde, id, chapterIndex) {
        console.log("click")
        let children = $('.questions-box').find('.questions-list').children();
        let uniqueId = getUniqueID();
        let el = generateQestionTypeElement(type, id, uniqueId, chapterIndex);
        let scrollTo = 0;

        if (hasChapter) {
            addQuestionToChapter(el);
        } else {
            if (appendInde === 'last') {
                $('.questions-box').find('.questions-list').append(el);
                scrollTo = $('.questions-box').find('.questions-list .question-wrap:last-child').offset().top;

            } else if (appendInde < 0) {
                $('.questions-box').find('.questions-list').prepend(el);
                scrollTo = $('.questions-box').find('.questions-list .question-wrap:first-child').offset().top;
            } else {
                $(children[appendInde]).after(el);
                scrollTo = $(children[appendInde]).offset().top;
            }
        }
        $('.questions-box').removeClass('empty');
        $('.questions-box textarea').autoResize();
        customSelectActive();
        //scroll to element
        let container = $('.questions-box');
        container.scrollTop(
            scrollTo - container.offset().top + container.scrollTop()
        );
        if (type == "ranging") {
            setSortbaleRanging();
        }
        if (type == "date") {
            setDatePicker();
        }
        if (type == "phone") {
            //set pick phone code
            $('.question-phone input.code').intlTelInput({
                initialCountry: "ua",
            });
        }
        if (type == "single") {
            setSortbaleSingleItems();
        }
        refreshQuestionsId();
        if (type == "single") {
            addListSingleQuestion.call($(el))
            createSelectOfSingleQuestionsForHide.call($(el))
        }
        if (type == "dropdown") {
            addListDropdownQuestion.call($(el))
        }
        setTimeout(() => {
            questionInFocus();
        }, 500);

    }

    /** Style question when it in focus */
    function questionInFocus() {
        let question = $('.question-new');
        let questionName = question.find('.question-name textarea');
        questionName.focus();
        question.removeClass('question-new');
    }

    //uneditable numbers in question name
    $('.constr-wrap').on('keypress, keydown', '.question-name textarea', function () {
        let $field = $(this);
        let value = $field.val().split('.');
        if (value.length > 0 && $.isNumeric(value[0])) {
            let readOnlyLength = value[0].length + 1;
            if ((event.which != 37 && (event.which != 39)) &&
                (
                    (this.selectionStart < readOnlyLength) ||
                    ((this.selectionStart == readOnlyLength) && (event.which == 8))
                )
            ) {
                return false;
            }
        }
    });

    //show settings for question and chapter
    $('.constr-wrap').on('click', '.show-settings', function () {
        console.log("settings")
        let question = $(this).parents('.question-wrap');
        let chapter = $(this).parents('.chapter-wrapper');
        if ($(this).hasClass('active')) {
            if ($(this).hasClass('show-chapter-setting')) {
                chapter.find('.chapter-settings').fadeOut(300);
            } else {
                $(question[0]).find('.question-settings').fadeOut(300);
            }
            $(this).removeClass('active');
        } else {
            if ($(this).hasClass('show-chapter-setting')) {
                chapter.find('.chapter-settings').fadeIn(300);
            } else {
                $(question[0]).find('.question-settings').fadeIn(300);
            }
            $(this).addClass('active');
            if ($(question[0]).hasClass('nps-question-scale')) {
                customSelectActive();
            } else {
                return
            }
        }
    });

    //show eyes-hidden func

    $('.constr-wrap').on('change', '.control-panel .question-visability input[type="checkbox"]', function () {
        let targetQuestionDataID = $(this).closest('.question-wrap').find('.question-name textarea').attr('name')
        if(targetQuestionDataID == 'question_1_1'){
            $(this).prop('checked', false)
        }
       if($(this).is(':checked')){
           $(this).closest('.question-wrap').find('.question-view-hide').fadeIn(300);
       }else{
           $(this).closest('.question-wrap').find('.question-view-hide').fadeOut(300);
       }
    });

    // $('.constr-wrap').on('change', '.question-view-hide .single-option-choice select', function () {
    //    refreshAnswersForSingleQuestionsForHide()
    // });


    // question in focus
    $('.constr-wrap').on('click', '.question-wrap', function (e) {
        if (!$(e.target).hasClass('remove-question')) {
            if (!$(this).hasClass('focus')) {
                $('.constr-wrap .question-wrap').removeClass('focus');
                $(this).addClass('focus');
            }
        }
    });

    //remove question
    $('.constr-wrap').on('click', '.question-wrap .remove-question', function () {
        let question = $(this).parents('.question-wrap');
        if ($('.chapter-questions-list').children().length == 1 ){
            const $chapter = $('.chapter-wrapper');
            deleteChapter($chapter);
            if ($('.chapter-wrapper').length === 0) {
                $('.questions-box').addClass('empty');
            }
            $('.fakeInput').attr('value', 0)
        }
        removeQuestion(question);
        createSelectOfSingleQuestionsForHide()
        clearSelectStyledHideQuestions()
        let allChoices = $('.single-option-choice .single-action .select-options .active')
        if($('.chapter-questions-list').children().length > 1){
            clearBeforeRefreshHiddenInput()
            $(allChoices).each(function () {
                updateValueToHiddenInputs($(this))
            })
        }else{
            clearBeforeRefreshHiddenInput()
        }

    });


    // main function to remove question
    function removeQuestion(question) {
        if (hasChapter) {
            let chapter = $(question).parents('.chapter-wrapper');
            $(question).remove();
            updateChapterQuestionsIndex(chapter);
        } else {
            $(question).remove();
            if ($('.questions-list').children('.question-wrap').length === 0) {
                $('.questions-box').addClass('empty');
            } else {
                refreshQuestionsId();
            }
        }
    }

    //copy question
    $('.constr-wrap').on('click', '.question-wrap .copy-question', function () {
        let $question = $(this).parents('.question-wrap');
        const $copiedQuestion = $question.clone();
        $copiedQuestion.insertAfter($question);
        if (hasChapter) {
            let chapter = $question.parents('.chapter-wrapper');
            updateChapterQuestionsIndex(chapter);
        } else {
            refreshQuestionsId();
        }
        $(this).parents('.question-wrap').find('.copy-message').fadeIn();

        function hideCopyMessage() {
            $question.find('.copy-message').fadeOut();
        }
        setTimeout(hideCopyMessage(), 2500);
    });

    //events for files

    //upload img
    $('.constr-wrap').on('change', '.file-img input[type=file]', function (e) {
        let input = this;
        let question = $(this).parents('.question-wrap');
        if (input.files && input.files[0]) {
            let fileWrap = question.find('.added-file-wrap');
            if (fileWrap.length === 0) {
                let wrapHtml = '<div class="added-file-wrap"></div>';
                $(wrapHtml).insertAfter(question.find('.question-name'));
                fileWrap = question.find('.added-file-wrap');
            } else {
                fileWrap.html('');
            }
            let imgHtml =
                `<div class="img-wrap">
                    <img src="" alt="Img">
                    <div class="img-remove"></div>
                </div>`;
            $(imgHtml).appendTo(fileWrap);
            let img = question.find('.added-file-wrap img');
            var reader = new FileReader();
            reader.onload = function (e) {
                img.attr('src', e.target.result);
                setFileActive(input);
            };
            reader.readAsDataURL(input.files[0]);
        }
    });

    //upload audio
    $('.constr-wrap').on('change', '.file-audio input[type=file]', function (e) {
        let question = $(this).parents('.question-wrap');
        let fileWrap = question.find('.added-file-wrap');
        let input = this;
        let inputFile = e.target;
        if (inputFile.files && inputFile.files[0]) {
            if (fileWrap.length === 0) {
                let wrapHtml = '<div class="added-file-wrap"></div>';
                $(wrapHtml).insertAfter(question.find('.question-name'));
                fileWrap = question.find('.added-file-wrap');
            } else {
                fileWrap.html('');
            }
            let audioHtml =
                `<div class="audio-wrap">
                    <div class="audio-control"></div>
                    <div class="audiowave" data-audiopath=""></div>
                    <div class="audio-duration"></div>
                    <div class="audio-remove"></div>
                </div>`;
            $(audioHtml).appendTo(fileWrap);

            let audio = question.find('.added-file-wrap .audiowave');
            audio.stop();
            var reader = new FileReader();
            reader.onload = function (e) {
                audio.attr('data-audiopath', e.target.result);
                setAudioWave(audio[0], e.target.result);
                setFileActive(input);
            };
            reader.readAsDataURL(inputFile.files[0]);
        }
    });

    //upload video
    $('.constr-wrap').on('change', '.file-video input[type=file]', function (e) {
        let question = $(this).parents('.question-wrap');
        let input = this;
        if (this.files && this.files[0]) {
            let fileWrap = question.find('.added-file-wrap');
            if (fileWrap.length === 0) {
                let wrapHtml = '<div class="added-file-wrap"></div>';
                $(wrapHtml).insertAfter(question.find('.question-name'));
                fileWrap = question.find('.added-file-wrap');
            } else {
                fileWrap.html('');
            }
            let videoHtml =
                `<div class="video-wrap">
                    <video-radio-star>
                        <video>
                            <source src="./files-for-test/video.mp4">
                            Your browser does not support HTML5 video.
                        </video>
                        <button type="button" class="video-play" data-play></button>
                    </video-radio-star>
                    <div class="video-remove"></div>
                </div>`;
            $(videoHtml).appendTo(fileWrap);
            let source = fileWrap.find('source');
            source[0].src = URL.createObjectURL(this.files[0]);
            setFileActive(input);
        }
    });

    $('.constr-wrap').on('click', '.video-wrap video', function (e) {
        e.preventDefault();
        let videoWrap = $(this).parent();
        let video = videoWrap.find('video').get(0);
        if (video.paused) {
            $(video).prop('controls', true);
            video.play();
        } else {
            video.pause();
            $(video).prop('controls', false);
        }
    });

    //set active type of file
    function setFileActive(input) {
        let question = $(input).parents('.question-wrap');
        if ($(input).parents('.file-video').length === 0) {
            clear_form_elements(question.find('.file-video'));
            question.find('.file-video label').removeClass('active');
        }
        if ($(input).parents('.file-audio').length === 0) {
            clear_form_elements(question.find('.file-audio'));
            question.find('.file-audio label').removeClass('active');
        }
        if ($(input).parents('.file-img').length === 0) {
            clear_form_elements(question.find('.file-img'));
            question.find('.file-img label').removeClass('active');
        }
        $(input).parents('.file-item').find('label').addClass('active');
        $(input).parents('.attach-file').find('.attach-file-icon').addClass('active');
    }

    //remove img
    $('.constr-wrap').on('click', '.question-wrap .img-remove', function (e) {
        removeFile(this);
    });
    //remove audio
    $('.constr-wrap').on('click', '.question-wrap .audio-remove', function (e) {
        removeFile(this);
    });
    //remove video
    $('.constr-wrap').on('click', '.question-wrap .video-remove', function (e) {
        removeFile(this);
    });

    //remove file
    function removeFile(el) {
        let question = $(el).parents('.question-wrap');
        let fileWrap = question.find('.added-file-wrap');
        fileWrap.remove();
        clear_form_elements(question.find('.attach-files-wrap'));
        question.find('.attach-files-wrap label').removeClass('active')
        $(question).find('.attach-file-icon').removeClass('active');
    }
    //end events for files

    //settings for single question
    //!------------------------------------------------------------------------------------------------------------

    //single input point in focus
    $('.content-wrap').on('focus', '.question-single .radio-item textarea', function (e) {
        $(this).parents('.radio-item').addClass('focus');
    });

    //single input point out of focus
    $('.content-wrap').on('blur', '.question-single .radio-item textarea', function (e) {
        $(this).parents('.radio-item').removeClass('focus');
    });

    //add new single item
    $('.content-wrap').on('change', '.question-single .input-single-item', function (e) {
        let text = $(this).val();
        if (text) {
            let thisQuestion = $(this).parents('.question-wrap');
            let itemsList = $(thisQuestion[0]).find('.radio-btns-wrapper');
            let alternativesList = $(thisQuestion[0]).find('.list-alternatives');
            let questionId = $(thisQuestion[0]).attr('data-id');
            let pointId = itemsList.children().length + 1;
            if (questionId && pointId && text && itemsList) {
                addSingleOption(questionId, pointId, text, itemsList);
                addSingleAlternative(questionId, pointId, alternativesList);
                addListSingleQuestion()
            }
            clear_form_elements($(this).parents('.input-new-item-wrap'));
            createSelectOfSingleAnswer($(thisQuestion[0]))
            countOfSingleAnswer($(thisQuestion[0]))
            refreshListAnswersForQuestionsHide(thisQuestion)
        }
    });

    $('.content-wrap').on('keyup', '.question-single .radio-item textarea', function (e) {
        $(this).text($(this).val())
        let question = $(this).parents('.question-wrap');
        refreshListAnswersForQuestionsHide(question)
    });

    // Add options to chapter Settings Select
    $('.content-wrap').on('keyup', '.chapter-wrapper .chapter-name-textarea', function (e) {
        const chapter = $(this).parents('.chapter-wrapper');
        const chapterName = $(this).val();
        setChaptersSettingsSelectNames(chapter, chapterName);
    });

    //click out of input single option
    $(document).click(function (event) {
        var $target = $(event.target);
        if (!$target.hasClass('input-single-item')) {
            $('.input-single-item').change();
        }
    });
    //click enter to add single item
    $(document).on('keypress', function (e) {
        if (e.which == 13) {
            if ($(e.target).hasClass('input-single-item')) {
                e.preventDefault();
                $(e.target).change();
            }
        }
    });

    // remove single item and alternatives item
    $('.content-wrap').on('mousedown', '.question-single .radio-item .remove-item', function (e) {
        let $this = $(this)
        let thisQuestion = $this.parents('.question-wrap')
        let itemEl = $this.parents('.radio-item');
        let idItemEl = $this.parents('.radio-item').find('textarea').attr('name').split('_')
        let alternativesList = $this.parents('.question-content').find('.list-alternatives .alternatives-item')
        alternativesList.each(function (id, el) {
            let alternativesListItem = $(el).find('input').attr('name').split('_')
            if (idItemEl[idItemEl.length - 1] == alternativesListItem[alternativesListItem.length - 1]) {
                el.remove()
            }
        })
        refreshAlternativesItemIndexes(itemEl)
        removeSingleOption(itemEl);
        createSelectOfSingleAnswer(thisQuestion)
        countOfSingleAnswer(thisQuestion)
        refreshListAnswersForQuestionsHide(thisQuestion)
    });

    //change visability for single option
    $('.content-wrap').on('mousedown', '.question-single .radio-item .radio-item-visability', function (e) {
        let $this = $(this)
        let curentIDLength = $this.parent().find('textarea').attr('name').split('_').length
        let curentID = $this.parent().find('textarea').attr('name').split('_')[curentIDLength - 1]
        $this.toggleClass('active')
        $this.parent().toggleClass('focus')

        $this.parents('.radio-btns-wrapper').find('.radio-item').each(function (id, el) {
            let $radioThis = $(this)
            let radioCurentIDLength = $radioThis.find('textarea').attr('name').split('_').length
            let radioCurentID = $radioThis.find('textarea').attr('name').split('_')[radioCurentIDLength - 1]
            if (radioCurentID != curentID) {
                $radioThis.find('.radio-item-visability').removeClass('active')
                $radioThis.removeClass('focus')
            }
        })

        $this.parents('.question-content').find('.list-alternatives .alternatives-item').each(function (id, el) {
            let alternativesListItem = $(el).find('input').attr('name').split('_')
            if (alternativesListItem[alternativesListItem.length - 1] == curentID) {
                if ($this.hasClass('active')) {
                    $(this).fadeIn(200);
                } else {
                    $(this).fadeOut(200);
                }
            } else {
                $(this).fadeOut(200);
            }
        })
    });

    //after change name for question rename options for alternative selector
    $('.content-wrap').on('change', '.questions-list .question-single textarea', function (e) {
        addListSingleQuestion()
    })

    // рефреш select-styled и li в списке hide вопросов при изменении названия вопроса
    $('.content-wrap').on('change', '.questions-list .question-wrap .question-name textarea', function (e) {
        let nameTextarea = $(this).attr('name')
        let textForUpdate = $(this).prev().text() + $(this).val()
        let currentLi = $('.questions-list .question-wrap .single-answer .select-options li')
        currentLi.each(function () {
            if($(this).attr('name') == nameTextarea){
                $(this).text(textForUpdate)
                if($(this).hasClass('active')){
                    let currentSpan = $(this).parent().prev()
                    currentSpan.text(textForUpdate)
                }
            }
        })
    })

    // кладу номер вопроса для скрытия в инпут (армена) по выбору в селекте
    $('.content-wrap').on('click', '.questions-list .question-wrap .single-action li', function () {
        insertValueToHiddenInput($(this))
    })

    //get list of answer form target question
    $('.content-wrap').on('click', '.questions-list .question-single .single-inputpoint-customselect-question li', function (e) {
        let targetQuestion = $('.questions-list').find(`.question-single[data-id=${$(this).data('id')}]`)
        let listAnswer = targetQuestion.find('.radio-btns-wrapper .radio-item textarea')
        let targetAnswerSelect = $(this).parents('.alternatives-item').find('.single-inputpoint-customselect-answer')
        let select = targetAnswerSelect.find('select')
        let customSelect = targetAnswerSelect.find('.select-options')
        select.html("")
        customSelect.html("")
        listAnswer.each(function (id, el) {
            let answerText = $(el).val()
            let createdOption = `<option value="${answerText}">${answerText}</option>`;
            let createdLi = `<li rel="${answerText}">${answerText}</li>`;
            select.append(createdOption)
            customSelect.append(createdLi)
        })
    })

    // слушатель на лист ответов вопросов в функции "eye-hide" для сингла
    $('.content-wrap').on('click', '.questions-list .question-wrap .single-answer li', function (e) {
        let targetQuestion = $('.questions-list').find(`.question-wrap[data-id=${$(this).data('id')}]`)
        if(targetQuestion.hasClass('question-single')){
            let listAnswer = targetQuestion.find('.radio-btns-wrapper .radio-item textarea')
            let targetAnswerSelect = $(this).parents('.single-option-choice').find('.single-action')
            getListAnswersForQuestionsHide(targetAnswerSelect, listAnswer)
        }else if(targetQuestion.hasClass('question-dropdown')){
            let listAnswer = targetQuestion.find('.dropdown-wrap .select-options li')
            let targetAnswerSelect = $(this).parents('.single-option-choice').find('.single-action')
            getListAnswersForQuestionsHide(targetAnswerSelect, listAnswer)
        }
    })

    //show single options add other or comment
    $('.content-wrap').on('change', '.question-wrap .show-hidden-opt', function (e) {
        if ($(this).is(':checked')) {
            $(this).parents('.switch-group').find('.hidden-options').fadeIn(300);
        } else {
            $(this).parents('.switch-group').find('.hidden-options').fadeOut(300);
            clear_form_elements($(this).parents('.switch-group').find('.hidden-options'));
        }
    });

    //add single option other
    $('.content-wrap').on('change', '.question-single .add-other', function (e) {
        let thisQuestion = $(this).parents('.question-wrap');
        let itemsList = $(thisQuestion[0]).find('.radio-btns-wrapper');
        let questionId = $(thisQuestion[0]).attr('data-id');
        let pointId = itemsList.children().length + 1;
        let text = vars.drugoe;
        if ($(this).is(':checked')) {
            addSingleOption(questionId, pointId, text, itemsList, 'other');
        } else {
            let removeEl = itemsList.find('.other');
            removeSingleOption(removeEl);
        }
    });
    //add single option comment
    $('.content-wrap').on('change', '.question-single .add-comment', function (e) {
        let thisQuestion = $(this).parents('.question-wrap');
        if ($(this).is(':checked')) {
            let commnetHtml =
                '<div class="option-comment">' +
                `    <textarea rows="1" placeholder="${vars.vvediteVashComment}"></textarea>` +
                '</div>';
            $(commnetHtml).insertBefore($(thisQuestion[0]).find('.input-new-item-wrap'));
        } else {
            $(thisQuestion[0]).find('.option-comment').remove();
        }
    });
    //add single option neither
    $('.content-wrap').on('change', '.question-single .add-neither', function (e) {
        let thisQuestion = $(this).parents('.question-wrap');
        let itemsList = $(thisQuestion[0]).find('.radio-btns-wrapper');
        let questionId = $(thisQuestion[0]).attr('data-id');
        let pointId = itemsList.children().length + 1;
        let text = vars.nichegoIzVishePerechislenogo;
        if ($(this).is(':checked')) {
            addSingleOption(questionId, pointId, text, itemsList, 'neither');
        } else {
            let removeEl = itemsList.find('.neither');
            removeSingleOption(removeEl);
        }
    });

    setSortbaleSingleItems();
    setChaptersSortableInModal();

    $('.content-wrap').on('click', '.question-single .radio-btns-wrapper textarea', function (e) {
        $(this).parent('.radio-item').addClass('inFocus');
        $(this).parent('.radio-item').find('textarea').focus();
    });

    $('.content-wrap').on('blur', '.question-single .radio-btns-wrapper textarea', function (e) {
        $(this).parent('.radio-item').removeClass('inFocus');
    });

    // Create single option
    $('.content-wrap').on('change', '.question-single .add-single-option', function () {
        let question = $(this).parents('.question-wrap');
        let singleName = question.attr('data-id');
        if ($(this).is(':checked')) {
            createSingleOptionBlock(question, singleName);
        } else {
            question.find('.single-options-box').remove();
            //question.find('.question-content .free-answers').remove();
        }
    });

    $('.content-wrap').on('change', '.question-wrap .question-view-hide .add-single-choice', function () {
        let question = $(this).parents('.question-wrap');
        let singleName = question.attr('data-id');
        if ($(this).is(':checked')) {
            createSingleChoiceToHide(question, singleName);
            createSelectOfSingleQuestionsForHide(question)
        } else {
            // let selectedLi = $(this).closest('.single-choice-row').next().find('.select-options .active')
            // removeValuesInHideInputs(selectedLi)

            setTimeout(() => {
                let allChoices = $('.single-option-choice .single-action .select-options .active')
                if($('.chapter-questions-list').children().length > 1){
                    clearBeforeRefreshHiddenInput()
                    $(allChoices).each(function () {
                        updateValueToHiddenInputs($(this))
                    })
                }else{
                    clearBeforeRefreshHiddenInput()
                }
            }, 0 )

            question.find('.single-options-box-choice').remove();
            //question.find('.question-content .free-answers').remove();
        }
    });

    /** Changing selects actions in single question */
    $('.content-wrap').on('change', '.question-single .single-action-select', function () {
        let question = $(this).parents('.question-wrap');
        let targetOption = $(this).parents('.single-option')
        const singleAction = $(this).val();

        /** Validate select */
        if (singleAction != '') {
            targetOption.find('.single-to-question-select').remove()
            targetOption.find('.single-to-chapter-select').remove()
            targetOption.find('.single-hide-question-select').remove()
            targetOption.find('.single-ask-additional-question-select').remove()
            targetOption.find('.single-complete-poll').remove()
            targetOption.find('.single-hide-chapter-select').remove()
        }

        /** Validate select */
        if (singleAction == 'move-to-question') {
            if (!targetOption.find('.single-to-question-select').length) {
                moveToQuestionFromSingle(question, targetOption)
            }
        } else {
            targetOption.find('.single-to-question-select').remove()
        }
        if (singleAction == 'move-to-chapter') {
            if (!targetOption.find('.single-to-chapter-select').length) {
                moveToChapterFromSingle(question, targetOption)
            }
        } else {
            targetOption.find('.single-to-chapter-select').remove()
        }
        if (singleAction == 'hide-question') {
            if (!targetOption.find('.single-hide-question-select').length) {
                hideQuestionFromSingle(question, targetOption)
            }
        } else {
            targetOption.find('.single-hide-question-select').remove()
        }
        if (singleAction == 'hide-chapter') {
            if (!targetOption.find('.single-hide-chapter-select').length) {
                hideChapterFromSingle(question, targetOption)
            }
        } else {
            targetOption.find('.single-hide-chapter-select').remove()
        }
        if (singleAction == 'ask-additional-question') {
            if (!targetOption.find('.single-ask-aditional-question').length) {
                askAditionalQuestionFromSingle(question, targetOption)
            }
        } else {
            targetOption.find('.single-ask-aditional-question').remove()
            targetOption.find('.added-question-box').remove()
        }
        if (singleAction == 'complete-poll') {
            if (!targetOption.find('.single-complete-poll').length) {
                completePollFromSingle(question, targetOption)
            }
        } else {
            targetOption.find('.single-complete-poll').remove()
        }
    })

    /** Changing selects type of question for addaditionat question in single question */
    $('.content-wrap').on('change', '.question-single .ask-aditional-question', function () {
        let question = $(this).parents('.question-wrap');
        let targetOption = $(this).parents('.single-option')
        const questionType = $(this).val();
        if (questionType == "") {
            targetOption.find('.added-question-box').html("")
        } else {
            targetOption.find('.added-question-box').html(addedQuestion(question, targetOption, questionType))
            if (questionType == 'free-answer' || questionType == 'scale' || questionType == 'nps' || questionType == 'dropdown' || questionType == 'date') {
                customSelectActive()
            }
            if (questionType == "ranging") {
                setSortbaleRanging();
            }
            if (questionType == "phone") {
                $('.question-phone input.code').intlTelInput({
                    initialCountry: "ua",
                });
            }
        }
    })

    /** Add one more single choice */
    $('.content-wrap').on('click', '.question-wrap .question-view-hide .add-new-single-choice', function () {
        //let singleNameIndex = 1;
        let question = $(this).parents('.question-wrap');
        let singleOptionName = question.attr('data-id');
        const singleOptionsCount = $(this).closest('.single-option-choice').find('.single-answer .single-answer-select option').length;
        const newSingleOptionsCount = question.find('.single-option-choice').length;
        createSingleOptionChoice(question, singleOptionName, singleOptionsCount, newSingleOptionsCount);
        createSelectOfSingleQuestionsForHide(question)
    });

    /** remove single choice */
    $('.content-wrap').on('click', '.question-wrap .remove-single-choice', function () {
        const question = $(this).parents('.question-wrap');
        const singleOption = $(this).closest('.single-option-choice');
        const singleOptionsCount = question.find('.single-options-box-choice .single-option-choice').length;

        // let selectedLi = $(this).prev().find('.select-options .active')
        // removeValuesInHideInputs(selectedLi)
        setTimeout(() => {
            let allChoices = $('.single-option-choice .single-action .select-options .active')
            if($('.chapter-questions-list').children().length > 1){
                clearBeforeRefreshHiddenInput()
                $(allChoices).each(function () {
                    updateValueToHiddenInputs($(this))
                })
            }else{
                clearBeforeRefreshHiddenInput()
            }
        }, 0 )

        removeSingleChoiceOption(question, singleOption, singleOptionsCount)
        refreshSingleChoiceElemNames(question);
    });

    function removeValuesInHideInputs (selectedLi){
        $(selectedLi).each(function () {
            let nameLi = $(this).attr('name')
            let allInputs = $('.questions-list .radio-item textarea, .questions-list .question-dropdown .option-item .inputpoint-body input')
            $(allInputs).each(function () {
                let nameTextarea = $(this).attr('name')
                if (nameLi == nameTextarea) {
                    if($(this).parent().hasClass('radio-item')){
                        $(this).parent('.radio-item').find('.hide-element__input input').attr('value', '')
                    }else if($(this).parent().hasClass('value')){
                        $(this).closest('.option-item').find('.hide-element__input input').attr('value', '')
                    }
                }
            })
        });
    }

    /** Add one more single option */
    $('.content-wrap').on('click', '.question-single .add-new-single-option', function () {
        //let singleNameIndex = 1;
        let question = $(this).parents('.question-wrap');
        let singleOptionName = question.attr('data-id');
        const singleOptionsCount = $(this).closest('.single-option').find('.single-answer .single-answer-select option').length;
        const newSingleOptionsCount = question.find('.single-option').length;
        createSingleOption(question, singleOptionName, singleOptionsCount, newSingleOptionsCount);
    });

    /** remove single option */
    $('.content-wrap').on('click', '.question-single .remove-single-option', function () {
        const question = $(this).parents('.question-wrap');
        const singleOption = $(this).closest('.single-option');
        const singleOptionsCount = question.find('.single-options-box .single-option').length;
        removeSingleOptionBlock(question, singleOption, singleOptionsCount);
        refreshSingleElemNames(question);
    });

    //several answer options
    $('.content-wrap').on('change', '.question-single .multiple-answers', function () {
        let question = $(this).parents('.question-wrap');
        //let singleName = question.attr('data-id');
        if ($(this).is(':checked')) {
            createSingleMultipleBlock($(question[0]));
        } else {
            $(question[0]).find('.single-multiple-box').remove();
            //question.find('.question-content .free-answers').remove();
        }
    });

    $('.content-wrap').on('change', '.question-single .single-multiple-box select', function () {
        let question = $(this).parents('.question-wrap');
        checkSingleDiapason($(question[0]));
    });

    $('.constr-wrap').on('change', '.question-single .radio-item .radio-item-upload-img input[type=file]', function (e) {
        let input = this;
        let answer = $(this).parents('.radio-item');
        if (input.files && input.files[0]) {
            let fileWrap = $(answer[0]).find('.added-question-img-wrap');
            $(input).parent().find('label').addClass('active')
            if (fileWrap.length === 0) {
                let wrapHtml = '<div class="added-question-img-wrap"></div>';
                $(answer[0]).append(wrapHtml)
                fileWrap = $(answer[0]).find('.added-question-img-wrap');
            } else {
                fileWrap.html('');
            }
            let imgHtml =
                `<div class="img-wrap">
                    <img src="" alt="Img">
                    <div class="img-remove"></div>
                </div>`;
            $(imgHtml).appendTo(fileWrap);
            let img = $(answer[0]).find('.added-question-img-wrap img');
            var reader = new FileReader();
            reader.onload = function (e) {
                img.attr('src', e.target.result);
                setFileActive(input);
            };
            reader.readAsDataURL(input.files[0]);
        }
    });

    //remove img single
    $('.constr-wrap').on('click', '.question-single .radio-item .added-question-img-wrap .img-remove', function (e) {
        $(this).parents('.radio-item').find('.radio-item-upload-img label').removeClass('active')
        clear_form_elements($(this).parents('.radio-item').find('.radio-item-upload-img'));
        removeAnswerImgSingle(this);
    });

    //end settings for single question
    //!------------------------------------------------------------------------------------------------------------

    //settings for scale question
    //!------------------------------------------------------------------------------------------------------------
    //TODO
    //change type of scale
    $('.content-wrap').on('change', '.question-scale .scale-type', function (e) {
        let question = $(this).parents('.question-wrap');
        let type = $(this).val();
        if (type === 'diapason') {
            if ($(question[0]).find('diapason'.length === 0)) {
                addScaleDiapason($(question[0]));
                setDiapasonMax($(question[0]));
            }
        } else {
            if ($(question[0]).find('diapason'.length !== 0)) {
                addScalePicture($(question[0]));
            }
            setClassForScale($(question[0]));
        }
    });

    $('.content-wrap').on('input', '.question-wrap .input-range', function (e) {
        setDiapasonValue(this);
    });

    //set width for input range background
    setRangeBackground();

    $(window).resize(function () {
        setRangeBackground();
    });

    //change amount of ratings
    $('.content-wrap').on('change', '.question-scale .scale-amount', function (e) {
        let question = $(this).parents('.question-wrap');
        let amount = $(this).val();

        if (question[0].classList.contains('nps-question-scale')) {

            // amount = parseInt(amount) + 1;
            amount = parseInt(amount);
            apdateNpsOptionScale(amount, $(question[0]));

            if ($(question[0]).find('.diapason-answer').length !== 0) {
                setDiapasonMax($(question[0]));
            } else {
                let scaleWrap = $(question[0]).find('.scale-wrap');
                let questionId = $(question[0]).attr('data-id');

                addNPSscaleRate(scaleWrap, amount, questionId, $(question[0]));
                setClassForScale($(question[0]));
                changeNPSamountLabel($(question[0]));
            }
        } else {

            if (amount === 'yesNot') {
                amount = 2;
            } else {
                amount = parseInt(amount);
            }

            if ($(question[0]).find('.diapason-answer').length !== 0) {
                setDiapasonMax($(question[0]));
            } else {
                let scaleWrap = $(question[0]).find('.scale-wrap');
                let questionId = $(question[0]).attr('data-id');

                addScaleRate(scaleWrap, amount, questionId);
                setClassForScale($(question[0]));
                changeAmountLabel($(question[0]));
            }
        }
    });

    //add\remove labels under rate
    $('.content-wrap').on('change', '.question-scale .add-rateLabels', function (e) {
        let question = $(this).parents('.question-wrap');
        if ($(this).is(':checked')) {
            let labelsScale = `<div class="scale-labels-wrap"></div>`;
            let labelsOption = `<div class="labels-option"></div>`;
            if ($(question[0]).find('.scale-labels-wrap').length === 0) {
                $(labelsScale).insertAfter($(question[0]).find('.scale-wrap'));
            }
            if ($(question[0]).find('.labels-option').length === 0) {
                $(labelsOption).insertAfter($(this).parents('.switch-row'));
            }
            changeAmountLabel($(question[0]));
            setClassForScale($(question[0]));
        } else {
            $(question[0]).find('.scale-labels-wrap').remove();
            $(question[0]).find('.labels-option').remove();
        }
    });

    /* add\remove labels under NPS rate */
    $('.content-wrap').on('change', '.question-scale .add-nps-rateLabels', function (e) {
        let question = $(this).parents('.question-wrap');
        if ($(this).is(':checked')) {
            let labelsScale = `<div class="scale-labels-wrap"></div>`;
            let labelsOption = `<div class="labels-option"></div>`;
            if ($(question[0]).find('.scale-labels-wrap').length === 0) {
                $(labelsScale).insertAfter($(question[0]).find('.scale-wrap'));
            }
            if ($(question[0]).find('.labels-option').length === 0) {
                $(labelsOption).insertAfter($(this).parents('.switch-row'));
            }
            changeNPSamountLabel($(question[0]));
            setClassForScale($(question[0]));
        } else {
            $(question[0]).find('.scale-labels-wrap').remove();
            $(question[0]).find('.labels-option').remove();
        }
    });


    /** Create NPS option */
    $('.content-wrap').on('change', '.question-scale .addNpsOption', function () {
        let question = $(this).parents('.question-wrap');
        let npsOptionName = question.attr('data-id');
        let npsScale = question.find('.scale-options select');
        let npsScaleCount = npsScale[0].value;
        if ($(this).is(':checked')) {
            createNpsOptionBlock(question, npsOptionName, npsScaleCount);
        } else {
            question.find('.nps-options-box').remove();
            question.find('.question-content .free-answers').remove();
        }
    });

    // Create scale option
    $('.content-wrap').on('change', '.question-scale .add-scale-option', function () {
        let question = $(this).parents('.question-wrap');
        let scaleName = question.attr('data-id');
        let scaleScale = question.find('.scale-options select');
        let scaleCount = scaleScale[0].value;
        if ($(this).is(':checked')) {
            createScaleOptionBlock(question, scaleName, scaleCount);
        } else {
            question.find('.scale-options-box').remove();
            //question.find('.question-content .free-answers').remove();
        }

    });

    //add one more scale option
    $('.content-wrap').on('click', '.question-scale .add-new-scale-option', function () {
        let question = $(this).parents('.question-wrap');
        let scaleOptionName = question.attr('data-id');
        let scaleScale = question.find('.scale-options select');
        let scaleCount = scaleScale[0].value;
        const scaleOptionsCount = $(this).closest('.scale-option').find('.scale-action-box select option').length;
        const newScaleOptionsCount = question.find('.scale-option').length;
        createScaleOption(question, scaleOptionName, scaleCount, scaleOptionsCount, newScaleOptionsCount);
    });

    /** Add one more NPS option */
    $('.content-wrap').on('click', '.question-scale .add-new-option', function () {
        let npsNameIndex = 0;
        let question = $(this).parents('.question-wrap');
        let npsOptionName = question.attr('data-id');
        let npsScale = question.find('.scale-options select');
        let npsScaleCount = npsScale[0].value;
        const npsOptionsCount = $(this).closest('.nps-option').find('.nps-action-box select option').length;
        const newNpsOptionsCount = question.find('.nps-option').length;
        createNpsOption(question, npsOptionName, npsNameIndex, npsOptionsCount, newNpsOptionsCount, npsScaleCount);
    });

    let globalIncorrectOptionsList = [];

    $('.content-wrap').on('change', '.nps-question-scale .nps-diapason-box select', function () {
        let question = $(this).parents('.question-wrap');
        checkNpsDiapason(question, globalIncorrectOptionsList);
        if (globalIncorrectOptionsList.length > 0) {
            $(this).attr('data-required', '');
            $(this).val('');
        }
        if (globalIncorrectOptionsList.length == 0 && $(this).val() != '') {
            $(this).removeAttr('data-required', '');
            $(this).parents('.select').find('.select-styled').removeClass('has-error');
        } else {
            $(this).attr('data-required', '');
        }
    });

    $('.content-wrap').on('change', '.question-scale .scale-diapason-box select', function () {
        let question = $(this).parents('.question-wrap');
        checkScaleDiapason(question);
    });

    /** Changing selects in nps question */
    $('.content-wrap').on('change', '.question-scale .select-nps-action', function () {
        let question = $(this).parents('.question-wrap');
        const npsAction = $(this).val();
        let allActions = question.find('.select-nps-action');
        let actionsNames = [];
        for (let i = 0; i < allActions.length; i++) {
            let actionValue = allActions[i].value;
            actionsNames.push(actionValue);
        }
        /** Validate select */
        if (npsAction != '') {
            $(this).removeAttr('data-required', '');
            $(this).parents('.select').find('.select-styled').removeClass('has-error');
        } else {
            $(this).attr('data-required', '');
        }
        // Comment showing settings
        if (npsAction == 'add_free_answer') {
            npsFreeAnswer(question);
        } else if (npsAction == 'finish_survey' && actionsNames.includes("add_free_answer")) {
            actionsNames = [];
            return
        } else {
            $(question).find('.free-answers').remove();
        }
    })

    /** Changing selects in scale question */
    $('.content-wrap').on('change', '.question-scale .select-scale-action', function () {
        let question = $(this).parents('.question-wrap');
        const scaleAction = $(this).val();

        /** Validate select */
        if (scaleAction != '') {
            $(question).find('.free-answers').remove();
        }
        // Comment showing settings
        if (scaleAction == 'add_free_answer') {
            scaleFreeAnswer(question);
        } else {
            $(question).find('.free-answers').remove();
        }
    })

    $('.content-wrap').on('click', '.question-scale .remove-nps-option', function () {
        const question = $(this).parents('.question-wrap');
        const npsOption = $(this).closest('.nps-option');
        const npsOptionsCount = question.find('.nps-options-box .nps-option').length;
        removeNpsOption(question, npsOption, npsOptionsCount);
        refreshNpsElemNames(question);
    });

    $('.content-wrap').on('click', '.question-scale .remove-scale-option', function () {
        const question = $(this).parents('.question-wrap');
        const scaleOption = $(this).closest('.scale-option');
        const scaleOptionsCount = question.find('.scale-options-box .scale-option').length;
        removeScaleOption(question, scaleOption, scaleOptionsCount);
        refreshScaleElemNames(question);
    });

    //input scale label
    $('.content-wrap').on('input', '.question-scale .label-item input[type=text]', function (e) {
        let question = $(this).parents('.question-wrap');
        let labelsWrap = $(question[0]).find('.scale-labels-wrap');
        let questionId = $(question[0]).attr('data-id');
        let text = $(this).val();
        let optionId = $(this).parents('.label-item').index() + 1;
        labelsWrap.find(`.label-item:nth-child(${optionId})`).html(text);
    });

    //TODO
    //end settings for scale question
    //!------------------------------------------------------------------------------------------------------------

    //settings for dropdown question
    //TODO dropdown question
    //!------------------------------------------------------------------------------------------------------------

    //input option for dropdown
    $('.content-wrap').on('input', '.question-dropdown .option-item input[type=text]', function (e) {
        let newText = $(this).val();
        let question = $(this).parents('.question-wrap');
        let optionId = parseInt($(this).parents('.option-item').index()) + 1;
        if (newText && $(question[0]) && optionId) {
            setNewText($(question[0]), newText, optionId);
        }
        if (newText && optionId === $(question[0]).find('.optins-list').children().length) {
            addNewOption($(question[0]));
        }
    });

    $('.content-wrap').on('change', '.question-dropdown .option-item input[type=text]', function (e) {
        let newText = $(this).val();
        let question = $(this).parents('.question-wrap');
        let optionId = parseInt($(this).parents('.option-item').index()) + 1;
        let newOptionId = parseInt($(this).parents('.option-item').index()) + 1;
        if (!newText && optionId !== $(this).parents('.optins-list').children().length) {
            removeDropdownOption($(question[0]), newOptionId);
        }
        createSelectOfDropdownAnswer($(question[0]))
        countOfDropdownAnswer($(question[0]))
        refreshListAnswersForQuestionsHide(question)
    })

    //remove option from select on X click
    $('.content-wrap').on('click', '.question-dropdown .option-item .remove-dropdown-el', function (e) {
        if ($(this).parents('.optins-list').find('.option-item').length < 2) {
            return
        }
        let question = $(this).parents('.question-wrap');
        let optionListItems = $(question[0]).find('.optins-list input');
        let optionId = parseInt($(this).parents('.option-item').index()) + 1;
        if (optionListItems.length > 1) {
            removeDropdownOption($(question[0]), optionId);
        } else if (optionListItems.length == 1) {
            $(this).parents('.value').find('input').val('');
            console.log($(this).parents('.value').find('input').val(''))
            $(question[0]).find('.select-styled').text('');
        }
        countOfDropdownAnswer($(question[0]))
        refreshListAnswersForQuestionsHide(question)
    })

    $('.content-wrap').on('click', '.question-dropdown .option-item .watch-options', function (e) {
        $(this).toggleClass('active')
        if ($(this).hasClass('active')) {
            $(this).parents('.option-item').find('.inputpoint-visability').fadeIn(200);
        } else {
            $(this).parents('.option-item').find('.inputpoint-visability').fadeOut(200);
        }
    })

    //after change name for question rename options for alternative selector
    $('.content-wrap').on('change', '.questions-list .question-dropdown textarea', function (e) {
        addListDropdownQuestion()
    })

    //get list of answer form target question
    $('.content-wrap').on('click', '.questions-list .question-dropdown .inputpoint-customselect-question li', function (e) {
        let targetQuestion = $('.questions-list').find(`.question-dropdown[data-id=${$(this).data('id')}]`)
        let listAnswer = targetQuestion.find('.dropdown-wrap option')
        listAnswer.splice(listAnswer.length - 1, 1)
        let targetAnswerSelect = $(this).parents('.inputpoint-visability').find('.inputpoint-customselect-answer')
        let select = targetAnswerSelect.find('select')
        let customSelect = targetAnswerSelect.find('.select-options')
        select.html("")
        customSelect.html("")
        listAnswer.each(function (id, el) {
            let answerText = $(el).val()
            let createdOption = `<option value="${answerText}">${answerText}</option>`;
            let createdLi = `<li rel="${answerText}">${answerText}</li>`;
            select.append(createdOption)
            customSelect.append(createdLi)
        })
    })

    //add other option to select
    $('.content-wrap').on('change', '.question-dropdown .add-other', function (e) {
        let question = $(this).parents('.question-wrap');
        let text = vars.drugoe;
        if ($(this).is(':checked')) {
            addNewOption($(question[0]), 'other-option', text, false);
            refreshDropdownInputs($(question[0]).find('.optins-list'));
        } else {
            let index = $(question[0]).find('.optins-list').find('.other-option').index() + 1;
            removeDropdownOption($(question[0]), index);
        }
        countOfDropdownAnswer($(question[0]))
    });

    //add neither option to select
    $('.content-wrap').on('change', '.question-dropdown .add-neither', function (e) {
        let question = $(this).parents('.question-wrap');
        let text = vars.nichegoIzVishePerechislenogo;
        if ($(this).is(':checked')) {
            addNewOption($(question[0]), 'neither-option', text, false);
            refreshDropdownInputs($(question[0]).find('.optins-list'));
        } else {
            let index = $(question[0]).find('.optins-list').find('.other-option').index() + 1;
            removeDropdownOption($(question[0]), index);
        }
        countOfDropdownAnswer($(question[0]))
    });

    //make dropdown multiple
    $('.content-wrap').on('click', '.question-dropdown .make-multiple', function (e) {
        let question = $(this).parents('.question-wrap');
        let selectWrap = $(question[0]).find('.customselect-wrapper');
        if ($(this).is(':checked')) {
            selectWrap.addClass('customselect-multiple');
            selectWrap.find('select').attr('multiple', 'multiple');
            selectWrap.find('.select-styled').html(`<div class="default">${vars.viberiteOnvet}</div>`);
            createDropdownMultipleBlock($(question[0]));
        } else {
            selectWrap.removeClass('customselect-multiple');
            selectWrap.find('select').removeAttr('multiple');
            $(question[0]).find('.dropdown-multiple-box').remove();
        }
        selectWrap.find('.select-options li.active').click();
    });

    //add to dropdown  comment
    $('.content-wrap').on('change', '.question-dropdown .add-comment', function (e) {
        let question = $(this).parents('.question-wrap');
        if ($(this).is(':checked')) {
            let commentHtml =
                `<div class="option-comment">
                    <textarea rows="1" placeholder="${vars.vvediteVashComment}"></textarea>
                </div>`
            $(commentHtml).insertAfter($(question[0]).find('.dropdown-wrap'));
        } else {
            $(question[0]).find('.option-comment').remove();
        }
    });

    // Create dropdown option
    $('.content-wrap').on('change', '.question-dropdown .add-dropdown-option', function () {
        let question = $(this).parents('.question-wrap');
        let dropdownName = question.attr('data-id');
        if ($(this).is(':checked')) {
            createDropdownOptionBlock(question, dropdownName);
        } else {
            question.find('.dropdown-options-box').remove();
        }
    });

    /** Add one more dropdown option */
    $('.content-wrap').on('click', '.question-dropdown .add-new-dropdown-option', function () {
        let question = $(this).parents('.question-wrap');
        let dropdownOptionName = question.attr('data-id');
        const dropdownOptionsCount = $(this).closest('.dropdown-option').find('.dropdown-answer .dropdown-answer-select option').length;
        const newDropdownOptionsCount = question.find('.dropdown-option').length;
        createDropdownOption(question, dropdownOptionName, dropdownOptionsCount, newDropdownOptionsCount);
    });

    /** remove dropdown option */
    $('.content-wrap').on('click', '.question-dropdown .remove-dropdown-option', function () {
        const question = $(this).parents('.question-wrap');
        const dropdownOption = $(this).closest('.dropdown-option');
        const dropdownOptionsCount = question.find('.dropdown-options-box .dropdown-option').length;
        removeDropdownOptionBlock(question, dropdownOption, dropdownOptionsCount);
        refreshDropdownElemNames(question);
    });

    /** Changing selects actions in dropdown question */
    $('.content-wrap').on('change', '.question-dropdown .dropdown-action-select', function () {
        let question = $(this).parents('.question-wrap');
        let targetOption = $(this).parents('.dropdown-option')
        const dropdownAction = $(this).val();
        console.log(dropdownAction)

        /** Validate select */
        if (dropdownAction != '') {
            targetOption.find('.dropdown-to-question-select').remove()
            targetOption.find('.dropdown-to-chapter-select').remove()
            targetOption.find('.dropdown-hide-question-select').remove()
            targetOption.find('.dropdown-ask-aditional-question').remove()
            targetOption.find('.dropdown-complete-poll').remove()
            targetOption.find('.dropdown-hide-chapter-select').remove()
        }

        /** Validate select */
        if (dropdownAction == 'move-to-question') {
            if (!targetOption.find('.dropdown-to-question-select').length) {
                moveToQuestionFromDropdown(question, targetOption)
            }
        } else {
            targetOption.find('.dropdown-to-question-select').remove()
        }
        if (dropdownAction == 'move-to-chapter') {
            if (!targetOption.find('.dropdown-to-chapter-select').length) {
                moveToChapterFromDropdown(question, targetOption)
            }
        } else {
            targetOption.find('.dropdown-to-chapter-select').remove()
        }
        if (dropdownAction == 'hide-question') {
            if (!targetOption.find('.dropdown-hide-question-select').length) {
                hideQuestionFromDropdown(question, targetOption)
            }
        } else {
            targetOption.find('.dropdown-hide-question-select').remove()
        }
        if (dropdownAction == 'hide-chapter') {
            if (!targetOption.find('.dropdown-hide-chapte-select').length) {
                hideChapterFromDropdown(question, targetOption)
            }
        } else {
            targetOption.find('.dropdown-hide-chapte-select').remove()
        }
        if (dropdownAction == 'ask-additional-question') {
            if (!targetOption.find('.dropdown-ask-aditional-question').length) {
                askAditionalQuestionFromDropdown(question, targetOption)
            }
        } else {
            targetOption.find('.dropdown-ask-aditional-question').remove()
        }
        if (dropdownAction == 'complete-poll') {
            if (!targetOption.find('.dropdown-complete-poll').length) {
                completePollFromDropdown(question, targetOption)
            }
        } else {
            targetOption.find('.dropdown-complete-poll').remove()
        }
    })

    /** Changing selects type of question for addaditionat question in dropdown question */
    $('.content-wrap').on('change', '.question-dropdown .ask-aditional-question', function () {
        let question = $(this).parents('.question-wrap');
        let targetOption = $(this).parents('.dropdown-option')
        const questionType = $(this).val();
        if (questionType == "") {
            targetOption.find('.added-question-box').html("")
        } else {
            targetOption.find('.added-question-box').html(addedQuestion(question, targetOption, questionType))
            if (questionType == 'free-answer' || questionType == 'scale' || questionType == 'nps' || questionType == 'dropdown' || questionType == 'date') {
                customSelectActive()
            }
            if (questionType == "ranging") {
                setSortbaleRanging();
            }
            if (questionType == "phone") {
                $('.question-phone input.code').intlTelInput({
                    initialCountry: "ua",
                });
            }
        }
    })

    $('.content-wrap').on('change', '.question-dropdown .dropdown-multiple-box select', function () {
        let question = $(this).parents('.question-wrap');
        checkDropdownDiapason(question);
    });

    //end settings for dropdown question
    //TODO dropdown question
    //!------------------------------------------------------------------------------------------------------------

    //settings for matrix question
    //!------------------------------------------------------------------------------------------------------------

    //input name of row for matrix
    $('.content-wrap').on('input', '.question-matrix .matrix-row input[type=text]', function (e) {
        let newText = $(this).val();
        let question = $(this).parents('.question-wrap');
        let rowItem = $(this).parents('.matrix-row');
        let rowIndex = parseInt(rowItem.index()) + 2;
        let rowHtml = $(question[0]).find('.matrix-table').find(`tr:nth-child(${rowIndex})`);
        if (rowHtml.length > 0) {
            rowHtml.find('td:nth-child(1)').html(newText);
        } else {
            addMatrixRow($(question[0]), newText);
        }
    });
    //out of focus row input
    $('.content-wrap').on('blur', '.question-matrix .matrix-row input[type=text]', function (e) {
        let newText = $(this).val();
        let question = $(this).parents('.question-wrap');
        let rowItem = $(this).parents('.matrix-row');
        let rowIndex = parseInt(rowItem.index()) + 1;
        if (!newText && rowIndex !== $(question[0]).find('.matrix-row-list').children().length) {
            removeMatrixRow($(question[0]), rowIndex);
        }
    });
    //input name of col for matrix
    $('.content-wrap').on('input', '.question-matrix .matrix-col input[type=text]', function (e) {
        let newText = $(this).val();
        let question = $(this).parents('.question-wrap');
        let colItem = $(this).parents('.matrix-col');
        let colIndex = parseInt(colItem.index()) + 2;
        let colHtml = $(question[0]).find('.matrix-table').find(`tr:nth-child(1)`).find(`td:nth-child(${colIndex})`);
        if (colHtml.length > 0) {
            colHtml.html(newText);
        } else {
            addMatrixCol($(question[0]), newText);
        }
    });
    //out of focus col input
    $('.content-wrap').on('blur', '.question-matrix .matrix-col input[type=text]', function (e) {
        let newText = $(this).val();
        let question = $(this).parents('.question-wrap');
        let colItem = $(this).parents('.matrix-col');
        let colIndex = parseInt(colItem.index()) + 1;
        if (!newText && colIndex !== $(question[0]).find('.matrix-col-list').children().length) {
            removeMatrixCol($(question[0]), colIndex);
        }
    });

    //remove matrix element
    $('.content-wrap').on('click', '.remove-matrix-el', function (e) {
        let question = $(this).parents('.question-wrap');
        if ($(this).parents('.matrix-row').find('input').length) {
            const rowsCount = $(this).parents('.matrix-options').find('.matrix-row-list .matrix-row').length;
            if (rowsCount < 2) {
                return
            } else {
                let rowItem = $(this).parents('.matrix-row');
                let rowIndex = parseInt(rowItem.index()) + 1;
                removeMatrixRow($(question[0]), rowIndex);
            }
        }
        if ($(this).parents('.matrix-col').find('input').length) {
            const colsCount = $(this).parents('.matrix-options').find('.matrix-col-list .matrix-col').length;
            if (colsCount < 2) {
                return
            } else {
                let colItem = $(this).parents('.matrix-col');
                let colIndex = parseInt(colItem.index()) + 1;
                removeMatrixCol($(question[0]), colIndex);
            }
        }
    });

    //change multiple\single choice
    $('.content-wrap').on('change', '.question-matrix .add-multipleChoice', function (e) {
        let question = $(this).parents('.question-wrap');
        let table = $(question[0]).find('.matrix-table');
        let inputs = table.find('input');
        if ($(this).is(':checked')) {
            for (let i = 0; i < inputs.length; i++) {
                if ($(inputs[i]).attr('type') === 'radio') {
                    $(inputs[i]).attr('type', 'checkbox');
                    let inputId = $(inputs[i]).attr('id');
                    $(inputs[i]).attr('name', inputId);
                }
            }
        } else {
            for (let i = 0; i < inputs.length; i++) {
                if ($(inputs[i]).attr('type') === 'checkbox') {
                    let oldName = $(inputs[i]).attr('name').split("_");
                    oldName.pop();
                    let newId = oldName.join('_');
                    $(inputs[i]).attr('name', newId);
                    $(inputs[i]).attr('type', 'radio');
                }
            }
        }
    });
    //add comment to matrix question
    $('.content-wrap').on('change', '.question-matrix .add-comment', function (e) {
        let question = $(this).parents('.question-wrap');
        if ($(this).is(':checked')) {
            let commnetHtml =
                '<div class="option-comment">' +
                `    <textarea rows="1" placeholder="${vars.vvediteVashComment}"></textarea>` +
                '</div>';
            $(commnetHtml).insertAfter($(question[0]).find('.matrix-table'));
        } else {
            $(question[0]).find('.option-comment').remove();
        }
    });
    //end settings for matrix question
    //!------------------------------------------------------------------------------------------------------------

    //settings for ranging question
    //!------------------------------------------------------------------------------------------------------------

    setSortbaleRanging();
    //input new ranging item
    $('.content-wrap').on('input', '.question-ranging .empty-item textarea', function (e) {
        let question = $(this).parents('.question-wrap');
        let newText = $(this).val();
        let thisItem = $(this).parents('.ranging-item');
        let thisRangeList = thisItem.parents('.ranging-list');
        let questionID = $(question[0]).attr('data-id');
        if (newText) {
            let newItemId = $(question[0]).find('.ranging-list').children().length + 1;
            let newItemHtml =
                `<div class="ranging-item empty-item">
                    <div class="grab-icon"></div>
                    <div class="ranging-name">
                        <textarea name="inputpoint_${questionID}_${newItemId}" placeholder="${vars.vvediteVariantOtveta}" rows="1"></textarea>
                    </div>
                </div>`;
            thisItem.removeClass('empty-item');
            $(newItemHtml).insertAfter(thisItem);
            $(thisRangeList).find('.empty-item').find('textarea').autoResize();
        }
    });

    $('.content-wrap').on('blur', '.question-ranging .ranging-item textarea', function (e) {
        let thisText = $(this).val();
        let thisItem = $(this).parents('.ranging-item');
        let question = $(this).parents('.question-wrap');
        if (!thisText && !thisItem.hasClass('empty-item')) {
            thisItem.remove();
            refreshRangeId($(question[0]));
        }
    });
    //end settings for ranging question
    //!------------------------------------------------------------------------------------------------------------

    //settings for date question
    //!------------------------------------------------------------------------------------------------------------

    //mask for input date
    function dateInputMask(elm) {
        elm.addEventListener('keypress', function (e) {
            if (e.keyCode < 47 || e.keyCode > 57) {
                e.preventDefault();
            }

            var len = elm.value.length;

            // If we're at a particular place, let the user type the slash
            // i.e., 12.12.1212
            if (len !== 1 || len !== 3) {
                if (e.keyCode == 47) {
                    e.preventDefault();
                }
            }

            // If they don't add the slash, do it for them...
            if (len === 2) {
                elm.value += '.';
            }

            // If they don't add the slash, do it for them...
            if (len === 5) {
                elm.value += '.';
            }
        });
    };
    //set input mask for date
    function setInputMaskDate() {
        var dateInputs = $('.date-input');
        for (let i = 0; i < dateInputs.length; i++) {
            dateInputMask(dateInputs[i]);
        }
    }
    setInputMaskDate();

    function setDatePicker() {
        //settings for date question
        $('.date-input').datepicker({
            gotoCurrent: true,
            showOtherMonths: false,
            altFormat: "mm.dd.yyyy",
            dateFormat: "mm.dd.yyyy",
        });
        setInputMaskDate();
    }
    //add few date input
    $('.content-wrap').on('change', '.question-date .amount-select', function (e) {
        let count = $(this).val();
        let question = $(this).parents('.question-wrap');
        let dataList = $(question[0]).find('.data-list');
        let dataInputs = dataList.children();
        let curCount = parseInt(dataInputs.length);
        if (count === 'dynamic') {
            count = 1;
        }
        if (count > curCount) {
            for (let i = curCount; i < count; i++) {
                let newInput =
                    `<div class="date-answer">
                    <input type="text" class="date-input" maxlength="10">
                    <div class="icon-date"></div>
                </div>`;
                $(newInput).appendTo(dataList);
            }
        }
        if (count < curCount) {
            for (let i = 0; i < curCount; i++) {
                if (i >= count) {
                    dataInputs[i].remove();
                }
            }
        }
        setDatePicker();
    });
    //end settings for date question
    //!------------------------------------------------------------------------------------------------------------

    //settings for free question
    //!------------------------------------------------------------------------------------------------------------
    $('.content-wrap').on('change', '.question-free .amount-select', function (e) {
        let question = $(this).parents('.question-wrap');
        let amount = $(this).val();
        let freeListWrap = $(question[0]).find('.free-answers');
        let freeList = freeListWrap.children();
        let currentAmount = freeList.length;
        let targetRow = $(this).parents('.select-row')
        console.log(targetRow)
        if (amount === 'dynamic') {
            amount = 1;
        }
        if (amount >= currentAmount) {
            for (let i = currentAmount; i < amount; i++) {
                let freeHtml =
                    `<div class="answer-wrap">
                        <textarea rows="1" placeholder="${vars.vvediteVashComment}"></textarea>
                    </div>`;
                freeListWrap.append(freeHtml);
            }
        } else {
            for (let i = amount; i < currentAmount; i++) {
                $(freeList[i]).remove();
            }
        }
        if (amount > 1) {
            let stringDescription =
                `<div class="select-row description-row">
                    <div class="label">
                        ${vars.dobavitStrokuOpisKVariantamOtv}
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="description" class="add-description">
                        <span class="slider round"></span>
                    </label>
                </div>`;
            $(stringDescription).insertAfter($(targetRow[0]))
        } else {
            $(question[0]).find('.description-row').remove()
        }
    });

    $('.content-wrap').on('change', '.question-free .add-description', function () {
        let question = $(this).parents('.question-wrap');
        let answers = $(question[0]).find('.answer-wrap')
        if ($(this).is(':checked')) {
            let descriptionHTML = `<textarea rows="1" placeholder="${vars.vvediteOpisanieVarOtveta}" class="all-events"></textarea>`
            answers.each(function (id, el) {
                if ($(el).find('textarea').length < 2) {
                    $(el).append(descriptionHTML)
                }
            })
        } else {
            answers.each(function (id, el) {
                $(el).find('textarea').eq(1).remove()
            })
        }
    })

    $('.content-wrap').on('input', '.question-free .all-events', function () {
        let targetArea = $(this).parent().find('textarea')[0]
        $(targetArea).attr('placeholder', $(this).val())
    })
    //end settings for free question

    //!------------------------------------------------------------------------------------------------------------

    //settings for phone question
    //!------------------------------------------------------------------------------------------------------------
    $('.question-phone input.code').intlTelInput({
        initialCountry: "ua",
    });
    //end settings for phone question
    //!------------------------------------------------------------------------------------------------------------

    //settings for file question
    //!------------------------------------------------------------------------------------------------------------

    //add icons and names of uploaded files
    $('.content-wrap').on('change', '.question-file input[type=file]', function (e) {
        let files = this.files;
        let question = $(this).parents('.question-wrap');
        if (question.find('.uploaded-list').length === 0) {
            let listHtml = `<div class="uploaded-list"></div>`
            $(listHtml).insertAfter($(this).parents('.file-answer'));
        }
        let filesWrap = question.find('.uploaded-list');
        let fileList = '';
        for (let i = 0; i < files.length; i++) {
            let fileName = files[i].name;
            let lastDot = fileName.lastIndexOf('.');
            let ext = fileName.substring(lastDot + 1);
            let iconClass = '';
            if (ext === 'doc' || ext === 'docx' || ext === 'dot' || ext === 'docm' || ext === 'dotx' || ext === 'dotm') {
                iconClass = 'file-icon-word';
            } else if (ext === 'jpg' || ext === 'png' || ext === 'gif' || ext === 'jpg' ||
                ext === 'jpeg' || ext === 'webp' || ext === 'svg') {
                iconClass = 'file-icon-img';
            } else if (ext === 'avi' || ext === 'mp4' || ext === 'webm' || ext === '3gp' || ext === '3gpp' ||
                ext === 'flv' || ext === 'm4v' || ext === 'mkv' || ext === 'mov' || ext === 'mpeg' ||
                ext === 'mpeg4' || ext === 'ogg' || ext === 'ogv' || ext === 'wmv') {
                iconClass = 'file-icon-video';
            } else if (ext === 'wav' || ext === 'mp3' || ext === 'm4a' || ext === 'wma' || ext === 'flac' || ext === 'aiff') {
                iconClass = 'file-icon-audio';
            } else if (ext === 'xlsx' || ext === 'xlsm' || ext === 'xltx' || ext === 'xls' || ext === 'xml') {
                iconClass = 'file-icon-exel';
            } else if (ext === 'pdf') {
                iconClass = 'file-icon-pdf';
            } else if (ext === 'pptx' || ext === 'pptm' || ext === 'pptm' || ext === 'ppt') {
                iconClass = 'file-icon-pp';
            }
            let itemHtml =
                `<div class="file-item">
                    <div class="file-icon ${iconClass}"></div>
                    <div class="file-name">
                        ${fileName}
                    </div>
                </div>`;
            fileList += itemHtml;
        }
        filesWrap.html(fileList);
    });
    //end settings file for  question
    //!------------------------------------------------------------------------------------------------------------

    //function for clear inputs in block
    function clear_form_elements(block) {
        jQuery(block).find(':input').each(function () {
            switch (this.type) {
                case 'password':
                case 'text':
                case 'textarea':
                case 'file':
                case 'select-one':
                case 'select-multiple':
                case 'date':
                case 'number':
                case 'tel':
                case 'email':
                    jQuery(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
                    break;
            }
            $(this).change();
        });
    }

    //refresh questions id
    function refreshQuestionsId() {
        let questions = $('.questions-box').find('.questions-list').children('.question-wrap');
        if (questions.length > 0) {
            for (let i = 0; i < questions.length; i++) {
                let id = i + 1;
                $(questions[i]).attr('data-id', id);
                let textareas = $(questions[i]).find('textarea');
                changeNameInput(textareas, id, 1);
                let inputs = $(questions[i]).find('input');
                changeNameInput(inputs, id, 1);
                let labels = $(questions[i]).find('label');
                changeNameInput(labels, id, 1);
                let selects = $(questions[i]).find('select');
                changeNameInput(selects, id, 1);

                let questionName = $(questions[i]).find('.question-name textarea');
                let valueName = questionName.val().split('. ');
                if (!questionName.val()) {
                    let nameString = id + '. ';
                    questionName.val(nameString);
                } else if (valueName.length > 1 && $.isNumeric(valueName[0])) {
                    valueName[0] = id;
                    let nameString = valueName.join(". ");
                    questionName.val(nameString);
                } else if (!$.isNumeric(valueName[0]) || valueName.length === 1) {
                    let nameString = id + '. ' + valueName.join(". ");
                    questionName.val(nameString);
                }
            }
        }
        addListSingleQuestion()
        createSelectOfSingleQuestionsForHide()
        addListDropdownQuestion()
    }

    //make audiowave
    $('.audiowave').each(function () {
        var path = $(this).attr('data-audiopath'); //path for audio
        setAudioWave(this, path);
    });

    // wavesurfer for audio elements
    function setAudioWave(el, path) {
        //Initialize WaveSurfer
        var wavesurfer = WaveSurfer.create({
            container: el,
            scrollParent: false,
            backgroundColor: '#FFFFFF',
            height: 40,
            barMinHeight: 1,
            barWidth: 1.5,
            cursorWidth: 0,
            barGap: 1.5,
            waveColor: '#E5E5E5',
            hideScrollbar: true,
            progressColor: "#000000"
        });

        //Load audio file
        wavesurfer.load(path);

        // Show video duration
        wavesurfer.on('ready', function () {
            $(el).parents('.audio-wrap').find('.audio-duration').html(formatTime(wavesurfer.getDuration()));
        });

        wavesurfer.on('pause', function () {
            $(el).parents('.audio-wrap').find('.audio-control').removeClass('pause');
        });

        wavesurfer.on('play', function () {
            $(el).parents('.audio-wrap').find('.audio-control').addClass('pause');
        });
        //Add button event
        $(el).parents('.audio-wrap').find('.audio-control').click(function () {
            wavesurfer.playPause();
        });
    }

    //seconds to time
    function formatTime(time) {
        return [
            Math.floor((time % 3600) / 60), // minutes
            ('00' + Math.floor(time % 60)).slice(-2) // seconds
        ].join(':');
    };
});

