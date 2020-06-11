$(document).ready(function () {
    var fullPath = window.location.href;
    var fullPathArr = fullPath.split('/');
    var role = fullPathArr[fullPathArr.length - 2];
    fullPathArr.splice(-1, 1);
    var fullPathCropped = fullPathArr.join('/');

    //--------------------------------------------------------------------------------------
    //--------Статистика загруженности сервера по типу информации---------------------------
    var backgroundColor = [];
    $.each(disk_data,function (index,value) {
        backgroundColor.push(getRandomColor());
    });
    var ctx = document.getElementById('Disk');
    var Disk = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: disk_labels,
            datasets: [{
                label: disk_name,
                data: disk_data,
                backgroundColor: backgroundColor,
                borderWidth: 1
            }]
        },
        options: {
            title:{
                display: true,
                position: 'top',
                fontSize: 20,
                text: disk_name + ' Всего: ' + disk_total,
            },
            legend:{
                position: 'bottom',
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return data.labels[tooltipItem.index] || '';
                    }
                }
            },
            hoverBorderWidth: '30px',
            cutoutPercentage: 75,
            circumference: Math.PI,
            rotation: Math.PI,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    //----------------------------------------------------------------------------------------------------------
    //--------------------интенсивность добавления файлов за год------------------------------------------------
    //заполняем цвета для данных
    var backgroundColor = [];
    $.each(timeline_data,function (index,value) {
        backgroundColor.push(getRandomColor());
    });
    var ctx = document.getElementById('timeline');
    var timeline = new Chart(ctx, {
        type: 'line',
        data: {
            labels: timeline_labels,
            datasets: [{
                label: timeline_name,
                data: timeline_data,
                fill:false,
                backgroundColor: backgroundColor,
                borderColor:"rgb(75, 192, 192)"
            }]
        },
        options: {
            title:{
                display: true,
                position: 'top',
                fontSize: 20,
                text: timeline_name + ' Всего: ' + timeline_total + num2str(timeline_total, [' файл',' файла',' файлов']),
            },
            legend:{
                position: 'bottom',
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        let count = data.datasets[0].data[tooltipItem.index];
                        return count + num2str(count, [' файл',' файла',' файлов']) || '';
                    }
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: false
                    }
                }]
            }
        }
    });
    //---------------------------------------------------------------------------
    //----------------Активность пользователей-----------------------------------
    var backgroundColor = [];
    $.each(activeUser_data,function (index,value) {
        backgroundColor.push(getRandomColor());
    });
    var ctx = document.getElementById('activeUser');
    var activeUser = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: activeUser_labels,
            datasets: [{
                label: activeUser_name,
                data: activeUser_data,
                backgroundColor: backgroundColor,
                borderWidth: 1
            }]
        },
        options: {
            title:{
                display: true,
                position: 'top',
                fontSize: 20,
                text: activeUser_name,
            },
            legend:{
                position: 'bottom',
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        let count = data.datasets[0].data[tooltipItem.index];
                        return data.labels[tooltipItem.index] + ': ' + count + num2str(count, [' файл',' файла',' файлов']) || '';
                    }
                }
            },
            hoverBorderWidth: '30px',
            cutoutPercentage: 50,
            circumference: 2*Math.PI,
            rotation: 2*Math.PI,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
});