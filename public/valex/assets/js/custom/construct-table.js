function configureTableHtml(Table, ColumnsHeader, ColumnsValues, data) {
    let html = "";
    let classBody = "";
    if ((typeof Table).toUpperCase() == 'STRING') {
        html += `
            <table id="${Table}" border="2" class="table">
                <thead class="background-thead">
                    <tr align="center">
        `;
    }

    if ((typeof Table).toUpperCase() == 'OBJECT') {
        html += `
            <table id="${Table.id}" border="${Table.borderTable || 2}" class="${Table.classTable || 'table'}">
                <thead class="${Table.classThead || 'background-thead'}">
                    <tr align="${Table.alignCenter || 'center'}">
        `;
        classBody = Table.classBody || '';
    }

    ColumnsHeader.forEach(c => {
        if ((typeof c).toUpperCase() == 'STRING') {
            html += `<th align="center" class="border-bottom-0 color-th">${c}</th>`;
        }

        if ((typeof c).toUpperCase() == 'OBJECT') {
            html += `<th align="${c.align || 'center'}" class="${c.class || 'border-bottom-0 color-th'}">${c.name}</th>`;
        }
    });

    html += `
            </tr>
        </thead>
        <tbody class="${classBody}">
        `;

    data.forEach(d => {
        html += "<tr>";
        ColumnsValues.forEach(cv => {
            if ((typeof cv).toUpperCase() == 'STRING') {
                html += `
                <td align="center" class="color-td">${d[cv]}</td>
                `;
            }

            if ((typeof cv).toUpperCase() == 'OBJECT') {
                html += `
                <td align="${cv.align}" class="${cv.class}">${cv.functionValue(d)}</td>
                `;
            }
        });
        html += "</tr>";
    });

    html += `
            </tbody>
        </table>
    `;
    return html;
}