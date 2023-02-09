//!new file for type of questions dropdown functions
import {changeNameInput} from './chapters.js'
//set new text for option select
export function setNewText(question, text, index) {
    let select = question.find('.dropdown-wrap select');
    let customSelect = question.find('.dropdown-wrap');
    if (select.find(`option:nth-child(${index})`).length === 0) {
        let selectHtml = `<option value=""></option>`;
        $(selectHtml).insertAfter(select.find(`option:nth-child(${index - 1})`));

        let customSelectHtml = `<li rel=""></li>`;
        $(customSelectHtml).insertAfter(customSelect.find('.select-options').find(`li:nth-child(${index - 1})`));
    }

    if (customSelect.find(`li:nth-child(${index})`).hasClass('active') ||
        (index === 1 && customSelect.find('li.active').length === 0)) {
        if (customSelect.hasClass('customselect-multiple')) {
            let optionVal = customSelect.find(`li:nth-child(${index})`).attr('rel');
            let seletValue = customSelect.find(`.select-styled .selectvalue[data-value="${optionVal}"]`);
            seletValue.attr('data-value', text);
            seletValue.find('.value').text(text);
        } else {
            customSelect.find('.select-styled').html(text);
        }
    }

    select.find(`option:nth-child(${index})`).html(text);
    select.find(`option:nth-child(${index})`).prop('value', text);

    customSelect.find(`li:nth-child(${index})`).html(text);
    customSelect.find(`li:nth-child(${index})`).attr('rel', text);
}

 //add list of dropdown question
export function addListDropdownQuestion() {

    let dropdownList = $('.question-dropdown')

    let arrQuestions = dropdownList.map((id, el)=>{
        return {
            name: $(el).find('.question-name textarea').val(),
            id: $(el)[0].dataset.id
        }
    })
    let selectsQuestionName = $('.inputpoint-customselect-question')
    selectsQuestionName.each(function (id, el) {
        let select = $(el).find('select')
        let customSelect = $(el).find('.select-options')
        $('.inputpoint-customselect-question .select-styled').html("<div class'defaulf'>Выберите вопрос</div>")
        select.html("")
        customSelect.html("")
        arrQuestions.each((id, question)=>{
            if (question.name == $(el).parents('.question-dropdown').find('.question-name textarea').val()) {
                return
            }

            let createdOption = `<option value="${question.name}" data-id="${question.id}">${question.name}</option>`;
            let createdLi = `<li rel="${question.name}" data-id="${question.id}">${question.name}</li>`;
            select.append(createdOption)
            customSelect.append(createdLi)
        })
    })
    customSelectActive();
}

//add new option to select
export function addNewOption(question, className = "", value = "", last = true) {
    let optionList = question.find('.optins-list');
    let questionId = question.attr('data-id');
    let optionId = parseInt(optionList.children().length) + 1;
    let select = question.find('.dropdown-wrap select');
    let customSelect = question.find('.dropdown-wrap');
    if (last === false) {
        optionId = optionId - 1;
    }
    let optionHtml =
        `<div class="option-item ${className}">
            <div class="inputpoint-body">
                <div class="number">${optionId}.</div>
                <div class="value">
                    <input type="text" name="inputpoint_${questionId}_${optionId}" value="${value}">
                    <div class="icons-box">
                        <div class="watch-options"></div>
                        <div class="remove-dropdown-el"></div>
                    </div>
                </div>
            </div>
            <div class="inputpoint-visability">
                <div class="switch-row">
                    <label class="switch">
                        <input type="checkbox" name="inputpoint-visability_${questionId}_${optionId}"/>
                        <span class="slider round"></span>
                    </label> 
                    <div class="label">Скрыть альтернативу при выборе в вопросе</div>
                    <div class="inputpoint-customselect-question">
                        <select class="customselect">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="label">варианта</div>
                    <div class="inputpoint-customselect-answer">
                        <select class="customselect" multiple="multiple">
                            <option value=""></option>
                        </select>
                    </div>
                </div>                   
            </div>
        </div>`;
    $(optionHtml).insertAfter(optionList.find(`.option-item:nth-child(${optionId - 1})`));
    let selectHtml = `<option value="${value}"></option>`;
    $(selectHtml).insertAfter(select.find(`option:nth-child(${optionId - 1})`));

    let customSelectHtml = `<li rel="${value}">${value}</li>`;
    $(customSelectHtml).insertAfter(customSelect.find('.select-options').find(`li:nth-child(${optionId - 1})`));
    customSelectActive();
    addListDropdownQuestion()
}

