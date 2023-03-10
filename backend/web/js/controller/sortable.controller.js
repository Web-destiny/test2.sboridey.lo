import {
    refreshChapterList,
    updatePopupChapterIndexes,
    updateChapterQuestionsIndex,
    upadteAllChaptersSettingsSelectNames,
    resetChapterSettingSelect,
    updateChaptersIndex
} from '../chapters.js'
import {
    createSelectOfSingleQuestionsForHide,
    clearSelectStyledHideQuestions
} from '../single-functionsss.js';

//} from '../chapters.js?89411532423409823'

let sortableList = [];

export function setQustionSortable(onEndFunction) {
    destoroyAllSortable();

    if (sortableList.length) {
        destoroyAllSortable()
    }

    let questionList = $('.questions-box .questions-list');
    const sortable = new Sortable(questionList[0], {
        scroll: true,
        forceFallback: true,
        animation: 150,
        filter: 'input, a, button, textarea, .control-panel, .customselect-wrapper, .ranging-list',
        preventOnFilter: false,
        swapThreshold: 0.9,
        invertSwap: true,
        onEnd: onEndFunction,
    });
    sortableList.push(sortable);
}

export function setChaptersSortableInModal() {
    let chaptersList = $('.chapters-list-container .chapters-list form')[0];

    const sortable = new Sortable(chaptersList, {
        scroll: true,
        forceFallback: true,
        draggable: '.chapters-list__item',
        animation: 150,
        filter: 'input, a, button, textarea, .control-panel, .customselect-wrapper, .ranging-list',
        preventOnFilter: false,
        swapThreshold: 0.9,
        invertSwap: true,
        onStart: (event) => {},
        onEnd: (event) => {
            //
            const $changedCurrentChapter = $($('.chapter-wrapper')[event.newIndex]);
            const $toChangeCurrentChapter = $($('.chapter-wrapper')[event.oldIndex]);
            const $cloneMoovedChapter = $toChangeCurrentChapter.clone();
            event.newIndex > event.oldIndex ? $cloneMoovedChapter.insertAfter($changedCurrentChapter) : $cloneMoovedChapter.insertBefore($changedCurrentChapter);
            $toChangeCurrentChapter.remove();
            setQustionsSortableInChapter($($cloneMoovedChapter[0]).find('.chapter-questions-list')[0])
            chapterSortEnd(event);
            updatePopupChapterIndexes();
        },
    });
    sortableList.push(sortable);
}

