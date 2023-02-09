/** Generate HTML for all question types */

export function generateQestionTypeElement(type, questionIndex, uniqueId, chapterIndex) {
    let id = chapterIndex !== undefined ?
        `${chapterIndex}_${questionIndex}` : questionIndex;

    let attchFiles =
        `<div class="attach-file">
        <div class="attach-file-icon"></div>
        <div class="attach-files-wrap">
            <div class="files-list">
                <div class="file-item file-video">
                    <input type="file" accept="video/mp4,video/x-m4v,video/*" name="uploadvideo_${id}"
                        id="uploadvideo_${id}">
                    <label for="uploadvideo_${id}"></label>
                </div>
                <div class="file-item file-img">
                    <input type="file" accept="image/png, image/gif, image/jpeg" name="uploadimage_${id}"
                        id="uploadimage_${id}">
                    <label for="uploadimage_${id}"></label>
                </div>
                <div class="file-item file-audio">
                    <input type="file" accept=".mp3,audio/*" name="uploadaudio_${id}" id="uploadaudio_${id}">
                    <label for="uploadaudio_${id}"></label>
                </div>
            </div>
        </div>
    </div>`;
    let nameHtml =
        `<div class="question-name">
            <span class="chapter">1/</span>
            <textarea name="question_${id}"  rows="1" placeholder="${vars.vvediteVashVopros}" data-required="required">${id}. </textarea>
        </div>`;
    let qustionVisibility = `
        <div class="question-visability">
            <input type="checkbox" name="q-visability_${id}" id="q-visability_${id}">  
            <label for="q-visability_${id}" class="switch-visability">
                
            </label> 
        </div>`;
    let topEL =
        `<div class="control-panel">
            ${attchFiles}
            ${qustionVisibility}
            <div class="show-settings"></div>
            <div class="remove-question"></div>
        </div>
        <input type="hidden" name="type_${id}" value="${type}">
        <input type="hidden" name="id_${id}" value="${uniqueId}">
        ${nameHtml}`;
    let el;

    let required_Set =
        `<div class="switch-row">
        <div class="label">
            ${vars.obyazatelnostOtveta}
        </div>
        <label class="switch">
            <input type="checkbox" name="required_${id}" checked>
            <span class="slider round"></span>
        </label>
    </div>`;

    const copyQuestionBTN =
        `<i class="copy-question">
        <div class="copy-message">${vars.kopiyaVoprsaDobavlena}</div>
    </i>`;

    switch (type) {
        case 'single':
            el =
                `<div class="question-wrap question-single question-new" data-id="${id}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        ${copyQuestionBTN}
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
                                <input type="checkbox" class="add-other" name="addOther_${id}">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row">
                            <div class="label">
                                ${vars.vaarianNichegoIsVibrannogo}
                            </div>
                            <label class="switch">
                                <input type="checkbox" class="add-neither" name="addNeither_${id}">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row">
                            <div class="label">
                                ${vars.polecommentaria}
                            </div>
                            <label class="switch">
                                <input type="checkbox" class="add-comment" name="addComment_${id}">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row single-multiple-row">
                            <div class="label">
                                ${vars.neckolkoVariantovOtveta}
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="multiple_${id}" class="multiple-answers">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        ${required_Set}
                        <div class="switch-row single-option-row">
                            <div class="label">
                                ${vars.dobavitOpciu}
                            </div>
                            <label class="switch">
                                <input type="checkbox" class="add-single-option" name="add-single-option_${id}">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row">
                            <div class="label">
                                ${vars.peremishatVariantiOtvetov}
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="mix-answers_${id}" class="mix-answers">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="box-shadow question-view-hide">
                    <div class="question-view-hide__title">Скрыть вопрос</div>
                    <div class="switch-row single-choice-row">
                            <div class="label">
                               При ответе на вопрос:
                            </div>
                            <label class="switch">
                                <input type="checkbox" class="add-single-choice" name="add-single-choice_${id}">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>`
            break;
        case 'free-answer':
            el =
                `<div class="question-wrap question-free question-new" data-id="${id}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        ${copyQuestionBTN}
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
                                <select name="amount_${id}" class="customselect amount-select">
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
                `<div class="question-wrap question-scale question-new" data-id="${id}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        ${copyQuestionBTN}
                        <div class="scale-wrap scale-star scale-10">

                            <input type="radio" id="scale_${id}_10" name="scale_${id}" value="10" />
                            <label for="scale_${id}_10" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_9" name="scale_${id}" value="9" />
                            <label for="scale_${id}_9" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_8" name="scale_${id}" value="8" />
                            <label for="scale_${id}_8" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_7" name="scale_${id}" value="7" />
                            <label for="scale_${id}_7" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_6" name="scale_${id}" value="6" />
                            <label for="scale_${id}_6" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_5" name="scale_${id}" value="5" />
                            <label for="scale_${id}_5" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_4" name="scale_${id}" value="4" />
                            <label for="scale_${id}_4" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_3" name="scale_${id}" value="3" />
                            <label for="scale_${id}_3" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_2" name="scale_${id}" value="2" />
                            <label for="scale_${id}_2" title="text"></label>
                    
                            <input type="radio" id="scale_${id}_1" name="scale_${id}" value="1" />
                            <label for="scale_${id}_1" title="text"></label>
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
                                        <select name="scaleAmount_${id}" class="customselect scale-amount">
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
                                        <select name="scaleType_${id}" class="customselect scale-type">
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
                                    <input type="checkbox" class="add-rateLabels" name="rateLabels_${id}" id="rateLabels_${id}">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            ${required_Set}
                            <!--
                            <div class="switch-row scale-option-row">
                                <div class="label">
                                    ${vars.dobavitOpciu}
                                </div>
                                <label class="switch">
                                    <input type="checkbox" class="add-scale-option" name="add-scale-option_${id}">
                                    <span class="slider round"></span>
                                </label>
                            </div> -->
                        </div>   
                    </div>
                </div>`
            break;
        case 'nps':
            el =
                `<div class="question-wrap question-scale nps-question-scale question-new" data-id="${id}">
                        <div class="box-shadow question-content">
                            ${topEL}
                            ${copyQuestionBTN}
                            <div class="scale-wrap scale-star scale-10">
                                <input type="radio" id="npsscale_${id}_10" name="nps_${id}" value="10" />
                                <label for="npsscale_${id}_10" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_9" name="nps_${id}" value="9" />
                                <label for="npsscale_${id}_9" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_8" name="nps_${id}" value="8" />
                                <label for="npsscale_${id}_8" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_7" name="nps_${id}" value="7" />
                                <label for="npsscale_${id}_7" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_6" name="nps_${id}" value="6" />
                                <label for="npsscale_${id}_6" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_5" name="nps_${id}" value="5" />
                                <label for="npsscale_${id}_5" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_4" name="nps_${id}" value="4" />
                                <label for="npsscale_${id}_4" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_3" name="nps_${id}" value="3" />
                                <label for="npsscale_${id}_3" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_2" name="nps_${id}" value="2" />
                                <label for="npsscale_${id}_2" title="text"></label>
                        
                                <input type="radio" id="npsscale_${id}_1" name="nps_${id}" value="1" />
                                <label for="npsscale_${id}_1" title="text"></label>
                                <input type="radio" id="npsscale_${id}_0" name="nps_${id}" value="0" />
                                <label for="npsscale_${id}_0" title="text"></label>
                            </div>
                        </div>
                        <div class="box-shadow question-settings">
                            <div class="scale-options">
                                <div class="scale-row">
                                    <div class="options-item">
                                        <div class="option-label">
                                                    Шкала
                                        </div>
                                        <div class="option-value">
                                            <select name="npsAmount_${id}" class="customselect scale-amount">
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option selected value="10">10</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="options-item">
                                        <div class="option-label">
                                            ${vars.figura}
                                        </div>
                                        <div class="option-value">
                                            <select name="npsType_${id}" class="customselect scale-type">
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
                                        <input type="checkbox" class="add-nps-rateLabels" name="rateLabels_${id}" id="rateLabels_${id}">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            ${required_Set}
                            <div class="switch-row nps-option-row">
                                <div class="label">
                                    ${vars.dobavitOpciu}
                                </div>
                                <label class="switch">
                                    <input type="checkbox" class="addNpsOption" name="addNpsOption_${id}" id="npsOptionLabels_${id}">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>`
            break;
        case 'dropdown':
            el =
                `<div class="question-wrap question-dropdown question-new" data-id="${id}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        ${copyQuestionBTN}
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
                                        <input type="text" name="inputpoint_${id}_1" value="">
                                        <div class="icons-box">
                                            <div class="watch-options"></div>
                                            <div class="remove-dropdown-el"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="inputpoint-visability">
                                    <div class="switch-row">
                                        <label class="switch">
                                            <input type="checkbox" name="inputpoint-visability_${id}_1"/>
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
                                <input type="checkbox" class="add-other" id="addOther_${id}">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row">
                            <div class="label">
                                ${vars.vaarianNichegoIsVibrannogo}
                            </div>
                            <label class="switch">
                                <input type="checkbox" class="add-neither" name="addNeither_${id}">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row">
                            <div class="label">
                                ${vars.polecommentaria}
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="addComment_${id}" class="add-comment">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row dropdown-multiple-row">
                            <div class="label">
                                ${vars.neckolkoVariantovOtveta}
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="multiple_${id}" class="make-multiple">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        ${required_Set}
                        <div class="switch-row dropdown-option-row">
                            <div class="label">
                                ${vars.dobavitOpciu}
                            </div>
                            <label class="switch">
                                <input type="checkbox" class="add-dropdown-option" name="add-dropdown-option_${id}">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row">
                            <div class="label">
                                ${vars.peremishatVariantiOtvetov}
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="mix-answers_${id}" class="mix-answers">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>`
            break;
        case 'matrix':
            el =
                `<div class="question-wrap question-matrix question-new" data-id="${id}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        ${copyQuestionBTN}
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
                                        <input type="text" name="inputRow_${id}_1" placeholder="${vars.vvediteTextStroki}">
                                        <div class="remove-matrix-el"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="matrix-col-list">
                                <div class="matrix-col">
                                    <div class="value">
                                        <input type="text" name="inputCol_${id}_1" placeholder="${vars.vvediteTextStolbca}">
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
                                <input type="checkbox" name="multiple_${id}" class="add-multipleChoice">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="switch-row">
                            <div class="label">
                                ${vars.dobavitPoleCoommentariya}
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="addComment_${id}" class="add-comment">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        ${required_Set}
                    </div>
                </div>`
            break;
        case 'ranging':
            el =
                `<div class="question-wrap question-ranging question-new" data-id="${id}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        ${copyQuestionBTN}
                        <div class="ranging-list">
                            <div class="ranging-item empty-item">
                                <div class="grab-icon"></div>
                                <div class="ranging-name">
                                    <textarea name="inputpoint_${id}_1" placeholder="${vars.vvediteVariantOtveta}" rows="1"></textarea>
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
                                <input type="checkbox" name="mix-answers_${id}" class="mix-answers">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>`
            break;
        case 'name':
            el =
                `<div class="question-wrap question-name question-new" data-id="${id}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        ${copyQuestionBTN}
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
                `<div class="question-wrap question-date question-new" data-id="${id}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        ${copyQuestionBTN}
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
                                <select name="amount_${id}" class="customselect amount-select">
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
                `<div class="question-wrap question-email question-new" data-id="${id}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        ${copyQuestionBTN}
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
                `<div class="question-wrap question-phone question-new" data-id="${id}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        ${copyQuestionBTN}
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
                `<div class="question-wrap question-file question-new" data-id="${id}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        ${copyQuestionBTN}
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
                `<div class="question-wrap question-single question-new" data-id="${id}">
                    <div class="box-shadow question-content">
                        ${topEL}
                        ${copyQuestionBTN}
                    </div>
                    <div class="box-shadow question-settings">
                        ${required_Set}
                    </div>
                </div>`
    }
    return el
}
