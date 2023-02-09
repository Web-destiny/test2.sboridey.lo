
//!new file  type of questions single functions
import {
    hasChapter,
    changeNameInput
} from "./chapters.js?15324234"


// main function for creating a Single Option
export function addSingleOption(questionId, pointId, text, itemsList, addClas = ' ') {
    let itemsName = "inputpoint_" + questionId + "_" + pointId;
    let itemHtml =
        '<div class="radio-item ' + addClas + '">' +
        '    <div class="remove-item"></div>' +
        '    <textarea name="' + itemsName + '" rows="1" placeholder="������� ������">' + text + '</textarea>' +
        `    <div class="radio-item-visability"></div>` +
        '</div>';
    // <div className="radio-item-upload-img">
    // <input type="file" accept="image/png, image/gif, image/jpeg" name="uploadimage_${questionId + " _" + pointId}"
    //        id="uploadimage_${questionId + " _" + pointId}">
    //     <label htmlFor="uploadimage_${questionId + " _" + pointId}"></label>
    // </div>
    $(itemsList).append(itemHtml);
    $(itemsList).find('textarea').autoResize();
}

// main function for creating a alternatives item
export function addSingleAlternative(questionId, pointId, itemsList) {
    let itemHtml =
        '<div class="alternatives-item">' +
        '    <div class="switch-row">' +
        '       <div class="label">' + pointId + ')</div>' +
        '       <label class="switch">' +
        '           <input type="checkbox" name="single-visability_' + questionId + '_' + pointId + '"/>' +
        '           <span class="slider round"></span>' +
        '       </label>' +
        `       <div class="label">${vars.scritAlternativuUVoprose}</div>` +
        '       <div class="single-inputpoint-customselect-question">' +
        '           <select class="customselect">' +
        '               <option value></option>' +
        '           </select>' +
        '       </div>' +
        `       <div class="label">${vars.varianta}</div>` +
        '       <div class="single-inputpoint-customselect-answer">' +
        '           <select class="customselect" multiple="multiple">' +
        '               <option value></option>' +
        '           </select>' +
        '       </div>' +
        '    </div' +
        '</div>';
    $(itemsList).append(itemHtml);
    customSelectActive();
}

export function refreshAlternativesItemIndexes(itemEl) {
    itemEl.parents('.question-content').find('.list-alternatives .alternatives-item').each(function (id, el) {
        $($(this).find('.switch-row').children('.label')[0]).html(id + 1)
        let alternativesNameArr = $(this).find('input').attr('name').split('_')
        alternativesNameArr[alternativesNameArr.length - 1] = id + 1;
        $(this).find('input').attr('name', alternativesNameArr.join('_'))
    })
}

export function removeSingleOption(itemEl) {
    let itemQuestion = itemEl.parents('.question-wrap');
    let itemsList = itemEl.parents('.radio-btns-wrapper');
    if ($(itemEl).hasClass('neither')) {
        itemQuestion.find('.add-neither').prop('checked', false);
    }
    if ($(itemEl).hasClass('other')) {
        itemQuestion.find('.add-other').prop('checked', false);
    }
    $(itemEl).remove();
    refreshSingleOptionsId(itemsList);
}

export function addListSingleQuestion() {
    let singlesList = $('.question-single')

    let arrQuestions = singlesList.map((id, el) => {
        return {
            name: $(el).find('.question-name textarea').val(),
            id: $(el)[0].dataset.id
        }
    })
    let selectsQuestionName = $('.single-inputpoint-customselect-question')
    selectsQuestionName.each(function (id, el) {
        let select = $(el).find('select')
        let customSelect = $(el).find('.select-options')
        select.html("")
        customSelect.html("")
        arrQuestions.each((id, question) => {
            if (question.id == $(el).parents('.question-single')[0].dataset.id) {
                return
            }

            let createdOption = `<option value="${question.name}" data-id="${question.id}">${question.name}</option>`;
            let createdLi = `<li rel="${question.name}" data-id="${question.id}">${question.name}</li>`;
            select.append(createdOption)
            customSelect.append(createdLi)
        })
    })
}

//refresh id for single options
export function refreshSingleOptionsId(itemsList) {
    let options = itemsList.children();
    for (let i = 0; i < options.length; i++) {
        let id = i + 1;
        let textareas = $(options[i]).find('textarea');
        changeNameInput(textareas, id, 2);
    }
}

