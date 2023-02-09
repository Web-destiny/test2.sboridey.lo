//!new file  type of questions matrix functions
import {changeNameInput} from './chapters.js'
//add row to matrix table
export function addMatrixRow(question, text) {
    let table = question.find('.matrix-table');
    let questionId = question.attr('data-id');
    let rowHtml =
        `<tr>
            <td>${text}</td>
        `;
    let rowIndex = table.find('tr').length;
    let colAmount = table.find('tr:nth-child(1)').find('td').length;

    for (let i = 1; i < colAmount; i++) {
        rowHtml +=
            `<td>
                <div class="matrix-check">
                    <input type="radio" name="q_${questionId}_${rowIndex}" id="q_${questionId}_${rowIndex}_${i}" placeholder="${vars.vvediteTextStroki}">
                    <label for="q_${questionId}_${rowIndex}_${i}"></label>
                </div>
            </td>`;
    }
    rowHtml +=
        `   </tr>`;
    $(rowHtml).insertAfter(table.find('tr:last-child()'));

    //add empty input row
    let inputRowHtml =
        `<div class="matrix-row">
            <div class="value">
                <input type="text" name="inputRow_${questionId}_${rowIndex}" placeholder="${vars.vvediteTextStroki}">
                <div class="remove-matrix-el"></div>
            </div>
        </div>`;
    $(inputRowHtml).appendTo($(question).find('.matrix-row-list'));
}

//add col to matrix table
export function addMatrixCol(question, text) {
    let table = question.find('.matrix-table');
    let questionId = question.attr('data-id');
    let tableRows = table.find('tr');
    let colId = $(tableRows[0]).find('td').length;
    for (let i = 0; i < tableRows.length; i++) {
        if (i === 0) {
            let colHeaderHtml = `<td>${text}</td>`;
            $(colHeaderHtml).appendTo(tableRows[i]);
        } else {
            let colHtml =
                `<td>
                    <div class="matrix-check">
                        <input type="radio" name="q_${questionId}_${i}" id="q_${questionId}_${i}_${colId}" placeholder="${vars.vvediteTextStolbca}">
                        <label for="q_${questionId}_${i}_${colId}"></label>
                    </div>
                </td>`;
            $(colHtml).appendTo(tableRows[i]);
        }
    }

    //add empty input col
    let inputColHtml =
        `<div class="matrix-col">
        <div class="value">
            <input type="text" name="inputCol_${questionId}_${colId}" placeholder="${vars.vvediteTextStolbca}">
            <div class="remove-matrix-el"></div>
        </div>
    </div>`;
    $(inputColHtml).appendTo($(question).find('.matrix-col-list'));
}

//remove matrix col
export function removeMatrixCol(question, colId) {
    let table = question.find('.matrix-table');
    let inputColList = question.find('.matrix-col-list');
    let tableRow = table.find('tr');
    let tableColId = colId + 1;
    for (let i = 0; i < tableRow.length; i++) {
        $(tableRow[i]).find(`td:nth-child(${tableColId})`).remove();
    }
    inputColList.find(`.matrix-col:nth-child(${colId}`).remove();
    refreshMatrixID(question);
}

//remove matrix row
export function removeMatrixRow(question, rowId) {
    let table = question.find('.matrix-table');
    let inputRowList = question.find('.matrix-row-list');
    let tableRowId = rowId + 1;
    let deletedRow = table.find(`tr:nth-child(${tableRowId})`);
    deletedRow.remove();
    inputRowList.find(`.matrix-row:nth-child(${rowId}`).remove();
    refreshMatrixID(question);
}

//refresh matrix ids
export function refreshMatrixID(question) {
    let table = question.find('.matrix-table');
    let rowTable = table.find('tr');
    let rowList = question.find('.matrix-row-list').children();
    let colList = question.find('.matrix-col-list').children();
    for (let i = 0; i < rowTable.length; i++) {
        if (i !== 0) {
            let colTable = $(rowTable[i]).find('td')
            let inputsRow = $(rowTable[i]).find('input');
            let labelsRow = $(rowTable[i]).find('label');
            // set row Id
            changeNameInput(inputsRow, i, 2);
            changeNameInput(labelsRow, i, 2);
            for (let i2 = 0; i2 < colTable.length; i2++) {
                if (i2 != 0) {
                    let inputs = $(colTable[i2]).find('input');
                    let labels = $(colTable[i2]).find('label');
                    //set col id
                    changeNameInput(inputs, i2, 3);
                    changeNameInput(labels, i2, 3);
                }
            }
        }
    }
    for (let i = 0; i < rowList.length; i++) {
        let inputs = $(rowList[i]).find('input');
        let id = i + 1;
        changeNameInput(inputs, id, 2);
    }
    for (let i = 0; i < colList.length; i++) {
        let inputs = $(colList[i]).find('input');
        let id = i + 1;
        changeNameInput(inputs, id, 2);
    }
}
