//!new file  type of questions nps end scale functions

export function addScalePicture(question) {
    let amount = question.find('.scale-amount').length ? question.find('.scale-amount').val() : 10;
    console.log(amount)
    if (amount === 'yesNot') {
        amount = 2;
    } else {
        amount = parseInt(amount);
    }
    let questionId = question.attr('data-id');
    let scaleHtml = `<div class="scale-wrap scale-star scale-10">`;
    if (question[0].classList.contains('nps-question-scale')) {
        for (let i = amount; i >= 1; i--) {
            scaleHtml +=
                `<input type="radio" id="npsscale_${questionId}_${i}" name="nps_${questionId}" value="10" />
                <label for="npsscale_${questionId}_${i}" title="text"></label>`;
        }
        scaleHtml +=
            `</div>`;
    } else {
        for (let i = amount; i >= 1; i--) {
            scaleHtml +=
                `<input type="radio" id="scale_${questionId}_${i}" name="scale_${questionId}" value="10" />
            <label for="scale_${questionId}_${i}" title="text"></label>`;
        }
        scaleHtml +=
            `</div>`;
    }


    let optionsHtmlScale =
        `<div class="switch-row">
            <div class="label">
                Метки рейтинга
            </div>
            <label class="switch">
                <input type="checkbox" class="add-rateLabels" name="rateLabels_${questionId}" id="rateLabels_${questionId}">
                <span class="slider round"></span>
            </label>
        </div>`;
    let optionsHtmlNPS =
        `<div class="switch-row">
            <div class="label">
                Метки рейтинга
            </div>
            <label class="switch">
                <input type="checkbox" class="add-nps-rateLabels" name="rateLabels_${questionId}" id="rateLabels_${questionId}">
                <span class="slider round"></span>
            </label>
        </div>`;
    if (question.find('.diapason-answer').length > 0) {
        question.find('.diapason-answer').remove();
    }
    if (question.find('.scale-wrap').length === 0) {
        // $(scaleHtml).appendTo('.question-content');
        $(scaleHtml).insertAfter($(question).find('.question-content .question-name'));
    }
    if (question.find('.add-rateLabels').length === 0 && question[0].classList.contains('nps-question-scale') == false) {
        $(optionsHtmlScale).appendTo(question.find('.scale-options'));
    }
    if (question.find('.add-nps-rateLabels').length === 0 && question[0].classList.contains('nps-question-scale') == true) {
        $(optionsHtmlNPS).appendTo(question.find('.scale-options'));
    }
    setClassForScale(question);
}

export function addScaleDiapason(question) {
    question.find('.scale-wrap').remove();
    question.find('.scale-labels-wrap').remove();
    if (question[0].classList.contains('nps-question-scale')) {
        question.find('.add-nps-rateLabels').parents('.switch-row').remove();
    } else {
        question.find('.add-rateLabels').parents('.switch-row').remove();
    }
    question.find('.labels-option').remove();
    if ($(question).find('.diapason-answer').length === 0) {
        let diapasonHtml =
            `<div class="diapason-answer">
            <div class="diapason">
                <div class="label">
                    <div class="value">0</div>
                </div>
                <div class="input-box">
                    <input class="input-range" type="range" min="1" max="10" step="1" value="0"/>
                    <div class="bar"></div>
                    <div class="bar-filled"></div>
                </div>
            </div>
        </div>`
        $(diapasonHtml).insertAfter($(question).find('.question-content .question-name'));
    }
}

//set width for input range background
export function setRangeBackground() {
    let ranges = $('.input-range');
    if (ranges.length > 0) {
        for (let i = 0; i < ranges.length; i++) {
            let barFilled = $(ranges[i]).parents('.question-wrap').find('.bar-filled');
            let barLenght = $(ranges[i]).width();
            barFilled.css('background-size', barLenght + 'px');
        }
    }
}

//set new diapsson value
export function setDiapasonValue(input) {
    var relvalue = 0;
    var value = $(input).val();
    var max = $(input).attr('max');
    var min = $(input).attr('min');
    let range = max - min;
    relvalue = value - min;
    var percent = (100 / range) * relvalue;
    var parents = $(input).parents('.diapason');
    var paddleft = (60 * percent) / 100;
    parents.find('.label').css('left', 'calc(' + percent + '% - ' + paddleft + 'px)');
    parents.find('.label .value').html(value);
    parents.find('.input-box .bar-filled').css('width', percent + '%');
    parents.find('.label').css('background-position', percent + '%');
};

