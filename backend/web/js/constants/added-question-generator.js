export function addedQuestion(question, targetOption, questionType) {
    let id = question.data('id')
    let allOptions = targetOption.parents('.single-options-box').length ? targetOption.parents('.single-options-box').find('.single-option') : targetOption.parents('.dropdown-options-box').find('.dropdown-option')
    let optionId
    for (let i = 0; i < allOptions.length; i++) {
        if (targetOption[0].dataset.id == allOptions[i].dataset.id) {
            optionId = i + 1
        }
    }

    let nameHtml =
        `<div class="question-name">
            <textarea name="question-added_${id}_${optionId}"  rows="1" placeholder="${vars.vvediteVashVopros}" data-required="required">${optionId}. </textarea>
        </div>`;

    let attchFiles =
        `<div class="attach-file">
        <div class="attach-file-icon"></div>
        <div class="attach-files-wrap">
            <div class="files-list">
                <div class="file-item file-video">
                    <input type="file" accept="video/mp4,video/x-m4v,video/*" name="uploadvideo-added_${id}_${optionId}"
                        id="uploadvideo_${id}_${optionId}">
                    <label for="uploadvideo-added_${id}_${optionId}"></label>
                </div>
                <div class="file-item file-img">
                    <input type="file" accept="image/png, image/gif, image/jpeg" name="uploadimage-added_${id}_${optionId}"
                        id="uploadimage-added_${id}_${optionId}">
                    <label for="uploadimage-added_${id}_${optionId}"></label>
                </div>
                <div class="file-item file-audio">
                    <input type="file" accept=".mp3,audio/*" name="uploadaudio-added_${id}_${optionId}" id="uploadaudio-added_${id}_${optionId}">
                    <label for="uploadaudio-added_${id}_${optionId}"></label>
                </div>
            </div>
        </div>
    </div>`;

    let topEL =
        `<div class="control-panel">
        ${attchFiles}
        <div class="show-settings"></div>
    </div>
    ${nameHtml}`;

    let el;

    let required_Set =
        `<div class="switch-row">
            <div class="label">
                ${vars.obyazatelnostOtveta}
            </div>
            <label class="switch">
                <input type="checkbox" name="required-added_${id}_${optionId}" checked>
                <span class="slider round"></span>
            </label>
        </div>`;

    switch (questionType) {
        case 'single':
            el = `<div class="question-wrap question-single" data-id="${id}_${optionId}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        <div class="radio-btns-wrapper">
                        </div>
                        <div class="list-alternatives">
                        </div>
                        <div class="input-new-item-wrap">
                            <input type="text" class="input-single-item" placeholder="${vars.vvediteVariantOtveta}">
                        </div>
                    </div>
                    <div class="box-shadow question-settings">
                        <div class="switch-row">
                            <div class="label">
                                ${vars.dobavitVariantOnvetaDrugoe}
                            </div>
                            <label class="switch">
                                <input type="checkbox" class="add-other" name="addOther-added_${id}_${optionId}">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row">
                            <div class="label">
                                ${vars.vaarianNichegoIsVibrannogo}
                            </div>
                            <label class="switch">
                                <input type="checkbox" class="add-neither" name="addNeither-added_${id}_${optionId}">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row">
                            <div class="label">
                                ${vars.polecommentaria}
                            </div>
                            <label class="switch">
                                <input type="checkbox" class="add-comment" name="addComment-added_${id}_${optionId}">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row single-multiple-row">
                            <div class="label">
                                ${vars.neckolkoVariantovOtveta}
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="multiple-added_${id}_${optionId}" class="multiple-answers">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        ${required_Set}
                        <div class="switch-row">
                            <div class="label">
                                ${vars.peremishatVariantiOtvetov}
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="mix-answers-added_${id}_${optionId}" class="mix-answers">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>`
            break;
        case 'free-answer':
            el =
                `<div class="question-wrap question-free " data-id="${id}_${optionId}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        <div class="free-answers">
                            <div class="answer-wrap">
                                <textarea rows="1" placeholder="${vars.vvediteVashComment}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box-shadow question-settings">
                        <div class="select-row">
                            <div class="label">
                                ${vars.neckolkoVariantovOtveta}
                            </div>
                            <div class="select-input">
                                <select name="amount_added_${id}_${optionId}" class="customselect amount-select">
                                    <option value="dynamic">${vars.avtoobnovlenie}</option>
                                    <option selected value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                        </div>
                        ${required_Set}
                    </div>
                </div>`
            break;
        case 'scale':
            el =
                `<div class="question-wrap question-scale" data-id="${id}_${optionId}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        <div class="scale-wrap scale-star scale-10">

                            <input type="radio" id="scale_${id}_${optionId}_10" name="scale_${id}_${optionId}" value="10" />
                            <label for="scale_${id}_${optionId}_10" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_${optionId}_9" name="scale_${id}_${optionId}" value="9" />
                            <label for="scale_${id}_${optionId}_9" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_${optionId}_8" name="scale_${id}_${optionId}" value="8" />
                            <label for="scale_${id}_${optionId}_8" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_${optionId}_7" name="scale_${id}_${optionId}" value="7" />
                            <label for="scale_${id}_${optionId}_7" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_${optionId}_6" name="scale_${id}_${optionId}" value="6" />
                            <label for="scale_${id}_${optionId}_6" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_${optionId}_5" name="scale_${id}_${optionId}" value="5" />
                            <label for="scale_${id}_${optionId}_5" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_${optionId}_4" name="scale_${id}_${optionId}" value="4" />
                            <label for="scale_${id}_${optionId}_4" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_${optionId}_3" name="scale_${id}_${optionId}" value="3" />
                            <label for="scale_${id}_${optionId}_3" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_${optionId}_2" name="scale_${id}_${optionId}" value="2" />
                            <label for="scale_${id}_${optionId}_2" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_${optionId}_1" name="scale_${id}_${optionId}" value="1" />
                            <label for="scale_${id}_${optionId}_1" title="text"></label>
                        </div>
                    </div>
                    <div class="box-shadow question-settings">
                        <div class="scale-options">
                            <div class="scale-row">
                                <div class="options-item">
                                    <div class="option-label">
                                        ${vars.shkala}
                                    </div>
                                    <div class="option-value">
                                        <select name="scaleAmount_${id}_${optionId}" class="customselect scale-amount">
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option selected value="10">10</option>
                                            <option value="2">${vars.da_net}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="options-item">
                                    <div class="option-label">
                                        ${vars.figura}
                                    </div>
                                    <div class="option-value">
                                        <select name="scaleType_${id}_${optionId}" class="customselect scale-type">
                                            <option selected value="star">${vars.zvesdochki}</option>
                                            <option value="face">${vars.smayliki}</option>
                                            <option value="heart">${vars.serdechki}</option>
                                            <option value="hand">${vars.palec}</option>
                                            <option value="diapason">${vars.diapazon}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="switch-row">
                                <div class="label">
                                    ${vars.metkyReytinga}
                                </div>
                                <label class="switch">
                                    <input type="checkbox" class="add-rateLabels" name="rateLabels_${id}_${optionId}" id="rateLabels_${id}_${optionId}">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            ${required_Set}
                        </div>   
                    </div>
                </div>`
            break;
        case 'nps':
            el =
                `<div class="question-wrap question-scale nps-question-scale" data-id="${id}_${optionId}">
                        <div class="box-shadow question-content">
                            ${topEL}
                            <div class="scale-wrap scale-star scale-10">
                                <input type="radio" id="npsscale_${id}_${optionId}_10" name="nps_${id}_${optionId}" value="10" />
                                <label for="npsscale_${id}_${optionId}_10" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_${optionId}_9" name="nps_${id}_${optionId}" value="9" />
                                <label for="npsscale_${id}_${optionId}_9" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_${optionId}_8" name="nps_${id}_${optionId}" value="8" />
                                <label for="npsscale_${id}_${optionId}_8" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_${optionId}_7" name="nps_${id}_${optionId}" value="7" />
                                <label for="npsscale_${id}_${optionId}_7" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_${optionId}_6" name="nps_${id}_${optionId}" value="6" />
                                <label for="npsscale_${id}_${optionId}_6" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_${optionId}_5" name="nps_${id}_${optionId}" value="5" />
                                <label for="npsscale_${id}_${optionId}_5" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_${optionId}_4" name="nps_${id}_${optionId}" value="4" />
                                <label for="npsscale_${id}_${optionId}_4" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_${optionId}_3" name="nps_${id}_${optionId}" value="3" />
                                <label for="npsscale_${id}_${optionId}_3" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_${optionId}_2" name="nps_${id}_${optionId}" value="2" />
                                <label for="npsscale_${id}_${optionId}_2" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_${optionId}_1" name="nps_${id}_${optionId}" value="1" />
                                <label for="npsscale_${id}_${optionId}_1" title="text"></label>
                                <input type="radio" id="npsscale_${id}_${optionId}_0" name="nps_${id}_${optionId}" value="0" />
                                <label for="npsscale_${id}_${optionId}_0" title="text"></label>
                            </div>
                        </div>
                        <div class="box-shadow question-settings">
                            <div class="scale-options">
                                <div class="scale-row">
                                    <div class="options-item">
                                        <div class="option-label">
                                            ${vars.figura}
                                        </div>
                                        <div class="option-value">
                                            <select name="npsType_${id}_${optionId}" class="customselect scale-type">
                                                <option selected value="star">${vars.zvesdochki}</option>
                                                <option value="face">${vars.smayliki}</option>
                                                <option value="heart">${vars.serdechki}</option>
                                                <option value="hand">${vars.palec}</option>
                                                <option value="diapason">${vars.diapazon}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="switch-row">
                                    <div class="label">
                                        ${vars.metkyReytinga}
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" class="add-nps-rateLabels" name="rateLabels_${id}_${optionId}" id="rateLabels_${id}_${optionId}">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            ${required_Set}
                        </div>
                    </div>`
            break;
        case 'dropdown':
            el =
                `<div class="question-wrap question-dropdown question-new" data-id="${id}_${optionId}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        <div class="dropdown-wrap">
                            <select class="customselect">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="optins-list">
                            <div class="option-item">
                                <div class="inputpoint-body">
                                    <div class="number">1.</div>
                                    <div class="value">
                                        <input type="text" name="inputpoint_${id}_${optionId}_1" value="">
                                        <div class="icons-box">
                                            <div class="watch-options"></div>
                                            <div class="remove-dropdown-el"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="inputpoint-visability">
                                    <div class="switch-row">
                                        <label class="switch">
                                            <input type="checkbox" name="inputpoint-visability_${id}_${optionId}_1"/>
                                            <span class="slider round"></span>
                                        </label> 
                                        <div class="label">${vars.scritAlternativuUVoprose}</div>
                                        <div class="inputpoint-customselect-question">
                                            <select class="customselect">
                                                <option value></option>
                                            </select>
                                        </div>
                                        <div class="label">${vars.varianta}</div>
                                        <div class="inputpoint-customselect-answer">
                                            <select class="customselect" multiple="multiple">
                                                <option value></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-shadow question-settings">
                        <div class="switch-row">
                            <div class="label">
                                ${vars.dobavitVariantOnvetaDrugoe}
                            </div>
                            <label class="switch">
                                <input type="checkbox" class="add-other" id="addOther_${id}_${optionId}">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row">
                            <div class="label">
                                ${vars.vaarianNichegoIsVibrannogo}
                            </div>
                            <label class="switch">
                                <input type="checkbox" class="add-neither" name="addNeither_${id}_${optionId}">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row">
                            <div class="label">
                                ${vars.polecommentaria}
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="addComment_${id}_${optionId}" class="add-comment">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row dropdown-multiple-row">
                            <div class="label">
                                ${vars.neckolkoVariantovOtveta}
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="multiple_${id}_${optionId}" class="make-multiple">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        ${required_Set}
                        <div class="switch-row">
                            <div class="label">
                                ${vars.peremishatVariantiOtvetov}
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="mix-answers_${id}_${optionId}" class="mix-answers">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>`
            break;
        case 'matrix':
            el =
                `<div class="question-wrap question-matrix" data-id="${id}_${optionId}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        <div class="matrix-table">
                            <table>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        <div class="matrix-options">
                            <div class="matrix-row-list">
                                <div class="matrix-row">
                                    <div class="value">
                                        <input type="text" name="inputRow_${id}_${optionId}_1" placeholder="${vars.vvediteTextStroki}">
                                        <div class="remove-matrix-el"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="matrix-col-list">
                                <div class="matrix-col">
                                    <div class="value">
                                        <input type="text" name="inputCol_${id}_${optionId}_1" placeholder="${vars.vvediteTextStolbca}">
                                        <div class="remove-matrix-el"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-shadow question-settings">
                        <div class="switch-row">
                            <div class="label">
                                ${vars.razreshitNeskolkoOtvetovNaStroku}
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="multiple_${id}_${optionId}" class="add-multipleChoice">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row">
                            <div class="label">
                                ${vars.dobavitPoleCoommentariya}
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="addComment_${id}_${optionId}" class="add-comment">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        ${required_Set}
                    </div>
                </div>`
            break;
        case 'ranging':
            el =
                `<div class="question-wrap question-ranging" data-id="${id}_${optionId}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        <div class="ranging-list">
                            <div class="ranging-item empty-item">
                                <div class="grab-icon"></div>
                                <div class="ranging-name">
                                    <textarea name="inputpoint_${id}_${optionId}_1" placeholder="${vars.vvediteVariantOtveta}" rows="1"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-shadow question-settings">
                        ${required_Set}
                        <div class="switch-row">
                            <div class="label">
                                ${vars.peremishatVariantiOtvetov}
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="mix-answers_${id}_${optionId}" class="mix-answers">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>`
            break;
        case 'name':
            el =
                `<div class="question-wrap added-question-name" data-id="${id}_${optionId}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        <div class="name-answers">
                            <div class="answer-wrap">
                                <textarea rows="1" placeholder="${vars.imya}"></textarea>
                            </div>
                            <div class="answer-wrap">
                                <textarea rows="1" placeholder="${vars.otchestvo}"></textarea>
                            </div>
                            <div class="answer-wrap">
                                <textarea rows="1" placeholder="${vars.familiya}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box-shadow question-settings">
                        ${required_Set}
                    </div>
                </div>`
            break;
        case 'date':
            el =
                `<div class="question-wrap question-date" data-id="${id}_${optionId}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        <div class="data-list">
                            <div class="date-answer">
                                <input type="text" class="date-input" maxlength="10">
                                <div class="icon-date"></div>
                            </div>
                        </div>
                    </div>
                    <div class="box-shadow question-settings">
                        <div class="select-row">
                            <div class="label">
                                ${vars.neckolkoVariantovOtveta}
                            </div>
                            <div class="select-input">
                                <select name="amount_${id}_${optionId}" class="customselect amount-select">
                                    <option value="dynamic">${vars.avtoobnovlenie}</option>
                                    <option selected value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                        </div>
                        ${required_Set}
                    </div>
                </div>`
            break;
        case 'email':
            el =
                `<div class="question-wrap question-email" data-id="${id}_${optionId}">
                <div class="box-shadow question-content">
                    ${topEL}
                    <div class="email-answer">
                        <input type="email" placeholder="Email">
                    </div>
                </div>
                <div class="box-shadow question-settings">
                    ${required_Set}
                </div>
            </div>`
            break;
        case 'phone':
            el =
                `<div class="question-wrap question-phone" data-id="${id}_${optionId}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        <div class="phone-answer">
                            <input class="code" type="text" value="+380" readonly>
                            <input class="phone" type="tel" maxlength="13">
                        </div>
                    </div>
                    <div class="box-shadow question-settings">
                        ${required_Set}
                    </div>
                </div>`
            break;
        case 'file':
            el =
                `<div class="question-wrap question-file" data-id="${id}_${optionId}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        <div class="file-answer">
                            <label>
                                <input type="file" multiple>
                            </label>
                        </div>
                    </div>
                    <div class="box-shadow question-settings">
                        ${required_Set}
                    </div>
                </div>`
            break;
        default:
            el =
                `<div class="question-wrap question-single question-new" data-id="${id}_${optionId}">
                    <div class="box-shadow question-content">
                        ${topEL}
                    </div>
                    <div class="box-shadow question-settings">
                        ${required_Set}
                    </div>
                </div>`
    }

    return el;
}