export function setChapterSortable() {
    destoroyAllSortable();
    let questionList = $('.questions-box .questions-list');
    const sortable = new Sortable(questionList[0], {
        scroll: true,
        forceFallback: true,
        draggable: '.chapter-wrapper',
        animation: 150,
        filter: 'input, a, button, textarea, .control-panel, .customselect-wrapper, .ranging-list, .chapter-questions-list',
        preventOnFilter: false,
        swapThreshold: 0.9,
        invertSwap: true,
	onStart: (event) => {},
        onEnd: (event) => {
		chapterSortEnd(event);
	},
    });
    sortableList.push(sortable);
}
export function setQustionsSortableInChapter(sortableWrapper) {
    const sortable = new Sortable(sortableWrapper, {
        scroll: true,
        forceFallback: true,
        animation: 150,
        filter: 'input, a, button, textarea, .ranging-item, .grab-icon',
        preventOnFilter: false,
        swapThreshold: 0.9,
        invertSwap: true,
        onEnd: () => {
            let chapter = $(sortableWrapper).closest('.chapter-wrapper');
            updateChapterQuestionsIndex(chapter);

            let allChoices = $('.single-option-choice .single-action .select-options .active')
            if($('.chapter-questions-list').children().length > 1){
                let allInputs = $('.questions-list .radio-item textarea, .questions-list .question-dropdown .option-item .inputpoint-body input')
                $(allInputs).each(function (item) {
                    if($(this).parent().hasClass('radio-item')){
                        $(this).parent('.radio-item').find('.hide-element__input input').attr('value', '')
                    }else if($(this).parent().hasClass('value')){
                        $(this).closest('.option-item').find('.hide-element__input input').attr('value', '')
                    }

                })
                $(allChoices).each(function () {
                    let nameLi = $(this).attr('name')
                    let li = $(this)
                    let allInputs = $('.questions-list .radio-item textarea, .questions-list .question-dropdown .option-item .inputpoint-body input')
                    if($(this)){
                        $(allInputs).each(function (item) {
                            let nameTextarea = $(this).attr('name')
                            if (nameLi == nameTextarea) {
                                if(nameLi == nameTextarea){
                                    let selectedQuestionAttr = $(li).closest('.question-wrap').find('.question-name textarea').attr('name').slice(9)
                                    if($(this).parent().hasClass('radio-item')){
                                        let radioInputVal = $(this).parent('.radio-item').find('.hide-element__input input').attr('value')
                                        if(radioInputVal){
                                            $(this).parent('.radio-item').find('.hide-element__input input').attr('value', radioInputVal + ',' + selectedQuestionAttr)
                                        }else{
                                            $(this).parent('.radio-item').find('.hide-element__input input').attr('value', selectedQuestionAttr)
                                        }
                                    }else if($(this).parent().hasClass('value')){
                                        let optionItemVal = $(this).closest('.option-item').find('.hide-element__input input').attr('value')
                                        if(optionItemVal){
                                            $(this).closest('.option-item').find('.hide-element__input input').attr('value', optionItemVal + ',' + selectedQuestionAttr)
                                        }else{
                                            $(this).closest('.option-item').find('.hide-element__input input').attr('value', selectedQuestionAttr)
                                        }
                                    }
                                }


                            }
                        })
                    }else{
                        $(allInputs).each(function (item) {
                            if($(this).parent().hasClass('radio-item')){
                                $(this).parent('.radio-item').find('.hide-element__input input').attr('value', '')
                            }else if($(this).parent().hasClass('value')){
                                $(this).closest('.option-item').find('.hide-element__input input').attr('value', '')
                            }
                        })
                    }
                })
            }else{
                let allInputs = $('.questions-list .radio-item textarea, .questions-list .question-dropdown .option-item .inputpoint-body input')
                $(allInputs).each(function (item) {
                    if($(this).parent().hasClass('radio-item')){
                        $(this).parent('.radio-item').find('.hide-element__input input').attr('value', '')
                    }else if($(this).parent().hasClass('value')){
                        $(this).closest('.option-item').find('.hide-element__input input').attr('value', '')
                    }

                })
            }
            createSelectOfSingleQuestionsForHide()
            clearSelectStyledHideQuestions()
        },
    });
    sortableList.push(sortable);
}


export function destoroyAllSortable() {
    sortableList.forEach(sortable => sortable.destroy());
    sortableList = [];
}

export function chapterSortEnd(event) {
    let chapterList = $('.chapter-wrapper');
    for (let i = 0; i < chapterList.length; i++) {
        let $chapter = $(chapterList[i]);
        let newIndex = i;
        $chapter.find('.chapter-head .chapter-number').text(`${newIndex+1}.`);
        $chapter.find('.chapter-settings-number').text(`${newIndex+1}`);
        $chapter.find('.chapter-name-textarea').attr('name', `chapter-name-${newIndex+1}`);
        $chapter.find('.chapter-name-select').attr('name', `chapter-select-${newIndex+1}`);
        $chapter.attr('data-index', newIndex);
        refreshChapterList();
        updateChapterQuestionsIndex($chapter);
    }
    upadteAllChaptersSettingsSelectNames();


    const changedCurrentChapter = $('.chapter-wrapper')[event.newIndex];
    const toChangeCurrentChapter = $('.chapter-wrapper')[event.oldIndex];

    resetChapterSettingSelect($(changedCurrentChapter));
    resetChapterSettingSelect($(toChangeCurrentChapter));
}