//set max value for diapason
export function setDiapasonMax(question) {
    let diapsonInput = question.find('.input-range');
    let max = 0;
    let min = 0

    if (question[0].classList.contains('nps-question-scale')) {
        max = parseInt(question.find('.scale-amount').val());
        diapsonInput.attr('min', min);
        diapsonInput.val(0);
    } else {
        max = parseInt(question.find('.scale-amount').val());
    }
    if (max > 0) {
        diapsonInput.attr('max', max);
        let diapasonValue = parseInt(diapsonInput.val());
        if (max < diapasonValue) {
            diapsonInput.val(max)
        }
        setDiapasonValue(diapsonInput)
    }
}

//add class to scale-wrap
export function setClassForScale(question) {
    let type = question.find('.scale-type').val();
    let amount = question.find('.scale-amount').length ? question.find('.scale-amount').val() : 10;
    let scaleWrap = question.find('.scale-wrap');
    let labelWrap = question.find('.scale-labels-wrap');
    let classList = 'scale-wrap ' + 'scale-' + amount;
    let classListLabel = 'scale-labels-wrap ' + 'scale-' + amount;
    switch (type) {
        case 'star':
            classList += ' scale-star'
            break;
        case 'face':
            classList += ' scale-face'
            break;
        case 'heart':
            classList += ' scale-heart'
            break;
        case 'hand':
            classList += ' scale-hands'
            break;
    }
    scaleWrap.attr('class', classList);
    labelWrap.attr('class', classListLabel);
}

//add scale list
export function addScaleRate(scaleWrap, amount, questionId) {
    let scaleHtml = '';
    for (let i = 1; i <= amount; i++) {
        scaleHtml +=
            `<input type="radio" id="scale_${questionId}_${i}" name="scale_${questionId}" value="${i}" />
         <label for="scale_${questionId}_${i}" title="text"></label>`;
    }
    scaleWrap.html(scaleHtml);
}

//add scale list for nps question
export function addNPSscaleRate(scaleWrap, amount, questionId) {
    let scaleHtml = '';
    for (let i = 0; i <= amount - 1; i++) {
        scaleHtml +=
            `<input type="radio" id="scale_${questionId}_${i}" name="scale_${questionId}" value="${i}" />
         <label for="scale_${questionId}_${i}" title="text"></label>`;
    }
    scaleWrap.html(scaleHtml);
}

//change amount of labels under rate
export function changeAmountLabel(question) {
    let amount = parseInt(question.find('.scale-amount').val());
    let questionId = question.attr('data-id');
    let labelOptionsWrap = question.find('.labels-option');
    let labelsOption = labelOptionsWrap.children();
    let labelScaleWrap = question.find('.scale-labels-wrap');
    let labelsScale = labelScaleWrap.children();
    if (amount > labelsOption.length) {
        for (let i = labelsOption.length + 1; i < amount + 1; i++) {
            if (!labelsOption[i]) {
                let labelHtml =
                    `<div class="label-item">
                        <div class="number">${i}</div>
                        <div class="value">
                            <input type="text" name="inputpoint_${questionId}_${i}">
                        </div>
                    </div>`;
                labelOptionsWrap.append(labelHtml);
                let labelScaleHtml = `<div class="label-item"></div>`;
                labelScaleWrap.append(labelScaleHtml);
            }
        }
    } else {
        for (let i = amount; i < labelsOption.length; i++) {
            labelsOption[i].remove();
            labelsScale[i].remove();
        }
    }
}

