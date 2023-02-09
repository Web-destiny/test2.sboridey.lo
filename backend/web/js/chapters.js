import {
    generateChapterWrapper
} from './constants/chpters-constants.js?115324234';
import {
    setChapterSortable,
    setQustionsSortableInChapter,
    chapterSortEnd
} from './controller/sortable.controller.js?115324234';

//TODO change id and names for elements
export function changeNameInput(inputs, id, position) {
    for (let i = 0; i < inputs.length; i++) {
        if ($(inputs[i]).attr('name')) {
            let prevId = $(inputs[i]).attr('name').split("_");
            if(prevId.length == 3){
                if (prevId[position]) {
                    prevId[position] = id;
                    let newId = prevId.join('_');
                    $(inputs[i]).attr('name', newId);
                }
            }else if(prevId.length == 4){
                position = 3
                if (prevId[position]) {
                    prevId[position] = id;
                    let newId = prevId.join('_');
                    $(inputs[i]).attr('name', newId);
                }
            }

        }
        if ($(inputs[i]).attr('id')) {
            let prevId = $(inputs[i]).attr('id').split("_");
            if (prevId[position]) {
                prevId[position] = id;
                let newId = prevId.join('_');
                $(inputs[i]).attr('id', newId);
            }
        }
        if ($(inputs[i]).attr('for')) {
            let prevId = $(inputs[i]).attr('for').split("_");
            if (prevId[position]) {
                prevId[position] = id;
                let newId = prevId.join('_');
                $(inputs[i]).attr('for', newId);
            }
        }
    }
    return true;
}


export let hasChapter = !! $('.questions-box .chapter-wrapper').length;
export let chapterList = $('.chapter-wrapper');

export function showChaptersList() {}

export function addChapter(chapterIndex, qLenth) {
    hasChapter = true;
    if (!chapterList.length) {
        setChapterSortable();
    }

    if (chapterIndex === undefined) {
        chapterIndex = chapterList.length;
    }
    createChapter(chapterIndex);
    updateChaptersIndex();
}

// generate chapter HTML
function generateChapter() {
    updateQuestionsBox();
    const $questions = $('.questions-list')
        .find('.question-wrap')
        .clone();
    const chapterItemNumber = chapterList.length + 1
    const chapterTextAreaName = `chapter-name-${chapterItemNumber}`;
    const chapterSelectName = `chapter-select-${chapterItemNumber}`;
    const $chapterWRP = $($.parseHTML(generateChapterWrapper(chapterTextAreaName, chapterSelectName, chapterItemNumber))[0]);
    $chapterWRP.attr('data-index', chapterList.length)
    $chapterWRP.find('.chapter-head .chapter-number').text(`${chapterItemNumber}.`);
    $('.btn-preview-wrap').show();

    if (!chapterList.length) {
        $('.questions-list').find('.question-wrap').remove();
        $chapterWRP.find('.chapter-questions-list').append($questions);
        updateChapterQuestionsIndex($chapterWRP);
    }
    return $chapterWRP;
}

function createChapter(chapterIndex) {
    refreshChapterList();

    const $chapterWRP = generateChapter();

    if (!chapterList.length) {
        $('.questions-list').prepend($chapterWRP);
        $('.chapter').show();
        chapterList.push($chapterWRP);
    } else {
        const insertIndex = chapterIndex - 1;
        if (insertIndex < 0) {
            $chapterWRP.insertBefore(chapterList[0]);
        } else {
            $chapterWRP.insertAfter(chapterList[chapterIndex - 1]);
        }
        chapterList.splice(chapterIndex, 0, $chapterWRP);
    }


    const $sortableWrapper = $chapterWRP.find('.chapter-questions-list');
    setQustionsSortableInChapter($sortableWrapper[0]);
}

function updateQuestionsBox() {
    const $qBox = $('.questions-box.empty');
    $qBox.removeClass('empty');
}

