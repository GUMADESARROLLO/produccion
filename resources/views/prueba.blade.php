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
        .cell-color {
            background-color: #c6e0b4;
            border: 2px solid black;
        }

        .table-style {
            margin-left: 32rem;
        }
    </style>

    <div class="title text-center">
        <h2>INNOVA INDUSTRIAS S.A</h2>
        <h4>ORDEN DE PRODUCCION</h4>
    </div>
    <div class="container-fluid p-0 m-0 m-5">
        <!-- primer tabla -->
        <div class="row">
            <div class="col-6">
                <table class="table table-bordered" style="border: 2px solid black;">
                    <tr>
                        <th class="cell-color">CODIGO</th>
                        <td>2IN00076</td>
                    </tr>
                    <tr>
                        <th class="cell-color">NOMBRE DEL PRODUCTO</th>
                        <td>JUMBO ROLL CHOLIN 19 GSM 100% RC</td>
                    </tr>
                </table>
            </div>
            <div class="col">
                <table class="table table-style table-bordered mr-0" style="border: 2px solid black;">
                    <tr>
                        <th class="cell-color">NO ORDEN PROD.</th>
                        <td>NO ORDEN SAP</td>
                    </tr>
                    <tr>
                        <th class="cell-color">4821</th>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-bordered" style="border: 2px solid black; margin-top: -5rem;">
                    <tr>
                        <th class="cell-color">FECHA INICIO</th>
                        <td>03/10/2021</td>
                    </tr>
                    <tr>
                        <th class="cell-color">FECHA FIN ORDEN</th>
                        <td>04/10/2021</td>
                    </tr>
                    <tr>
                        <th class="cell-color">HORA INICIO</th>
                        <td>02:30 p. m. </td>
                    </tr>
                    <tr>
                        <th class="cell-color">HORA TERMINACION</th>
                        <td>05:32 a. m. </td>
                    </tr>
                    <tr>
                        <th class="cell-color">TIPO DE CAMBIO</th>
                        <td> C$35.3518 </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-6 ">
                <table class="table table-bordered" style="border: 2px solid black;">
                    <tr>
                        <th class="cell-color">MAQUINA</th>
                        <td>YANKEE 1</td>
                        <td>YANKEE 2</td>
                    </tr>
                    <tr>
                        <th class="cell-color">HORAS JORNADAS</th>
                        <td>20.33</td>
                        <td>20.33</td>
                    </tr>
                    <tr>
                        <th class="cell-color">HORAS LABORALES</th>
                        <td> 20.33</td>
                        <td> 20.33</td>
                    </tr>
                    <tr>
                        <th class="cell-color">TIEMPO MUERTO</th>
                        <td>0</td>
                        <td> - </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-6 ">
                <table class="table table-bordered" style="border: 2px solid black;">
                    <thead></thead>
                    <tr>
                        <th>PRODUCCIÓN</th>
                        <th>TOTAL</th>
                        <th>No.DE BOBINAS</th>
                    </tr>
                    <tbody>
                        <tr>
                            <td>ROLLO JUMBO 21 GMS 100% RC</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>ROLLO JUMBO 18 GMS 100% RC</td>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <td>ROLLO JUMBO 36 GSM 100% RC</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>ROLLO JUMBO 19 GMS CHOLIN 100% RC</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>TOTAL</td>
                            <td> 7,765.00</td>
                            <td>100%</td>
                        </tr>
                        <tr>
                            <td>MERMA</td>
                            <td> - </td>
                            <td> 0% </td>
                        </tr>
                        <tr>
                            <td>TOTAL PRODUCIDO</td>
                            <td> 7,765.00</td>
                            <td>100%</td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <table class="table table-bordered" style="border: 2px solid black;">
                    <thead>
                        <tr class="text-center">
                            <th class="cell-color">#</th>
                            <th class="cell-color">CÓDIGO</th>
                            <th class="cell-color">DESCRIPCIÓN</th>
                            <th class="cell-color">U/M</th>
                            <th class="cell-color">CANTIDAD</th>
                            <th class="cell-color">COSTO UNITARIO</th>
                            <th class="cell-color">COSTO TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($costo_orden as $key => $co)
                        <tr class="unread text-center">
                            <td class="dt-center">{{ $key+1 }}</td>
                            <td class="dt-center">{{ $co->id }}</td>
                            <td class="dt-center">{{ $co->numOrden }}</td>
                            <td class="dt-center">COSTO DIRECTO</td>
                            <td class="dt-center">Hora</td>
                            <td class="dt-center">{{ $co->cantidad }}</td>
                            <td class="dt-center">{{ $co->costo_unitario }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</body>

</html>