//change amount of labels under NPS rate
export function changeNPSamountLabel(question) {
    let amount = question.find('.scale-amount').length ? parseInt(question.find('.scale-amount').val()) + 1 : 10;
    let questionId = question.attr('data-id');
    let labelOptionsWrap = question.find('.labels-option');
    let labelsOption = labelOptionsWrap.children();
    let labelScaleWrap = question.find('.scale-labels-wrap');
    let labelsScale = labelScaleWrap.children();
    if (amount > labelsOption.length) {
        for (let i = labelsOption.length + 1; i < amount + 1; i++) {
            if (!labelsOption[i]) {
                let labelHtml =
                    `<div class="label-item">
                        <div class="number">${i}</div>
                        <div class="value">
                            <input type="text" name="inputpoint_${questionId}_${i}">
                        </div>
                    </div>`;
                labelOptionsWrap.append(labelHtml);
                let labelScaleHtml = `<div class="label-item"></div>`;
                labelScaleWrap.append(labelScaleHtml);
            }
        }
    } else {
        for (let i = amount; i < labelsOption.length; i++) {
            labelsOption[i].remove();
            labelsScale[i].remove();
        }
    }
}

/* Activate NPS quastion options adding */
export function createNpsOptionBlock(question, npsOptionName, npsScaleCount) {
    let selectOptionsHTML = '';
    for (let i = 1; i <= npsScaleCount; i++) {
        selectOptionsHTML += `<option value="${i}">${i}</option>`
    }
    let npsOptionBlock =
        `<div class="nps-options-box">
            <div class="nps-option">
                <div class="scale-property-row">
                    <span class="scale-property-name">${vars.pokazateliSkali}</span>
                    <div class="nps-diapason-start nps-diapason-box">
                        <span>${vars.ot}</span>   
                        <div class="option-value">
                            <select name="npsDiapasoneStart_${npsOptionName}_1" class="customselect" data-required>
                                <option selected value="">-</option>
                                ${selectOptionsHTML}
                            </select>
                        </div>
                    </div>
                    <div class="nps-diapason-end nps-diapason-box">
                        <span>${vars.do}</span>   
                        <div class="option-value">
                            <select name="npsDiapasoneEnd_${npsOptionName}_1" class="customselect" data-required>
                                <option selected value="">-</option>
                                ${selectOptionsHTML}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="scale-property-row">
                    <span class="scale-property-name">${vars.deystvie}</span>
                    <div class="nps-action-box"> 
                        <div class="option-value">
                            <select name="npsAction_${npsOptionName}_1" class="customselect select-nps-action" data-required>
                                <option selected value="">${vars.vibratDeystvie}</option>
                                <option value="add_free_answer">${vars.dobavitOtkritiyVopros}</option>
                                <option value="finish_survey">${vars.zakonchitOpros}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="remove-nps-option"></div>
                <p class="add-new-option">${vars.dobavitOpciyu}</p>
            </div>
        </div>`;
    $(npsOptionBlock).insertAfter($(question).find('.nps-option-row'));
    customSelectActive();
}
/* Activate scale quastion options adding */
export function createScaleOptionBlock(question, scaleOptionName, scaleCount) {
    let selectOptionsHTML = '';
    for (let i = 0; i <= scaleCount; i++) {
        selectOptionsHTML += `<option value="${i}">${i}</option>`
    }

    let scaleOptionBlock =
        `<div class="scale-options-box">
            <div class="scale-option">
                <div class="scale-property-row">
                    <span class="scale-property-name">${vars.pokazateliSkali}</span>
                    <div class="scale-diapason-start scale-diapason-box">
                        <span>${vars.ot}</span>   
                        <div class="option-value">
                            <select name="scaleDiapasoneStart_${scaleOptionName}_1" class="customselect" data-required>
                                <option selected value="">-</option>
                                ${selectOptionsHTML}
                            </select>
                        </div>
                    </div>
                    <div class="scale-diapason-end scale-diapason-box">
                        <span>${vars.do}</span>   
                        <div class="option-value">
                            <select name="scaleDiapasoneEnd_${scaleOptionName}_1" class="customselect" data-required>
                                <option selected value="">-</option>
                                ${selectOptionsHTML}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="scale-property-row">
                    <span class="scale-property-name">${vars.deystvie}</span>
                    <div class="scale-action-box"> 
                        <div class="option-value">
                            <select name="scaleAction_${scaleOptionName}_1" class="customselect select-scale-action" data-required>
                                <option selected value="">${vars.vibratDeystvie}</option>
                                <option value="add_free_answer">${vars.dobavitOtkritiyVopros}</option>
                                <option value="finish_survey">${vars.zakonchitOpros}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="remove-scale-option"></div>
                <p class="add-new-scale-option">${vars.dobavitOpciyu}</p>
            </div>
        </div>`;
    $(scaleOptionBlock).insertAfter($(question).find('.scale-option-row'));
    customSelectActive();
}

