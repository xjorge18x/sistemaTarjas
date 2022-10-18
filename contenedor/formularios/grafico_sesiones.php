<?php
require_once("../../cont/CFunciones.php");
$obj = new Cfunciones;
$query3 = "SELECT S.nombre,SUM(DENETO)AS TOTAL
FROM sesion S
INNER JOIN DETALLE D ON (D.id_sesion=S.id)
WHERE D.estado_e=1 
-- AND CONVERT(NVARCHAR(10),DTFESESION,120)=CONVERT(NVARCHAR(10),SYSDATETIME(),120)
GROUP BY S.nombre
ORDER BY TOTAL DESC";
$smtv = $obj->consultar2($query3);
$numerofilas = sqlsrv_num_rows($smtv);

$fecha_actual=date("d/m/Y");
$fecha =date('d F Y', strtotime($fecha_actual));
?>
<script type="text/javascript">
$(function () {
    $('#GraficoSession').highcharts({
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Sesiones'
    },
    // subtitle: {
    //     text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
    // },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: [{
            "gridLineWidth": 0,
            "labels": {
                "enabled": false,
                "style": {
                    "fontSize": "9px",
                    "fontFamily": "Verdana"
                },
                "ownformat": false
            },
            "min": 0.0,
            "title": {
                "text": ""
            }
        }],
    
    yAxis: {
        title: {
            text: 'Cantidad de Personal'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,

            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> Trabajadores<br/>'
    },

    series: [
        {
            name: "Grupo :",
            colorByPoint: true,
            data: [
                <?php while($row = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC)){ ?>
                ['<?php echo $row['nombre']?>',<?php echo $row['TOTAL']?>], 
                <?php }?>
            ],
            dataLabels: {
            enabled: true,
    
            color: '#FFFFFF',
            align: 'right',
            format: '{point.name}',
            y: 2, // 10 pixels down from the top
            style: {
                fontSize: '13px',
                fontFamily: 'Verdana, sans-serif'
            }
            
        }
        }
    ],
    
 });
});


        </script>
<div id="GraficoSession"></div>

<!-- style="min-width: 650px; height: 400px; max-width: 650px; margin: 0 auto" -->