//remove option from select
export function removeDropdownOption(question, optionId) {
    let optionList = question.find('.optins-list');
    let select = question.find('.dropdown-wrap select');
    let customSelect = question.find('.customselect-wrapper');
    if (select.find(`option:nth-child(${optionId})`).length != 0) {
        select.find(`option:nth-child(${optionId})`).remove();
    }
    if (customSelect.find(`li:nth-child(${optionId})`).length != 0) {
        if (customSelect.find(`li:nth-child(${optionId})`).hasClass('active')) {
            customSelect.find(`li:nth-child(${optionId})`).click();
        }
        customSelect.find(`li:nth-child(${optionId})`).remove();
    }
    if (optionList.find(`.option-item:nth-child(${optionId})`).length != 0) {
        optionList.find(`.option-item:nth-child(${optionId})`).remove();
    }
    refreshDropdownInputs(question.find('.optins-list'));
}

//refresh ids for input
export function refreshDropdownInputs(optionList) {
    let options = optionList.children();
    for (let i = 0; i < options.length; i++) {
        let id = i + 1;
        $(options[i]).find('.number').html(`${id}.`);
        let inputs = $(options[i]).find('input');
        changeNameInput(inputs, id, 2);
    }
}

export function createDropdownOptionBlock(question, dropdownName) {
    let dropdownOptionBlock =
        `<div class="dropdown-options-box">
            <div class="dropdown-option" data-id="${dropdownName}_1">
                <div class="dropdown-property-row">
                    <span class="dropdown-lable">При выборе варианта</span>
                    <div class="dropdown-answer">
                        <select class="customselect dropdown-answer-select">
                            <option value=""></option>
                        </select>
                    </div>
                    <span class="dropdown-lable">выполнить действие</span>
                    <div class="dropdown-action">
                        <select class="customselect dropdown-action-select">
                            <option selected value="">Выбрать действие</option>
                            <option value="move-to-question">Перейти к вопросу</option>
                            <option value="move-to-chapter">Перейти к разделу</option>
                            <option value="hide-question">Скрыть вопросы</option>
			    <option value="hide-chapter">Скрыть разделы</option>
                            <option value="ask-additional-question">Задать дополнительный вопрос</option>
                            <option value="complete-poll">Завершыть опрос</option>
                        </select>
                    </div>
                    <div class="remove-dropdown-option"></div>
                </div>
                <p class="add-new-dropdown-option">Добавить опцию</p>
            </div>
        </div>`;
    $(dropdownOptionBlock).insertAfter($(question).find('.dropdown-option-row'));
    createSelectOfDropdownAnswer(question)
    customSelectActive();
}