export function createNpsOption(question, npsOptionName, npsNameIndex, npsOptionsCount, newNpsOptionsCount, npsScaleCount) {
    npsNameIndex = ($(question).find('.nps-option').length) + 1;
    let selectOptionsHTML = '';
    for (let i = 0; i <= npsScaleCount; i++) {
        selectOptionsHTML += `<option value="${i}">${i}</option>`
    }
    let npsOption =
        `<div class="nps-option">
                <div class="scale-property-row">
                    <span class="scale-property-name">${vars.pokazateliSkali}</span>
                    <div class="nps-diapason-start nps-diapason-box">
                        <span>${vars.ot}</span>   
                        <div class="option-value">
                            <select name="npsDiapasoneStart_${npsOptionName}_${npsNameIndex}" class="customselect" data-required>
                                <option selected value="">-</option>    
                                ${selectOptionsHTML}
                            </select>
                        </div>
                    </div>
                    <div class="nps-diapason-end nps-diapason-box">
                        <span>${vars.do}</span>   
                        <div class="option-value">
                            <select name="npsDiapasoneEnd_${npsOptionName}_${npsNameIndex}" class="customselect" data-required>
                                <option selected value="">-</option>
                                ${selectOptionsHTML}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="scale-property-row">
                    <span class="scale-property-name">${vars.deystvie}</span>
                    <div class="nps-action-box"> 
                        <div class="option-value">
                            <select name="npsAction_${npsOptionName}_${npsNameIndex}" class="customselect select-nps-action" data-required>
                                <option selected value="">${vars.vibratDeystvie}</option>
                                <option value="add_free_answer">${vars.dobavitOtkritiyVopros}</option>
                                <option value="finish_survey">${vars.zakonchitOpros}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="remove-nps-option"></div>
                <p class="add-new-option">${vars.dobavitOpciyu}</p>
            </div>`;
    if (newNpsOptionsCount < (npsOptionsCount)) {
        $(npsOption).appendTo($(question).find('.nps-options-box'));
        customSelectActive();
    } else {
        return
    }
}
export function createScaleOption(question, scaleOptionName, scaleCount, scaleOptionsCount, newScaleOptionsCount) {
    let scaleNameIndex = ($(question).find('.scale-option').length) + 1;
    let selectOptionsHTML = '';
    for (let i = 0; i <= scaleCount; i++) {
        selectOptionsHTML += `<option value="${i}">${i}</option>`
    }
    let scaleOption =
        `<div class="scale-option">
            <div class="scale-property-row">
                <span class="scale-property-name">${vars.pokazateliSkali}</span>
                    <div class="scale-diapason-start scale-diapason-box">
                        <span>${vars.ot}</span>   
                        <div class="option-value">
                            <select name="scaleDiapasoneStart_${scaleOptionName}_${scaleNameIndex}" class="customselect" data-required>
                                <option selected value="">-</option>    
                                ${selectOptionsHTML}
                            </select>
                        </div>
                    </div>
                    <div class="scale-diapason-end scale-diapason-box">
                        <span>${vars.do}</span>   
                        <div class="option-value">
                            <select name="scaleDiapasoneEnd_${scaleOptionName}_${scaleNameIndex}" class="customselect" data-required>
                                <option selected value="">-</option>
                                ${selectOptionsHTML}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="scale-property-row">
                    <span class="scale-property-name">${vars.deystvie}</span>
                    <div class="scale-action-box"> 
                        <div class="option-value">
                            <select name="scaleAction_${scaleOptionName}_${scaleNameIndex}" class="customselect select-scale-action" data-required>
                                <option selected value="">${vars.vibratDeystvie}</option>
                                <option value="add_free_answer">${vars.dobavitOtkritiyVopros}</option>
                                <option value="finish_survey">${vars.zakonchitOpros}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="remove-scale-option"></div>
                <p class="add-new-scale-option">${vars.dobavitOpciyu}</p>
            </div>`;

    if (newScaleOptionsCount < scaleOptionsCount) {
        $(scaleOption).appendTo($(question).find('.scale-options-box'));
        customSelectActive();
    } else {
        return
    }
}