//sortable for single items
export function setSortbaleSingleItems() {
    let questionList = $('.question-single .radio-btns-wrapper');
    for (let i = 0; i < questionList.length; i++) {
        if (!$(questionList[i]).hasClass('sortable')) {
            console.log('setSortbaleSingleItems');
            $(questionList[i]).addClass('sortable');
            new Sortable(questionList[i], {
                scroll: true,
                forceFallback: true,
                animation: 150,
                filter: 'a, .inFocus',
                preventOnFilter: false,
                onEnd: function (evt) {
                    if (hasChapter) {
                        let question = $(evt.target).closest('.question-wrap');
                        let questionIndex = $(evt.target).closest('.question-wrap').attr('data-id');
                        $(question).find('.radio-item textarea').each((index, radioItem) => {
                            $(radioItem).attr('name', `inputpoint_${questionIndex}_${index + 1}`);
                        })
                    } else {
                        let itemsList = $(evt.target);
                        refreshSingleOptionsId(itemsList);
                    }
                },
            });
        }
    }
}

export function createSingleOptionBlock(question, singleName) {
    let singleOptionBlock =
        `<div class="single-options-box">
            <div class="single-option" data-id="${singleName}_1">
                <div class="single-property-row">
                    <span class="single-lable">${vars.priViboreVarianta}</span>
                    <div class="single-answer">
                        <select class="customselect single-answer-select">
                            <option value=""></option>
                        </select>
                    </div>
                    <span class="single-lable">${vars.vipolnitDeistvie}</span>
                    <div class="single-action">
                        <select class="customselect single-action-select">
                            <option selected value="">${vars.vibratDeystvie}</option>
                            <option value="move-to-question">${vars.pereitiKVovposu}</option>
                            <option value="move-to-chapter">${vars.pereytiKRazdelu}</option>
                            <option value="hide-question">${vars.scritVoprosi}</option>
			    <option value="hide-chapter">${vars.scritRazdel}</option>
                            <option value="ask-additional-question">${vars.zadatDopVopros}</option>
                            <option value="complete-poll">${vars.zavershitOpros}</option>
                        </select>
                    </div>
                    <div class="remove-single-option"></div>
                </div>
                <p class="add-new-single-option">${vars.dobavitOpciu}</p>
            </div>
        </div>`;
    $(singleOptionBlock).insertAfter($(question).find('.single-option-row'));
    createSelectOfSingleAnswer(question)
    customSelectActive();
}

export function createSingleChoiceToHide(question, singleName) {
    let singleOptionBlock =
        `<div class="single-options-box-choice">
            <div class="single-option-choice" data-id="${singleName}_1">
                <div class="single-property-row">
                    <div class="single-answer">
                        <select class="customselect single-answer-select">
                            <option value=""></option>
                        </select>
                    </div>
                  
                    <div class="single-action">
                        <select class="customselect single-action-select">
                            <option selected value="">${vars.vibratDeystvie}</option>
                            <option value="move-to-question">${vars.pereitiKVovposu}</option>
                            <option value="move-to-chapter">${vars.pereytiKRazdelu}</option>
                            <option value="hide-question">${vars.scritVoprosi}</option>
			    <option value="hide-chapter">${vars.scritRazdel}</option>
                            <option value="ask-additional-question">${vars.zadatDopVopros}</option>
                            <option value="complete-poll">${vars.zavershitOpros}</option>
                        </select>
                    </div>
                    <div class="remove-single-choice"></div>
                </div>
            </div>
            <p class="add-new-single-choice">Добавить вопрос</p>
        </div>`;
    $(singleOptionBlock).insertAfter($(question).find('.single-choice-row'));
    createSelectOfSingleAnswer(question)
    customSelectActive();
}