export function createSelectOfDropdownAnswer(question) {
    if (question.find('.dropdown-options-box').length) {
        let targetAnswer = question.find('.dropdown-wrap select option:not(:last-child)')
        let targetAnswerSelect = question.find('.dropdown-answer-select')
        let targetAnswerList = targetAnswerSelect.parents('.dropdown-answer').find('ul')
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

export function createDropdownOption(question, dropdownOptionName, dropdownOptionsCount, newDropdownOptionsCount) {
    let dropdownNameIndex = ($(question).find('.dropdown-option').length) + 1;
    let dropdownOption =
        `<div class="dropdown-option" data-id="${dropdownOptionName}_${dropdownNameIndex}">
            <div class="dropdown-property-row">
                <span class="dropdown-lable">При выборе варианта</span>
                <div class="dropdown-answer">
                    <select class="customselect dropdown-answer-select">
                        <option value=""></option>
                    </select>
                </div>
                <span class="dropdown-lable">выполнить действие</span>
                <div class="dropdown-action">
                    <select class="customselect dropdown-action-select">
                        <option value="move-to-question">Перейти к вопросу</option>
                        <option value="move-to-chapter">Перейти к разделу</option>
                        <option value="hide-question">Скрыть вопросы</option>
			<option value="hide-chapter">Скрыть разделы</option>
                        <option value="ask-additional-question">Задать дополнительный вопрос</option>
                        <option value="complete-poll">Завершыть опрос</option>
                    </select>
                </div>
                <div class="remove-dropdown-option"></div>
            </div>
            <p class="add-new-dropdown-option">Добавить опцию</p>
        </div>`;

    if (newDropdownOptionsCount < dropdownOptionsCount) {
        $(dropdownOption).appendTo($(question).find('.dropdown-options-box'));
        createSelectOfDropdownAnswer(question)
        customSelectActive();
    } else {
        return
    }
}

export function removeDropdownOptionBlock(question, dropdownOption, dropdownOptionsCount) {
    if (dropdownOptionsCount > 1) {
        dropdownOption.remove();
    } else {
        question.find('.dropdown-options-box').remove();
        question.find('.add-dropdown-option').prop('checked', false);
    }
}

export function refreshDropdownElemNames(question) {
    let id = $(question).attr('data-id');
    let dropdownOptions = question.find('.dropdown-options-box .dropdown-option');

    for (let i = 0; i < dropdownOptions.length; i++) {
        dropdownOptions[i].setAttribute('data-id', `${id}_${i + 1}`)
    }
}

export function moveToQuestionFromDropdown(question, targetOption) {
    let allQuestions = $('.question-wrap');
    allQuestions = allQuestions.filter((id, el) => {
        return $(el)[0].dataset.id != $(question)[0].dataset.id
    })
    let optionsHTML = ''
    for (let i = 0; i < allQuestions.length; i++) {
        optionsHTML += `<option data-id="${allQuestions[i].dataset.id}" value="${$(allQuestions[i]).find('.question-name textarea').val()}" >${$(allQuestions[i]).find('.question-name textarea').val()}</option>`
    }
    let toQuestionHTML =
        `<div class="dropdown-select dropdown-to-question-select">
            <select class="customselect to-question-select">
                ${optionsHTML}
            </select>
        </div>`;
    $(toQuestionHTML).insertBefore($(targetOption).find('.add-new-dropdown-option'));
    customSelectActive();
}

export function moveToChapterFromDropdown(question, targetOption) {
    let allChapters = $('.chapter-wrapper');
    allChapters = allChapters.filter((id, el) => {
        return $(el)[0].dataset.index != $(question.parents('.chapter-wrapper'))[0].dataset.index
    })
    let optionsHTML = ''
    for (let i = 0; i < allChapters.length; i++) {
        optionsHTML += `<option data-id="${allChapters[i].dataset.index}" value="${$(allChapters[i]).find('.chapter-desciption-wrapper textarea').val()}" >${$(allChapters[i]).find('.chapter-desciption-wrapper textarea').val()}</option>`
    }
    let toChapterHTML =
        `<div class="dropdown-select dropdown-to-chapter-select">
            <select class="customselect to-chapter-select">
                ${optionsHTML}
            </select>
        </div>`;
    $(toChapterHTML).insertBefore($(targetOption).find('.add-new-dropdown-option'));
    customSelectActive();
}

export function hideQuestionFromDropdown(question, targetOption) {
    let allQuestions = $('.question-wrap');
    allQuestions = allQuestions.filter((id, el) => {
        return $(el)[0].dataset.id != $(question)[0].dataset.id
    })
    let optionsHTML = ''
    for (let i = 0; i < allQuestions.length; i++) {
        optionsHTML += `<option data-id="${allQuestions[i].dataset.id}" value="${$(allQuestions[i]).find('.question-name textarea').val()}" >${$(allQuestions[i]).find('.question-name textarea').val()}</option>`
    }
    let toQuestionHTML =
        `<div class="dropdown-select dropdown-hide-question-select">
            <select class="customselect hide-question-select" multiple="multiple">
                ${optionsHTML}
            </select>
        </div>`;
    $(toQuestionHTML).insertBefore($(targetOption).find('.add-new-dropdown-option'));
    customSelectActive();
}

export function hideChapterFromDropdown(question, targetOption) {
    let allChapters = $('.chapter-wrapper');
    allChapters = allChapters.filter((id, el) => {
        return $(el)[0].dataset.index != $(question.parents('.chapter-wrapper'))[0].dataset.index
    })
    let optionsHTML = ''
    for (let i = 0; i < allChapters.length; i++) {
        optionsHTML += `<option data-id="${allChapters[i].dataset.index}" value="${$(allChapters[i]).find('.chapter-desciption-wrapper textarea').val()}" >${$(allChapters[i]).find('.chapter-desciption-wrapper textarea').val()}</option>`
    }
    let toChapterHTML =
    `<div class="dropdown-select dropdown-hide-chapter-select">
        <select class="customselect hide-question-select" multiple="multiple">
            ${optionsHTML}
        </select>
    </div>`;
    $(toChapterHTML).insertBefore($(targetOption).find('.add-new-dropdown-option'));
    customSelectActive();
}

export function askAditionalQuestionFromDropdown(question, targetOption) {
    let allQuestions = $('.listbox .list-item');
    let optionsHTML = ''
    for (let i = 0; i < allQuestions.length; i++) {
        optionsHTML += `<option data-id="${allQuestions[i].dataset.type}" value="${allQuestions[i].dataset.type}" >${$(allQuestions[i]).find('.name').html()}</option>`
    }

    let addQuestionHTML =
    `<div class="dropdown-ask-aditional-question">
        <select class="customselect ask-aditional-question">
            <option value="">Выберите тип вопроса</option>
            ${optionsHTML}
        </select>
    </div>`;
    let boxQuestionHTML = `<div class="added-question-box"></div>`
    $(addQuestionHTML).insertAfter($(targetOption).find('.dropdown-action'));
    $(boxQuestionHTML).insertBefore($(targetOption).find('.add-new-dropdown-option'));
    customSelectActive();
}

export function completePollFromDropdown(question, targetOption) {
    let toQuestionHTML =
        `<div class="dropdown-complete-poll">
            <textarea placeholder="Введите текст сообщения об исключении респондента из опроса"></textarea>
        </div>`;
    $(toQuestionHTML).insertBefore($(targetOption).find('.add-new-dropdown-option'));
}

export function createDropdownMultipleBlock(question) {
    let dropdownMultipleBlock =
    `<div class="dropdown-multiple-box">
        <div class="dropdown-multiple-row">
            <span class="label">Установить количество выбраных вариантов</span>
            <span class="dropdown-label">От</span>
            <div class="dropdown-multiple-value">
                <select class="customselect multiple-value-select">
                    <option selected value="">-</option>
                </select>
            </div>
            <span class="dropdown-label">До</span>
            <div class="dropdown-multiple-value">
                <select class="customselect multiple-value-select">
                    <option selected value="">-</option>
                </select>
            </div>
        </div>
        <div class="dropdown-multiple-row">
            <input type="text" placeholder="Введите текст сообщения об ошибке"/>
        </div>
    </div>`;
$(dropdownMultipleBlock).insertAfter($(question).find('.dropdown-multiple-row'));
countOfDropdownAnswer(question)
}

export function countOfDropdownAnswer(question) {
    if (question.find('.dropdown-multiple-box').length) {
        let targetAnswer = question.find('.dropdown-wrap select option:not(:last-child)')
        let targetMultipleSelect = question.find('.multiple-value-select')
        let targetMultipleList = targetMultipleSelect.parents('.dropdown-multiple-value').find('ul')
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

export function checkDropdownDiapason(question) {
    let multipleBox = $(question).find('.dropdown-multiple-box');
    let dropdownMultipleSelect = $(question).find('.multiple-value-select');
    const v1 = parseInt($(dropdownMultipleSelect[0]).val());
    const v2 = parseInt($(dropdownMultipleSelect[1]).val());

    const diapasonErrorMessageBlock = `
    <div class="dropdown-multiple-row">
        <p class="diapason-error">Указанные условия противоречат друг-другу. Значение "От" должно быть меньше значения "До"</p>
    </div>`;

    if (v1 > v2 && isNaN(v2) == false) {
        if (!$('.dropdown-multiple-box .diapason-error').length) {
            multipleBox.append(diapasonErrorMessageBlock)
        }
    } else {
        multipleBox.find('.diapason-error').parent().remove()
    }
}