export function apdateNpsOptionScale(amount, question) {
    let selectOptions = $(question).find('.nps-diapason-box select');
    let selectOptionsList = $(question).find('.nps-diapason-box .select-options');
    if (selectOptions.length > 0) {
        $(question).find('.nps-diapason-box .select-styled').html('-');
        $(question).find('.nps-diapason-box select').val('');
        $(question).find('.nps-diapason-box select').attr('data-required', '');
        let selectOptionsHTML = '<option selected value="">-</option>';
        let selectOptionItemHTML = '<li rel="" class="">-</li>'
        for (let i = 0; i <= amount - 1; i++) {
            selectOptionsHTML += `<option value="${i}">${i}</option>`;
            selectOptionItemHTML += `<li rel="${i}" class="">${i}</li>`
        }

        for (let i = 0; i < selectOptions.length; i++) {
            selectOptions[i].innerHTML = selectOptionsHTML;
            selectOptionsList[i].innerHTML = selectOptionItemHTML;
        }

        customSelectActive();

    } else {
        return
    }
}

export function checkNpsDiapason(question, globalIncorrectOptionsList) {
    let npsOptions = $(question).find('.nps-option');
    let firstOptionSelect = $(npsOptions[0]).find('.nps-diapason-box select');
    let inCorrectOptionsList = [];

    const v1 = parseInt($(firstOptionSelect[0]).val());
    const v2 = parseInt($(firstOptionSelect[1]).val());
    const selectedAreas = [];
    const diapasonErrorMessage = `<p class="diapason-error">${vars.ukazannitUsloviyaProtivorechatDrugDrugu}</p>`
    if (v1 > v2 && isNaN(v2) == false) {
        let diapasonRows = $(npsOptions[0]).find($('.scale-property-row'));
        if ($(npsOptions[0]).find('.diapason-error').length == 0) {
            $(diapasonErrorMessage).insertAfter($(diapasonRows[0]));
            inCorrectOptionsList.push($(npsOptions[0]));

        } else {
            return
        }

    } else {
        selectedAreas.push([v1, v2]);
        $(npsOptions[0]).find('.diapason-error').remove();
    }

    for (let i = 0; i < npsOptions.length; i++) {
        let currentOptionSelect = $(npsOptions[i]).find('.nps-diapason-box select');
        let currentFromVal = parseInt($(currentOptionSelect[0]).val());
        let currenToVal = parseInt($(currentOptionSelect[1]).val());
        if (currentFromVal > currenToVal && isNaN(currenToVal) == false) {
            let diapasonRows = $(npsOptions[i]).find($('.scale-property-row'));
            if ($(npsOptions[i]).find('.diapason-error').length == 0) {
                $(diapasonErrorMessage).insertAfter($(diapasonRows[0]));
                inCorrectOptionsList.push($(npsOptions[i]));
            }
        } else if (i != 0) {
            let isValid = true;
            selectedAreas.forEach(v => {
                if (currentFromVal <= v[1] && currenToVal >= v[0]) {
                    isValid = false;
                }
            });
            if (isValid) {
                selectedAreas.push([currentFromVal, currenToVal]);
                $(npsOptions[i]).find('.diapason-error').remove();

            } else {

                inCorrectOptionsList.push(npsOptions[i]);
                let diapasonRows = $(npsOptions[i]).find($('.scale-property-row'));
                if ($(npsOptions[i]).find('.diapason-error').length == 0) {
                    $(diapasonErrorMessage).insertAfter($(diapasonRows[0]));
                }
            }
        }
    }
    globalIncorrectOptionsList = inCorrectOptionsList;
}
export function checkScaleDiapason(question) {
    let scaleOptions = $(question).find('.scale-option');
    let firstOptionSelect = $(scaleOptions[0]).find('.scale-diapason-box select');

    const v1 = parseInt($(firstOptionSelect[0]).val());
    const v2 = parseInt($(firstOptionSelect[1]).val());
    const diapasonErrorMessage = `<p class="diapason-error">${vars.ukazannitUsloviyaProtivorechatDrugDrugu}</p>`
    if (v1 > v2 && isNaN(v2) == false) {
        let diapasonRows = $(scaleOptions[0]).find($('.scale-property-row'));
        if ($(scaleOptions[0]).find('.diapason-error').length == 0) {
            $(diapasonErrorMessage).insertAfter($(diapasonRows[0]));

        } else {
            return
        }

    } else {
        $(scaleOptions[0]).find('.diapason-error').remove();
    }
}

