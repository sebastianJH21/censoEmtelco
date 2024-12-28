let selectRow = null;
document.querySelector('.table').addEventListener('click', function (event) {
    let rows = document.getElementsByTagName('tr')
    for (let i = 0; i < rows.length; i++) {
        rows[i].classList.remove('selected')
    }
    selectRow = event.target.parentNode;
    selectRow.classList.add('selected')
})
document.querySelector('.table').addEventListener('dblclick', function () {
    if (selectRow) {
        document.querySelector('#dni').value = selectRow.cells[0].textContent;
        document.querySelector('#name').value = selectRow.cells[1].textContent;
        document.querySelector('#dateBirth').value = selectRow.cells[2].textContent;
        document.querySelector('#address').value = selectRow.cells[3].textContent;
        document.querySelector('#city').value = selectRow.cells[4].textContent;
        document.querySelector('#deparment').value = selectRow.cells[5].textContent;
        document.querySelector('#phone').value = selectRow.cells[6].textContent;
        document.querySelector('#dateAppo').value = selectRow.cells[7].textContent;
        document.querySelector('#timeAppo').value = selectRow.cells[8].textContent;
        document.querySelector('.close-modal').click()
        if (!document.querySelector('#collapseWidthExample').classList.contains('show')) {
            document.querySelector('.btnSchedule').click()
        }
        document.querySelector('#save').classList.add('disable')
        document.querySelector('#edit').classList.remove('disable')
        document.querySelector('#delete').classList.remove('disable')
        
        templateHourJob();
    }
})

function convertNumberToHours(number) {
    if (number > 12) {
        let hour = number - 12;
        let hours = Math.floor(hour);
        let minutes = Math.round((hour - hours) * 60)
        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')} pm`;
    } else {
        let hour = number;
        let hours = Math.floor(hour);
        let minutes = Math.round((hours - hour) * 60);
        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')} am`;
    }
}
document.querySelector('#dateAppo').addEventListener('input', templateHourJob) // print hours
templateHourJob()
function templateHourJob() {
    let hourInitial = 8; //8:00 am
    let hourClosed;
    let templateHours = "";
    let date = document.querySelector('#dateAppo').value;
    if (date == "") {
        let today = new Date()
        let day = today.getDate();
        let month = today.getMonth() + 1; // Los meses en JavaScript son 0-indexados (enero es 0)
        let year = today.getFullYear();
        // Formatear la fecha en formato dd/mm/yyyy
        date = year + '-' + month + '-' + day;
        document.querySelector('#dateAppo').value = date
    } 
    let dateAppo = new Date(date);
    if (dateAppo.getDay() <= 4) {
        hourClosed = 17;
    }
    if (dateAppo.getDay() === 5) {
        hourClosed = 14;
    }
    for (let i = hourInitial; i <= hourClosed; i++) {
        templateHours += `
            <span class="hour">${convertNumberToHours(i)}</span>
        `
    }
    document.querySelector('.hours').innerHTML = templateHours;
    document.querySelectorAll('.hour').forEach(function (hour) {
        let time = parseInt(hour.textContent);
        if (time < 6) {
            time = `${(time + 12).toString().padStart(2, '0')}:00`
        } else {
            time = hour.textContent.substring(0, 5)
        }
        hour.addEventListener('click', function () {document.querySelector('#timeAppo').value = time;})
        $.ajax({
            url: '../models/modelUser.php',
            type: 'GET',
            data: {
                function: "getHours",
                date: date,
                time: time
            },
            success:function(response){
                let answer = JSON.parse(response)
                if(answer != ""){
                    hour.classList.add('disable');
                }
            }
        })
    })
}