export function createSingleOptionChoice(question, singleOptionName, singleOptionsCount, newSingleOptionsCount) {
    let singleNameIndex = ($(question).find('.single-option-choice').length) + 1;
    let singleOption =
        `<div class="single-option-choice" data-id="${singleOptionName}_${singleNameIndex}">
            <div class="single-property-row">
                <div class="single-answer">
                    <select class="customselect single-answer-select">
                        <option value=""></option>
                    </select>
                </div>
                <div class="single-action">
                    <select class="customselect single-action-select">
                        <option selected value="">${vars.vibratDeystvie}</option>
                        <option value="move-to-question">${vars.pereitiKVovposu}</option>
                        <option value="move-to-chapter">${vars.pereytiKRazdelu}</option>
                        <option value="hide-question">${vars.scritVoprosi}</option>
			<option value="hide-chapter">${vars.scritRazdel}</option>
                        <option value="ask-additional-question">${vars.zadatDopVopros}</option>
                        <option value="complete-poll">${vars.zavershitOpros}</option>
                    </select>
                </div>
                <div class="remove-single-choice"></div>
            </div>
        </div>`;

    // if (newSingleOptionsCount < singleOptionsCount) {
    //     $(singleOption).appendTo($(question).find('.single-options-box-choice'));
    //     createSelectOfSingleAnswer(question)
    //     customSelectActive();
    // } else {
    //     return
    // }

    $(singleOption).appendTo($(question).find('.single-options-box-choice')).insertBefore('.add-new-single-choice');
        createSelectOfSingleAnswer(question)
        customSelectActive();
}

export function createSingleOption(question, singleOptionName, singleOptionsCount, newSingleOptionsCount) {
    let singleNameIndex = ($(question).find('.single-option').length) + 1;
    let singleOption =
        `<div class="single-option" data-id="${singleOptionName}_${singleNameIndex}">
            <div class="single-property-row">
                <span class="single-lable">${vars.priViboreVarianta}</span>
                <div class="single-answer">
                    <select class="customselect single-answer-select">
                        <option value=""></option>
                    </select>
                </div>
                <span class="single-lable">${vars.vipolnitDeistvie}</span>
                <div class="single-action">
                    <select class="customselect single-action-select">
                        <option selected value="">${vars.vibratDeystvie}</option>
                        <option value="move-to-question">${vars.pereitiKVovposu}</option>
                        <option value="move-to-chapter">${vars.pereytiKRazdelu}</option>
                        <option value="hide-question">${vars.scritVoprosi}</option>
			<option value="hide-chapter">${vars.scritRazdel}</option>
                        <option value="ask-additional-question">${vars.zadatDopVopros}</option>
                        <option value="complete-poll">${vars.zavershitOpros}</option>
                    </select>
                </div>
                <div class="remove-single-option"></div>
            </div>
            <p class="add-new-single-option">${vars.dobavitOpciu}</p>
        </div>`;

    if (newSingleOptionsCount < singleOptionsCount) {
        $(singleOption).appendTo($(question).find('.single-options-box'));
        createSelectOfSingleAnswer(question)
        customSelectActive();
    } else {
        return
    }
}
// функция которая делает селект из ответов в предыдущих вопросах
export function createSelectOfSingleAnswer(question) {
    if (question.find('.single-options-box').length) {
        let targetAnswer = question.find('.radio-item textarea')
        let targetAnswerSelect = question.find('.single-answer-select')
        let targetAnswerList = targetAnswerSelect.parents('.single-answer').find('ul')
        targetAnswerSelect.html("")
        targetAnswerList.html("")
        for (let i = 0; i < targetAnswer.length; i++) {
            let optionAnswer = `<option value="${$(targetAnswer[i]).val()}">${$(targetAnswer[i]).val()}</option>`;
            let liAnswer = `<li rel="${$(targetAnswer[i]).val()}">${$(targetAnswer[i]).val()}</li>`
            targetAnswerSelect.append(optionAnswer)
            targetAnswerList.append(liAnswer)
        }
    }
    customSelectActive();
}

export function removeSingleOptionBlock(question, singleOption, singleOptionsCount) {
    if (singleOptionsCount > 1) {
        singleOption.remove();
    } else {
        question.find('.single-options-box').remove();
        question.find('.add-single-option').prop('checked', false);
    }
}

export function removeSingleChoiceBlock(question, singleOption, singleOptionsCount) {
    if (singleOptionsCount > 1) {
        singleOption.remove();
    } else {
        question.find('.single-options-box-choice').remove();
        question.find('.add-single-choice').prop('checked', false);
    }
}


