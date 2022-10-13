document.addEventListener("DOMContentLoaded", function() {
    window.onload = function() {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/get-diagram');
        xhr.send(null);
        xhr.onload = function() {
            let data = JSON.parse(xhr.responseText);
            let nuts = parseInt(data['nuts']);
            let driedfruits = parseInt(data['driedfruits'])
            google.charts.load('current', { 'packages': ['corechart'] });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Продукты', 'Количество'],
                    ['Орехи', nuts],
                    ['Сухофрукты', driedfruits],
                ]);

                var options = {
                    title: 'Добавленные товары',
                    sliceVisibilityThreshold: .10,
                    fontName: 'Roboto',
                    pieStartAngle: 180,
                    slices: {
                        0: { color: 'green' },
                        1: { color: 'red' }
                    }
                };

                var chart = new google.visualization.PieChart(document.getElementById('chart'));
                chart.draw(data, options);
            };
        }
    }

})