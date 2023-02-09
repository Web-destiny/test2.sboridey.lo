export function generateChapterHead(textAreaName, selectName, chapterItemNumber) {
    return `<div class="chapter-head">
            <div class="chapter-desciption-wrapper">
                <span class="chapter-number"></span>
                <textarea name="${textAreaName}" class="chapter-name-textarea" id="" rows="1"></textarea>
            </div>
            <div class="chapter-control-panel">
            <div class="remove-chapter"></div>
            <div class="show-chapter-setting show-settings"></div>
            </div>
        </div>
        <div class="chapter-settings">
            <div class="chapter-settings-row">
                <span class="chapter-settings-name">` + vars.posleRazdela + `  <span class="chapter-settings-number">${chapterItemNumber}:</span></span>
                <div class="option-value">
                    <select name="${selectName}" class="customselect scale-amount chapter-name-select">
                    
                    </select>
                </div>
            </div>
        </div>`;
}

export function generateChapterWrapper(textAreaName, selectName, chapterItemNumber) {
    return `<div class="chapter-wrapper">
                ${generateChapterHead(textAreaName, selectName, chapterItemNumber)}
                <div class="chapter-questions-list"></div>
            </div>`
}