//!new file  type of questions ranging functions

import {
    hasChapter
} from "./chapters.js?15324234"


//dragable and sortable for ranging items
export function setSortbaleRanging() {
    // console.log('setSortbaleRanging')
    $('.question-ranging .ranging-list').sortable({
        cancel: 'a, button, textarea, .empty-item, .customselect-wrapper',
        containment: 'parent',
        cursor: 'grab',
        stop: function (event, ui) {
            let question = $(ui.item).parents('.question-wrap');
            if (hasChapter) {
                let questionIndex = $(question).attr('data-id');
                // console.log($(question))
                $(question).find('.ranging-name textarea').each((index, textarea) => {
                    $(textarea).attr('name', `inputpoint_${questionIndex}_${index + 1}`);
                })
            } else {
                refreshRangeId(question);
            }
        }
    });
}

export function refreshRangeId(question) {
    let rangeList = question.find('.ranging-list').children();
    if (rangeList.length > 0) {
        for (let i = 0; i < rangeList.length; i++) {
            let id = i + 1;
            let input = $(rangeList[i]).find('textarea');
            changeNameInput(input, id, 2);
        }
    }
}