// updating indexes for chapters
export function updateChaptersIndex() {
    chapterList.forEach(($chapter, newIndex) => {
        $($chapter).attr('data-index', newIndex);
        $($chapter).find('.chapter-head .chapter-number').text(`${newIndex + 1}.`);
        $($chapter).find('.chapter-name-textarea').attr('name', `chapter-name-${newIndex + 1}`);
        $($chapter).find('.chapter-name-select').attr('name', `chapter-select-${newIndex + 1}`);
        updateChapterQuestionsIndex($($chapter));
    });
}

// update indexes for qustions inside chapters
export function updateChapterQuestionsIndex($chapter) {
    const $questions = $chapter.find('.question-wrap');
    const chapterIndex = $chapter.attr('data-index') * 1 + 1;

    $questions.map((index, qustion) => {
        const questionIndex = index + 1;
        const questionText = getQestionText($(qustion).find('.question-name textarea').val());
        $(qustion).find('.chapter').text(`${chapterIndex}/`);
        $(qustion).find('.question-name textarea').val(`${questionIndex}.${questionText}`);
        updateQuestionNameToRight(qustion, questionIndex, chapterIndex);
        updateQuestionNameToRight(qustion, questionIndex, chapterIndex);
    });
    $('.chapter').show();
}

function getQestionText(questionTextarea) {
    return questionTextarea.split('.').slice(1).join('');
}

// update all question name and id inside chapter
function updateQuestionNameToRight(qustion, questionIndex, chapterIndex) {
    const rightId = `${chapterIndex}_${questionIndex}`;
    const dataId = $(qustion).attr('data-id');
    let newId;
    if (dataId != rightId) {
        const $oldNameElements = $(qustion).find('[name]');
        $oldNameElements.each((oldNameElementIndex, oldNameElement) => {
            let newName;
            let prevId = $(oldNameElement).attr('name').split('_');
            if (prevId.length > 2) {
                newName = $(oldNameElement).attr('name').replace(dataId, rightId);
            } else {
                console.log(rightId)
                newName = $(oldNameElement).attr('name').replace(`0-${dataId}`, rightId);
            }
            const oldId = $(oldNameElement).attr('id');
            if ($(oldNameElement).attr('id')) {
                newId = $(oldNameElement).attr('id').replace(dataId, rightId);
            } else {
                newId = null
            }
            $(oldNameElement).attr('name', newName);
            if (newId) {
                $(oldNameElement).attr('id', newId);
            }

            const $labels = $(qustion).find(`[for="${oldId}"]`);
            if ($labels.length) {
                $labels.attr('for', newId);
            }
        });

        $(qustion).attr('data-id', rightId);
    }
}


export function deleteChapter($chapter) {
    const deleteChapterIndex = $chapter[0].dataset.index;
    chapterList = chapterList.filter((chapter) => {
        return chapter[0].dataset.index !== deleteChapterIndex
    });
    $chapter.remove();
    updateChaptersIndex();
    updateChaptersSettingsSelects();
    if (chapterList.length == 0) {
        hasChapter = false;
        $('.btn-preview-wrap').hide();
    }
}

export function addQuestionToChapter(questionTXT, chapterIndex = chapterList.length - 1, questionIndex = 0) {
    refreshChapterList();
    const $currentChapter = chapterList[chapterIndex];
    if (questionIndex === 0) {
        $currentChapter
            .find('.chapter-questions-list')
            .append(questionTXT);
    } else {
        const $questionsList = $currentChapter.find('.chapter-questions-list');
        const $questionBefore = $($questionsList.find('.question-wrap')[questionIndex]);
        $questionBefore.before(questionTXT);
    }
    updateChapterQuestionsIndex($currentChapter);
    $('.chapter').show();
}

// update selects in chapter options
export function upadteAllChaptersSettingsSelectNames() {
    moveChapter();
    addChaptersSettingsSelectOption();
}

export function setChaptersSettingsSelectNames($chapter, chapterName) {
    const chapterIndex = parseInt($chapter.attr('data-index')) + 1;
    chapterList.forEach(function (chapter) {
        const currentHTMLoption = $(chapter)
            .find(`.chapter-settings .select-options li[rel="go-to-chapter-${chapterIndex}"]`)
        $(currentHTMLoption).html(`${vars.pereytiKRazdelu} ${chapterIndex}: <span class="chapters-list-name">${chapterName}</span>`);
    });
}

