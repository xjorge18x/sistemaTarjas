<?php
require_once("cont/CFunciones.php");
$obj = new Cfunciones;
$query = "select distinct count(d.codDetalle)as total, g.NombreGrupo as grupo from DetalleCabRegistro d 
inner join  CabRegistroLab c on(d.codigoRegistro=c.codigoRegistro)
inner join TurnoGenerado t on (t.codigoturno=c.codigoTurno)
inner join GrupoTrabajo g on (g.codGrupoTrabajo=d.codigogrupo) where t.estado='0' and (d.asistencia=1 or d.asistencia=2)
group by g.NombreGrupo";
$smtv = $obj->consultar1($query);
$numerofilas = sqlsrv_num_rows($smtv);

$fecha_actual=date("d/m/Y");
$fecha =date('d F Y', strtotime($fecha_actual));
?>
<script type="text/javascript">
$(function () {
    $('#container1').highcharts({
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Otros Datos. January, 2018'
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
                ['<?php echo $row['grupo']?>',<?php echo $row['total']?>], 
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
<div id="container1"></div>

<!-- style="min-width: 650px; height: 400px; max-width: 650px; margin: 0 auto" -->