<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DETALLE DE ORDENES</title>
</head>

<body>
    <style>

        @media (min-width: 1200px) {
            .table-format {
                max-width: 1140px !important;
            }
        }

        table {
            text-indent: initial;
            border-collapse: collapse;
            font-size: 10px !important;
        }

        .cell-color {
            background-color: #c6e0b4;
        }

        .table-style {
            margin-left: 25rem;
        }

        .table {
            font-family: Verdana, Arial, sans-serif !important;
            color: #2E2C2B;
            max-width: 100% !important;
            margin-bottom: 1rem;
            background-color: transparent;
            border: 2px solid black;

        }

        .text-center {
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .text-right {
            align-items: right;
            justify-content: right;
            text-align: right;
            padding-right: 4px;
        }

        .text-left {
            align-items: left;
            justify-content: left;
            text-align: left;
        }

        .table-format {
            width: 100% !important;
            border: 2px solid black;

        }

        .title {
            margin-top: -1rem;
        }

        .cell-border {
            border: 2px solid black;
            border-spacing: 0px !important;
        }

        .table td,
        .table th {
            /* white-space: nowrap; */
            padding: 0.3rem 0.3rem;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }
    </style>
    <div class="text-center">
        <h2 class="title">INNOVA INDUSTRIAS S.A</h2>
        <h5 class="title">ORDEN DE PRODUCCION</h5>
    </div>
    @foreach ($detalle_orden as $key => $do)
    <div class="row">
        <div class="col-4">
            <table class="table">
                <tr>
                    <th class="text-left cell-color ">NO ORDEN PROD.</th>
                    <td class="font-weight-bold">{{ $do->numOrden }}</td>
                </tr>
                <tr>
                    <th class="text-left cell-color">CODIGO</th>
                    <td>{{ $do->codigo }}</td>
                </tr>
                <tr>
                    <th class="text-left cell-color">NOMBRE DEL PRODUCTO</th>
                    <td class="text-uppercase">{{ $do->nombre }}</td>
                </tr>
            </table>
        </div>
        <div class="col-5">
            <table class="table" style="margin-left: 38.9rem; margin-top: -6.1rem">
                <tr class="">
                    <th class="cell-border text-right" colspan="2">Razon MP vs Producto Terminado</th>
                    <th class="cell-border text-right" style="background-color:#F4CCCC; color:red;">{{ number_format($do->factor_fibral,2)}}</th>
                </tr>
                <tr>
                    <th WIDTH="100px" class="cell-border cell-color text-center">PRODUCCIÓN</th>
                    <th WIDTH="100px" class="cell-border cell-color text-center">TOTAL</th>
                    <th WIDTH="100px" class="cell-border cell-color text-center">No.DE BOBINAS</th>
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
        <div class="col-4">
            <table class="table table-sm " style="margin-top:-3.5rem;">
                <tr>
                    <th class="text-center cell-border" style="" colspan="2">JORNADA</th>
                </tr>
                <tr>
                    <th class="text-left cell-color">FECHA INICIO</th>
                    <td WIDTH="100px" class="text-center">{{ $do->fechaInicio }}</td>
                </tr>
                <tr>
                    <th class="text-left cell-color">FECHA FIN ORDEN</th>
                    <td class="text-center">{{ $do->fechaFinal }}</td>
                </tr>
                <tr>
                    <th class="text-left cell-color">HORA INICIO</th>
                    <td class="text-center">{{ $do->horaInicio }}</td>
                </tr>
                <tr>
                    <th class="text-left cell-color">HORA TERMINACION</th>
                    <td class="text-center">{{ $do->horaFinal }}</td>
                </tr>
            </table>
        </div>
        <div class="col-4">
            <table class="table table-sm" style="margin-left: 16rem; margin-top:-8.1rem">
                <tr>
                    <th class="text-center " style="border-bottom: 2px solid black;" colspan="3">HORAS PRODUCTIVAS</th>
                </tr>
                <tr>
                    <th WIDTH="100px" class="text-left cell-color">MAQUINA</th>
                    <td WIDTH="60px" class="text-center">YANKEE 1</td>
                    <td WIDTH="60px" class="text-center">YANKEE 2</td>
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
                    <th class="text-left cell-color">TIEMPO MUERTO</th>
                    <td class="text-center">0</td>
                    <td class="text-center"> - </td>
                </tr>
            </table>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <table class="table-format cell-border" style="margin-right: 4rem; margin-top: -0.2rem;">
                <thead class="">
                    <tr class="text-center">
                        <th class="cell-color cell-border">CÓDIGO</th>
                        <th class="cell-color cell-border">DESCRIPCIÓN</th>
                        <th class="cell-color cell-border">U/M</th>
                        <th class="cell-color cell-border">CANTIDAD</th>
                        <th class="cell-color cell-border">COSTO UNITARIO</th>
                        <th class="cell-color cell-border" style="border-right: none !important;">SUB TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($costo_orden_subTotal as $key => $co)
                    <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{ number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->subtotal,2) }}</td>
                    </tr>
                    <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{ number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->subtotal,2) }}</td>
                    </tr>
                    <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{ number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->subtotal,2) }}</td>
                    </tr>
                    <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{ number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->subtotal,2) }}</td>
                    </tr>
                    <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{ number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->subtotal,2) }}</td>
                    </tr>
                    <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{ number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->subtotal,2) }}</td>
                    </tr>
                    <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{ number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->subtotal,2) }}</td>
                    </tr>
                    <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{ number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->subtotal,2) }}</td>
                    </tr>
                    <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{ number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->subtotal,2) }}</td>
                    </tr>
                    <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{ number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->subtotal,2) }}</td>
                    </tr>
                    <tr class="unread text-center">
                        <td class="dt-center">{{ $co->codigo}}</td>
                        <td class="dt-center text-left">{{ $co->descripcion }}</td>
                        <td class="dt-center">{{ $co->unidad_medida }}</td>
                        <td class="dt-center text-right">{{ number_format($co->cantidad,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->costo_unitario,2)}}</td>
                        <td class="dt-center text-right">C$ {{ number_format($co->subtotal,2) }}</td>
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
            <table class="table-sm cell-border" style="margin-bottom:0rem; margin-top: 10px">
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