// generate HTML for chapter settings selects
export function addChaptersSettingsSelectOption() {
    let selectOptionsToAdd = [];
    let selectHTMLToAdd = [];

    chapterList.forEach(function (chapter, index) {
        let chapterName = $(chapter).find('.chapter-head .chapter-name-textarea').val();
        if (chapterName == '') {
            chapterName = `${vars.nazvanieRazdela}`
        }
        let selectNewOption = `<option value="go-to-chapter-${index + 1}">${vars.pereytiKRazdelu} ${index + 1}: <span class="chapters-option-name">"${chapterName}"</span></option>`;
        selectOptionsToAdd.push(selectNewOption);
        let selectNewHTML = `<li rel="go-to-chapter-${index + 1}">${vars.pereytiKRazdelu} ${index + 1}: <span class="chapters-list-name">"${chapterName}"</span></li>`;
        selectHTMLToAdd.push(selectNewHTML);
    });

    let newOptionsForTemplate = selectOptionsToAdd.join('');
    let newHTMLlistForTemplate = selectHTMLToAdd.join('');

    let optionsTemplate = `
        <option selected value="select-action">${vars.viberiteDeystvie}</option>
        <option value="go-to-nextChapter">${vars.pereytiKSleduyushemuRazdelu}</option>
        ${newOptionsForTemplate}             
        <option value="to-submit-survey">${vars.otpravitAnketu}</option>`;

    let listTemplate = `
        <li selected rel="select-action">${vars.viberiteDeystvie}</li>
        <li rel="go-to-nextChapter">${vars.pereytiKSleduyushemuRazdelu}</li>
        ${newHTMLlistForTemplate}
        <li rel="to-submit-survey">${vars.otpravitAnketu}</li>`;

    setChapterSettingsSelects(optionsTemplate, listTemplate);
}


function setChapterSettingsSelects(optionTemplate, selectListTemplate) {
    chapterList.forEach(function (chapter, index) {
        $(chapter).find('.chapter-settings .chapter-name-select').html(optionTemplate);
        $(chapter).find('.chapter-settings .select-options').html(selectListTemplate);
        const currentHTMLoption = $(chapter).find('.chapter-settings .select-options li');
        const currentOption = $(chapter).find('.chapter-settings .chapter-name-select option');
        currentHTMLoption[index + 2].remove();
        currentOption[index + 2].remove();
    });
}

export function refreshChapterList() {
    chapterList = Array.from($('.chapter-wrapper')).map(el => $(el));
}

export function moveChapter() {
    chapterList = Array.from($('.chapter-wrapper')).map(el => $(el));
    updateChaptersIndex();
}

function updateChaptersSettingsSelects() {
    if (chapterList.length != 0) {
        chapterList.forEach(function (chapter, index) {
            const chaptersSettingsOptions = $(chapter).find('.chapter-settings .chapter-name-select option');
            const chaptersSettingsHTML = $(chapter).find('.chapter-settings .select-options li');
            removeChapterSelectSettings(chaptersSettingsOptions);
            removeChapterSelectSettings(chaptersSettingsHTML);
            /**Update chapter settings number*/
            $(chapter).find('.chapter-settings .chapter-settings-number').text(`${index + 1}:`);
        });
    }
}

function removeChapterSelectSettings(elToRemove) {
    for (let i = 0; i < elToRemove.length; i++) {
        elToRemove[elToRemove.length - 2].remove();
    }
}

