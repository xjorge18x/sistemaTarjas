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
    $('#container').highcharts({
       chart: {
            renderTo: 'asset_allocation_bottom_left_div'
        },
        title: {
            text: 'Personal Laborando <?php echo $fecha_actual; ?>',
            
        },
        // subtitle: {
        //     text: '(As of ' + 'dfdf' + ')',
        //     style: {
        //         fontSize: '15px',
        //         color: 'red',
        //         fontFamily: 'Verdana',
        //         marginBottom: '10px'
        //     },
        //     y: 40
        // },
        // tooltip: {
        //     pointFormat: '{series.name}: <b>{point.percentage}%</b>',
        //     percentageDecimals: 0
        // },
        plotOptions: {
            pie: {
                 size: '80%',
                cursor: 'pointer',
                data: [
                   
                <?php while($row = sqlsrv_fetch_array($smtv,SQLSRV_FETCH_ASSOC)){ ?>
                ['<?php echo $row['grupo']?>',<?php echo $row['total']?>], 
                <?php }?>
                ]
            },
            
        },

        series: [{
           type: 'pie',
                name: 'Porcentaje',
                dataLabels: {
                    verticalAlign: 'top',
                    enabled: true,
                    color: '#000000',
                    connectorWidth: 1,
                    distance: -30,
                    connectorColor: '#000000',
                    formatter: function() {
                        return Math.round(this.percentage) + ' %';
                    }
                }
            }, {
                type: 'pie',
                name: 'Cant. Trabajadores',
                dataLabels: {
                    enabled: true,
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    color: '#000000',
                    connectorWidth: 1.8,
                    distance: 20,
                    
                    // formatter: function() {
                    //     return '<b>' + this.point.name + '</b>:<br/> ' + Math.round(this.percentage) + ' %';
                    // }
                },

           
        }],
        exporting: {
            enabled: true
        }
    });
});


        </script>
<div id="container" ></div>