export function scaleFreeAnswer(question) {
    let id = $(question).attr('data-id');
    let checkComment = $(question).find('.free-answers').length;
    let checkLabels = $(question).find('.scale-labels-wrap').length;
    if (checkComment === 0) {
        let scaleFreeAnswerTemplate =
            `<div class="free-answers">
                <div class="answer-wrap">
                    <textarea name="scale${id}" rows="1" placeholder="${vars.vvediteVashComment}"></textarea>
                </div>
            </div>`;
        if (checkLabels === 0) {
            $(scaleFreeAnswerTemplate).insertAfter($(question).find('.scale-wrap'));
        } else {
            $(scaleFreeAnswerTemplate).insertAfter($(question).find('.scale-labels-wrap'));
        }
        $(scaleFreeAnswerTemplate).insertAfter($(question).find('.diapason-answer'));
        $(question).find('.free-answers').find('textarea').autoResize();
    } else {
        return
    }
}
export function npsFreeAnswer(question) {
    let id = $(question).attr('data-id');
    let checkComment = $(question).find('.free-answers').length;
    let checkLabels = $(question).find('.scale-labels-wrap').length;
    if (checkComment === 0) {
        let npsFreeAnswerTemplate =
            `<div class="free-answers">
                <div class="answer-wrap">
                    <textarea name="nps${id}" rows="1" placeholder="${vars.vvediteVashComment}"></textarea>
                </div>
            </div>`;
        if (checkLabels === 0) {
            $(npsFreeAnswerTemplate).insertAfter($(question).find('.scale-wrap'));
        } else {
            $(npsFreeAnswerTemplate).insertAfter($(question).find('.scale-labels-wrap'));
        }
        $(npsFreeAnswerTemplate).insertAfter($(question).find('.diapason-answer'));
        $(question).find('.free-answers').find('textarea').autoResize();
    } else {
        return
    }
}

export function removeNpsOption(question, npsOption, npsOptionsCount) {
    if (npsOptionsCount > 1) {
        npsOption.remove();
        checkNpsDiapason(question);
    } else {
        question.find('.nps-options-box').remove();
        question.find('.free-answers').remove();
        question.find('.addNpsOption').prop('checked', false);
    }
}
export function removeScaleOption(question, scaleOption, scaleOptionsCount) {
    if (scaleOptionsCount > 1) {
        scaleOption.remove();
    } else {
        question.find('.scale-options-box').remove();
        //question.find('.free-answers').remove();
        question.find('.add-scale-option').prop('checked', false);
    }
}

export function refreshNpsElemNames(question) {
    let id = $(question).attr('data-id');
    let npsOptions = question.find('.nps-options-box .nps-option');
    let diapasonStart = question.find('.nps-diapason-start select');
    let diapasonEnd = question.find('.nps-diapason-end select');
    let npsAction = question.find('.nps-action-box select');


    for (let i = 0; i < npsOptions.length; i++) {
        diapasonStart[i].setAttribute('name', `npsDiapasoneStart_${id}_${i + 1}`);
        diapasonEnd[i].setAttribute('name', `npsDiapasoneStart_${id}_${i + 1}`);
        npsAction[i].setAttribute('name', `npsAction_${id}_${i + 1}`);
    }
}
export function refreshScaleElemNames(question) {
    let id = $(question).attr('data-id');
    let scaleOptions = question.find('.scale-options-box .scale-option');
    let diapasonStart = question.find('.scale-diapason-start select');
    let diapasonEnd = question.find('.scale-diapason-end select');
    let scaleAction = question.find('.scale-action-box select');

    for (let i = 0; i < scaleOptions.length; i++) {
        diapasonStart[i].setAttribute('name', `scaleDiapasoneStart_${id}_${i + 1}`);
        diapasonEnd[i].setAttribute('name', `scaleDiapasoneStart_${id}_${i + 1}`);
        scaleAction[i].setAttribute('name', `scaleAction_${id}_${i + 1}`);
    }
}