// generate HTML content for popup with chapters
export function generatePopupChapters() {
    const createdChapters = $('.questions-list .chapter-wrapper');
    let chapterItemTemplate = '';

    if (createdChapters.length > 0) {
        for (let i = 0; i < createdChapters.length; i++) {
            let chapterName = $(createdChapters[i]).find('.chapter-name-textarea').val();
            if (chapterName == '') {
                chapterName = `${vars.nazvanieRazdela}`;
            }
            chapterItemTemplate +=
                `<div class="chapters-list__item" data-index="${i}">
                    <div class="chapters-list__icon">
                        <div class="chapters-list__icon-dot"></div>
                        <div class="chapters-list__icon-dot"></div>
                        <div class="chapters-list__icon-dot"></div>
                        <div class="chapters-list__icon-dot"></div>
                        <div class="chapters-list__icon-dot"></div>
                        <div class="chapters-list__icon-dot"></div>
                    </div>
                    <div class="chapters-list__info">
                        <div class="chapters-list__name">${chapterName}</div>
                        <div class="chapters-list__count">${vars.razdel} <span class="current-chapter-number">${i+1}</span> ${vars.iz}
                            <span class="all-chapters-count">${createdChapters.length}</span></div>
                    </div>
                    <div class="move-arrows-wrapper">
                        <div class="move-arrow move-top-arrow"></div>
                        <div class="move-arrow move-bottom-arrow"></div>
                    </div>
                </div>`;
            $('.chapters-list form').html(chapterItemTemplate);
        }
    }
    $('.chapters-list-bg').fadeIn();
}

// change chapter position
export function moveChapterOnArrowClick(currentCahpter, $arrow, oldIndex) {

    let newIndex = '';
    if ($arrow.hasClass('move-top-arrow')) {
        const previousChapter = currentCahpter.prev();
        $(currentCahpter).insertBefore(previousChapter);
        newIndex = oldIndex - 1;
        if (newIndex < 0 || $('.chapter-wrapper').length == 1 || previousChapter.length == 0) {
            return
        } else {
            const $changedCurrentChapter = $($('.chapter-wrapper')[newIndex]);
            const $toChangeCurrentChapter = $($('.chapter-wrapper')[oldIndex]);

            const $cloneMoovedChapter = $toChangeCurrentChapter.clone();
            $cloneMoovedChapter.insertBefore($changedCurrentChapter);
            $toChangeCurrentChapter.remove();
            moveChapter();
            upadteAllChaptersSettingsSelectNames();
            resetChapterSettingSelect($changedCurrentChapter);
            resetChapterSettingSelect($cloneMoovedChapter);
            // refresh chapter settings index;
            updateChaptersSettingsSelects();
            setQustionsSortableInChapter($($cloneMoovedChapter[0]).find('.chapter-questions-list')[0])

        }
    } else if ($arrow.hasClass('move-bottom-arrow')) {
        const nextChapter = currentCahpter.next();
        $(currentCahpter).insertAfter(nextChapter);
        newIndex = oldIndex + 1;
        if (newIndex < 0 || $('.chapter-wrapper').length == 1 || nextChapter.length == 0) {
            return
        } else {
            const $changedCurrentChapter = $($('.chapter-wrapper')[newIndex]);
            const $toChangeCurrentChapter = $($('.chapter-wrapper')[oldIndex]);

            const $cloneMoovedChapter = $toChangeCurrentChapter.clone();
            $cloneMoovedChapter.insertAfter($changedCurrentChapter);
            $toChangeCurrentChapter.remove();
            moveChapter();
            upadteAllChaptersSettingsSelectNames();
            resetChapterSettingSelect($changedCurrentChapter);
            resetChapterSettingSelect($cloneMoovedChapter);
            setQustionsSortableInChapter($($cloneMoovedChapter[0]).find('.chapter-questions-list')[0])
            // refresh chapter settings index;
            updateChaptersSettingsSelects();
        }
    }
    updatePopupChapterIndexes();
}

export function updatePopupChapterIndexes() {
    let popupChapters = $('.chapters-list .chapters-list__item');
    for (let i = 0; i < popupChapters.length; i++) {
        $(popupChapters[i]).find('.current-chapter-number').text(i + 1);
        $(popupChapters[i]).attr('data-index', i);
    }
}

export function closeChaptersPopup() {
    $('.chapters-list-bg').fadeOut();
}

export function resetChapterSettingSelect($chapter) {
    $chapter.find('.select-styled').text(
        $($chapter.find('.chapter-name-select option')[0]).text()
    )
    $chapter.find('.chapter-name-select').val('select-action').trigger('change');
    $($chapter.find('.chapter-name-select option')[0]).attr('selected', true);
}