export function refreshSingleElemNames(question) {
    let id = $(question).attr('data-id');
    let singleOptions = question.find('.single-options-box .single-option');

    for (let i = 0; i < singleOptions.length; i++) {
        singleOptions[i].setAttribute('data-id', `${id}_${i + 1}`)
        $(singleOptions[i]).find('.added-question-box .question-wrap').data('id', `${id}_${i + 1}`)
        $(singleOptions[i]).find('.added-question-box .question-wrap .question-name textarea').val(i + 1)
    }
}

export function refreshSingleChoiceElemNames(question) {
    let id = $(question).attr('data-id');
    let singleOptions = question.find('.single-options-box-choice .single-option-choice');

    for (let i = 0; i < singleOptions.length; i++) {
        singleOptions[i].setAttribute('data-id', `${id}_${i + 1}`)
        $(singleOptions[i]).find('.added-question-box .question-wrap').data('id', `${id}_${i + 1}`)
        $(singleOptions[i]).find('.added-question-box .question-wrap .question-name textarea').val(i + 1)
    }
}

export function moveToQuestionFromSingle(question, targetOption) {
    let allQuestions = $('.question-wrap');
    allQuestions = allQuestions.filter((id, el) => {
        return $(el)[0].dataset.id != $(question)[0].dataset.id
    })
    let optionsHTML = ''
    for (let i = 0; i < allQuestions.length; i++) {
        optionsHTML += `<option data-id="${allQuestions[i].dataset.id}" value="${$(allQuestions[i]).find('.question-name textarea').val()}" >${$(allQuestions[i]).find('.question-name textarea').val()}</option>`
    }
    let toQuestionHTML =
        `<div class="single-select single-to-question-select">
            <select class="customselect to-question-select">
                ${optionsHTML}
            </select>
        </div>`;
    $(toQuestionHTML).insertBefore($(targetOption).find('.add-new-single-option'));
    customSelectActive();
}

export function moveToChapterFromSingle(question, targetOption) {
    let allChapters = $('.chapter-wrapper');
    allChapters = allChapters.filter((id, el) => {
        return $(el)[0].dataset.index != $(question.parents('.chapter-wrapper'))[0].dataset.index
    })
    let optionsHTML = ''
    for (let i = 0; i < allChapters.length; i++) {
        optionsHTML += `<option data-id="${allChapters[i].dataset.index}" value="${$(allChapters[i]).find('.chapter-desciption-wrapper textarea').val()}" >${$(allChapters[i]).find('.chapter-desciption-wrapper textarea').val()}</option>`
    }
    let toChapterHTML =
        `<div class="single-select single-to-chapter-select">
            <select class="customselect to-chapter-select">
                ${optionsHTML}
            </select>
        </div>`;
    $(toChapterHTML).insertBefore($(targetOption).find('.add-new-single-option'));
    customSelectActive();
}

export function hideQuestionFromSingle(question, targetOption) {
    let allQuestions = $('.question-wrap');
    allQuestions = allQuestions.filter((id, el) => {
        return $(el)[0].dataset.id != $(question)[0].dataset.id
    })
    let optionsHTML = ''
    for (let i = 0; i < allQuestions.length; i++) {
        optionsHTML += `<option data-id="${allQuestions[i].dataset.id}" value="${$(allQuestions[i]).find('.question-name textarea').val()}" >${$(allQuestions[i]).find('.question-name textarea').val()}</option>`
    }
    let toQuestionHTML =
        `<div class="single-select single-hide-question-select">
            <select class="customselect hide-question-select" multiple="multiple">
                ${optionsHTML}
            </select>
        </div>`;
    $(toQuestionHTML).insertBefore($(targetOption).find('.add-new-single-option'));
    customSelectActive();
}

export function hideChapterFromSingle(question, targetOption) {
    let allChapters = $('.chapter-wrapper');
    allChapters = allChapters.filter((id, el) => {
        return $(el)[0].dataset.index != $(question.parents('.chapter-wrapper'))[0].dataset.index
    })
    let optionsHTML = ''
    for (let i = 0; i < allChapters.length; i++) {
        optionsHTML += `<option data-id="${allChapters[i].dataset.index}" value="${$(allChapters[i]).find('.chapter-desciption-wrapper textarea').val()}" >${$(allChapters[i]).find('.chapter-desciption-wrapper textarea').val()}</option>`
    }
    let toChapterHTML =
    `<div class="single-select single-hide-chapter-select">
        <select class="customselect hide-question-select" multiple="multiple">
            ${optionsHTML}
        </select>
    </div>`;
    $(toChapterHTML).insertBefore($(targetOption).find('.add-new-single-option'));
    customSelectActive();
}

