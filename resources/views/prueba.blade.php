<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>DETALLE DE ORDENES</title>
</head>

<body>
    <style>
        @page {
            margin: 2.5px 80px;
        }

        .cell-color {
            background-color: #c6e0b4;
            /* border: 2px solid black !important;*/
        }

        .table-style {
            margin-left: 25rem;
        }

        .cell-border {
            border: 2px solid black !important;

        }

        .table {
            font-size: 9px !important;
            white-space: nowrap !important;
        }

        .table-format {
            font-size: 10px !important;
        }
    </style>
    <div class="title text-center">
        <h5>INNOVA INDUSTRIAS S.A</h5>
        <h6>ORDEN DE PRODUCCION</h6>
    </div>
    @foreach ($detalle_orden as $key => $do)
    <div class="row">
        <div class="col-4">
            <table class="table table-sm table-bordered" style="border: 2px solid black; ">
                <tr>
                    <th class="cell-color ">NO ORDEN PROD.</th>
                    <td class="font-weight-bold">{{ $do->numOrden }}</td>
                </tr>
                <tr>
                    <th class="cell-color">CODIGO</th>
                    <td>{{ $do->codigo }}</td>
                </tr>
                <tr>
                    <th class="cell-color">NOMBRE DEL PRODUCTO</th>
                    <td class="text-uppercase">{{ $do->nombre }}</td>
                </tr>
            </table>
        </div>
        <div class="col-12">
            <table class="table table-sm table-bordered" style="border: 2px solid black;margin-bottom: 0rem; margin-left: 31.5rem ;margin-right:2.5px;">
                <tr class="cell-border">
                    <th class="cell-border text-right" colspan="2">Razon MP vs Producto Terminado</th>
                    <th class="cell-border text-right" style="background-color:#F4CCCC; color:red;">{{ number_format($do->factor_fibral,2)}}</th>
                </tr>
                <tr>
                    <th class="cell-border cell-color text-center">PRODUCCIÓN</th>
                    <th class="cell-border cell-color text-center">TOTAL</th>
                    <th class="cell-border cell-color text-center">No.DE BOBINAS</th>
                </tr>
                <tbody>
                    <tr>
                        <td class="text-uppercase text-left">{{ $do->nombre}}</td>
                        <td class="text-right">{{ number_format($do->prod_real,2)}}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="cell-color text-right">TOTAL</td>
                        <td class="text-right">{{ number_format($do->prod_real,2)}}</td>
                        <td class="text-right">100%</td>
                    </tr>
                    <tr>
                        <td class="cell-color text-right">MERMA</td>
                        <td class="text-right"> {{ number_format($do->merma_total,2)}} </td>
                        <td class="text-right">16</td>
                    </tr>
                    <tr>
                        <td class="cell-color text-right">TOTAL PRODUCIDO</td>
                        <td class="text-right"> {{ number_format($do->prod_real,2)}}</td>
                        <td class="text-right">100%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <table class="table  table-sm table-bordered" style="border: 2px solid black; margin-left: 0rem; margin-top:-10rem ">
                <tr>
                    <th class="text-center" style="border: 2px solid black;" colspan="2">JORNADA</th>
                </tr>
                <tr>
                    <th class="cell-color">FECHA INICIO</th>
                    <td class="text-center">{{ $do->fechaInicio }}</td>
                </tr>
                <tr>
                    <th class="cell-color">FECHA FIN ORDEN</th>
                    <td class="text-center">{{ $do->fechaFinal }}</td>
                </tr>
                <tr>
                    <th class="cell-color">HORA INICIO</th>
                    <td class="text-center">{{ $do->horaInicio }}</td>
                </tr>
                <tr>
                    <th class="cell-color">HORA TERMINACION</th>
                    <td class="text-center">{{ $do->horaFinal }}</td>
                </tr>
            </table>
        </div>
        <div class="col-4">
            <table class="table table-sm table-bordere" style="border: 2px solid black; margin-left: 18rem; margin-top:-10rem  ">
                <tr>
                    <th class="text-center" style="border: 2px solid black;" colspan="3">HORAS PRODUCTIVAS</th>
                </tr>
                <tr>
                    <th class="cell-color">MAQUINA</th>
                    <td class="text-center">YANKEE 1</td>
                    <td class="text-center">YANKEE 2</td>
                </tr>
                <tr>
                    <th class="cell-color">HORAS JORNADAS</th>
                    <td class="text-center">20.33</td>
                    <td class="text-center">20.33</td>
                </tr>
                <tr>
                    <th class="cell-color">HORAS LABORALES</th>
                    <td class="text-center"> 20.33</td>
                    <td class="text-center"> 20.33</td>
                </tr>
                <tr>
                    <th class="cell-color">TIEMPO MUERTO</th>
                    <td class="text-center">0</td>
                    <td class="text-center"> - </td>
                </tr>
            </table>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <table class="table cell-border table-sm table-bordered" style="margin-bottom: 0rem; margin-top: -1.5rem; margin-right:2.5px;">
                <thead class="cell-border">
                    <tr class="text-center">
                        <th class="cell-color cell-border">CÓDIGO</th>
                        <th class="cell-color cell-border">DESCRIPCIÓN</th>
                        <th class="cell-color cell-border">U/M</th>
                        <th class="cell-color cell-border">CANTIDAD</th>
                        <th class="cell-color cell-border">COSTO UNITARIO</th>
                        <th class="cell-color cell-border">SUB TOTAL</th>
                    </tr>
                </thead>
                <tbody class="">
                    @foreach ($costo_orden_subTotal as $key => $co)
                    <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{  number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->subtotal,2) }}</td>
                    </tr>
                    <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{  number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->subtotal,2) }}</td>
                    </tr> <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{  number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->subtotal,2) }}</td>
                    </tr> <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{  number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->subtotal,2) }}</td>
                    </tr> <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{  number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->subtotal,2) }}</td>
                    </tr> <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{  number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->subtotal,2) }}</td>
                    </tr> <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{  number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->subtotal,2) }}</td>
                    </tr> <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{  number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->subtotal,2) }}</td>
                    </tr> <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{  number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->subtotal,2) }}</td>
                    </tr> <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{  number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->subtotal,2) }}</td>
                    </tr> <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{  number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">{{ number_format($co->subtotal,2) }}</td>
                    </tr>
                    <tr>
                        <td class="text-right" colspan="5"> <strong>COSTO TOTAL</strong> </td>
                        <td class="text-right">C$ {{number_format($do->costo_total),2}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" style=" margin-bottom:0rem;">
        <div class="col-6">
            <table class="table-sm cell-border mt-1" style="font-size: 9px !important; margin-bottom:0rem;">
                <thead style="border-bottom:2px solid black !important;">
                    <tr>
                        <th class="cell-color text-center">OBSERVACIONES</th>
                    </tr>
                </thead>
                <tbody class="">
                    <tr>
                        <td width="500px">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia, reiciendis? </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <table class="table-sm mt-5" style="font-size: 9px !important; margin-bottom:0rem; margin-left: 33rem;">
                <tr>
                    <td style="border-bottom: 2px solid black;"></td>
                </tr>
                <tr>
                    <td WIDTH="420px" HEIGHT="0px" style="margin-bottom:0rem;">
                        <p class="text-center">
                            Elaborado por: </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @endforeach


</body>

</html>