export function askAditionalQuestionFromSingle(question, targetOption) {
    let allQuestions = $('.listbox .list-item');
    let optionsHTML = ''
    for (let i = 0; i < allQuestions.length; i++) {
        optionsHTML += `<option data-id="${allQuestions[i].dataset.type}" value="${allQuestions[i].dataset.type}" >${$(allQuestions[i]).find('.name').html()}</option>`
    }
    let addQuestionHTML =
        `<div class="single-ask-aditional-question">
            <select class="customselect ask-aditional-question">
                <option value="">${vars.viberiteTipVoprosa}</option>
                ${optionsHTML}
            </select>
        </div>`;
    let boxQuestionHTML = `<div class="added-question-box"></div>`
    $(addQuestionHTML).insertAfter($(targetOption).find('.single-action'));
    $(boxQuestionHTML).insertBefore($(targetOption).find('.add-new-single-option'));
    customSelectActive();
}

export function completePollFromSingle(question, targetOption) {
    let toQuestionHTML =
        `<div class="single-complete-poll">
            <textarea placeholder="${vars.vvediteTextSmsObIskluchenie}"></textarea>
        </div>`;
    $(toQuestionHTML).insertBefore($(targetOption).find('.add-new-single-option'));
}

export function createSingleMultipleBlock(question) {
    let singleMultipleBlock =
        `<div class="single-multiple-box">
            <div class="single-multiple-row">
                <span class="label">${vars.ustanovitKolvoVibranihVariantov}</span>
                <span class="single-label">${vars.ot}</span>
                <div class="single-multiple-value">
                    <select class="customselect multiple-value-select">
                        <option selected value="">-</option>
                    </select>
                </div>
                <span class="single-label">${vars.do}</span>
                <div class="single-multiple-value">
                    <select class="customselect multiple-value-select">
                        <option selected value="">-</option>
                    </select>
                </div>
            </div>
            <div class="single-multiple-row">
                <input type="text" placeholder="${vars.vvediteTextSmsObOshibke}"/>
            </div>
        </div>`;
    $(singleMultipleBlock).insertAfter($(question).find('.single-multiple-row'));
    countOfSingleAnswer(question)
}

export function countOfSingleAnswer(question) {
    if (question.find('.single-multiple-box').length) {
        let targetAnswer = question.find('.radio-item textarea')
        let targetMultipleSelect = question.find('.multiple-value-select')
        let targetMultipleList = targetMultipleSelect.parents('.single-multiple-value').find('ul')
        targetMultipleSelect.html("<option selected value>-</option>")
        targetMultipleList.html("")

        for (let i = 0; i < targetAnswer.length; i++) {
            let optionMultip = `<option value="${i+1}">${i+1}</option>`;
            let liMultip = `<li rel="${i+1}">${i+1}</li>`
            targetMultipleSelect.append(optionMultip)
            targetMultipleList.append(liMultip)
        }
    }
    customSelectActive();
}

export function checkSingleDiapason(question) {
    let multipleBox = $(question).find('.single-multiple-box');
    let singleMultipleSelect = $(question).find('.multiple-value-select');
    const v1 = parseInt($(singleMultipleSelect[0]).val());
    const v2 = parseInt($(singleMultipleSelect[1]).val());

    const diapasonErrorMessageBlock = `
    <div class="single-multiple-row">
        <p class="diapason-error">${vars.ukazanieUslovieNeVernoOtBolsheZaDo}</p>
    </div>`;

    if (v1 > v2 && isNaN(v2) == false) {
        if (!$('.single-multiple-box .diapason-error').length) {
            multipleBox.append(diapasonErrorMessageBlock)
        }
    } else {
        multipleBox.find('.diapason-error').parent().remove()
    }
}

export function removeAnswerImgSingle(el) {
    let answer = $(el).parents('.radio-item');
    let fileWrap = $(answer[0]).find('.added-question-img-wrap');
    fileWrap.remove();
}
