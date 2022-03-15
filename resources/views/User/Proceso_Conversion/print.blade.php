@extends('layouts.lyts_print')
@section('content')
@php 
    $recibido   = 0; 
    $valor_recibido   = 0; 
    $count_linea = 1;
@endphp

    <table width="100%">
        <tr>
            
            <td colspan=4 rowspan=0 align="left" ><b><i><font size=6 color="#000000">INNOVA INDUSTRIAL S,A</font></i></b></td>
            <td colspan=3 rowspan=0 align="right"><b>ORDEN PRODUCCION No.</b></td>
            <td colspan=3 rowspan=0 align="left" width="" ><b>{{$data['Informacion_Orden']['num_orden']}}</b></td>
        </tr>
        <tr>
            <td ><br></td>
        </tr>
        <tr>
            <td class="cabecera" colspan=10 align="center" valign=middle bgcolor="#FF9F3F"><b><i><font size=5 color="#000000">{{$data['Informacion_Orden']['nombre']}}</font></i></b></td>
        </tr>
        <tr>
            <td ><br></td>
        </tr>
        <tr>
            <td class="cabecera">FECHA INICIAL</td>
            <td class="cabecera" style="background: #FFFFFF;">{{$data['Informacion_Orden']['fecha_inicio']}}</td>
            <td class="cabecera">FECHA FINAL</td>
            <td class="cabecera" style="background: #FFFFFF;">{{$data['Informacion_Orden']['fecha_inicio']}}</td>
            <td class="cabecera"  rowspan=3  >Horas Trabajdas</td>
            <td class="cabecera"  rowspan=3 style="background: #FFFFFF;" >{{$data['Informacion_Orden']['hrs_trabajadas']}}</td>
            <td class="cabecera"  colspan=2 rowspan=3 >TOTAL DE BULTOS (UNDS)</td>
            <td class="cabecera"  colspan=2 rowspan=3 style="background: #FFFFFF;">{{$data['Informacion_Orden']['total_bultos_und']}}</td>		
        </tr>
        <tr>
            <td class="cabecera">HORA INICIAL</td>
            <td class="cabecera" style="background: #FFFFFF;">{{$data['Informacion_Orden']['hora_inicio']}}</td>
            <td class="cabecera">HORA FINAL</td>
            <td class="cabecera" style="background: #FFFFFF;">{{$data['Informacion_Orden']['hora_final']}}</td>
            
        </tr>
        <tr>
            <td class="cabecera">PESO %</td>
            <td class="cabecera" style="background: #FFFFFF;">{{$data['Informacion_Orden']['peso_procent']}}</td>
            <td class="cabecera">JR TOTAL (KG)</td>
            <td class="cabecera" style="background: #FFFFFF;">{{$data['Informacion_Orden']['jr_total_kg']}}</td>
            
        </tr>
    </table>
    

    <br/>

    <table width="100%" >
        <thead style="background-color: lightgray;">
            <tr>
                <th class="cabecera">CODIGO</th>
                <th class="cabecera">DESCRIPCION</th>
                <th class="cabecera">BULTOS</th>
                <th class="cabecera">PESO % ( SKU)</th>
                <th class="cabecera">KG</th>
            </tr>
        </thead>
        <tbody>
            @if (count($data['Producto']) > 0)
                @foreach($data['Producto'] as $key)

                @php 
                    $suma        = 0; 
                @endphp

                @php
                       // $recibido += preg_replace('/[^0-9-.]+/', '', $key['Total']);
                        
                    @endphp
                    <tr>
                        <td>{{ $key['ARTICULO'] }}</td>
                        <td>{{ $key['DESCRIPCION_CORTA'] }}</td>
                        <td align="right">{{ $key['BULTO'] }}</td>
                        <td align="right">{{ $key['PERSO_PORCENT'] }}</td>
                        <td align="right">{{ $key['KG'] }}</td>
                    </tr>
                    @php 
                        $count_linea++;
                    @endphp
                @endforeach
                @else
                <tr>
                    <th colspan="6">Sin RECIBOS</th>                    
                </tr>
            @endif
        </tbody>
    </table


    
    <div></div>

    <br/>
    <table width="100%" >
        <thead style="background-color: lightgray;">
            <tr>
                <td style=" " colspan=7 align="center" bgcolor="#FFE699">
                    <b>
                        MATERIA PRIMA DIRECTA (M.P)</font>
                    </td>            
            </tr>
            <tr>
                <th class="cabecera">CODIGO</th>
                <th class="cabecera">DESCRIPCION</th>
                <th class="cabecera">REQUISA</th>
                <th class="cabecera">PISO</th>
                <th class="cabecera">CONSUMO</th>
                <th class="cabecera" colspan="2">MERMA</th>
            </tr>
        </thead>
        <tbody>
            @if (count($data['Materia_prima']) > 0)
                @foreach($data['Materia_prima'] as $key)

                @php 
                    $suma        = 0; 
                @endphp

                @php
                       // $recibido += preg_replace('/[^0-9-.]+/', '', $key['Total']);
                        
                    @endphp
                    <tr>
                        <td>{{ $key['ARTICULO'] }}</td>
                        <td>{{ $key['DESCRIPCION_CORTA'] }}</td>
                        <td align="right">{{ $key['REQUISA'] }}</td>
                        <td align="right">{{ $key['PISO'] }}</td>
                        <td align="right">{{ $key['PERSO_PORCENT'] }}</td>
                        <td align="right">{{ $key['MERMA'] }}</td>
                        <td align="right">{{ $key['MERMA_PORCENT'] }}</td>
                    </tr>
                    @php 
                        $count_linea++;
                    @endphp
                @endforeach
                @else
                <tr>
                    <th colspan="6">Sin RECIBOS</th>                    
                </tr>
            @endif
        </tbody>
    </table
    <br/>
    <table width="100%" >
        <thead style="background-color: lightgray;">
            <tr>
                <td style=" " colspan=7 align="center" bgcolor="#FFE699">
                    <b>
                        TIEMPOS PAROS</font>
                    </td>            
            </tr>
            <tr>
                <th class="cabecera">DESCRIPCION</th>
                <th class="cabecera">DIA</th>
                <th class="cabecera">NOCHE</th>
                <th class="cabecera">TOTAL HRS</th>
                <th class="cabecera" colspan="2">No. Personas</th>
            </tr>
        </thead>
        <tbody>
            @if (count($data['Materia_prima']) > 0)
                @foreach($data['Materia_prima'] as $key)

                @php 
                    $suma        = 0; 
                @endphp

                @php
                       // $recibido += preg_replace('/[^0-9-.]+/', '', $key['Total']);
                        
                    @endphp
                    <tr>
                        <td>{{ $key['DESCRIPCION_CORTA'] }}</td>
                        <td align="right">{{ $key['REQUISA'] }}</td>
                        <td align="right">{{ $key['PISO'] }}</td>
                        <td align="right">{{ $key['PERSO_PORCENT'] }}</td>
                        <td align="right">{{ $key['MERMA'] }}</td>
                        <td align="right">{{ $key['MERMA_PORCENT'] }}</td>
                    </tr>
                    @php 
                        $count_linea++;
                    @endphp
                @endforeach
                @else
                <tr>
                    <th colspan="6">Sin RECIBOS</th>                    
                </tr>
            @endif
        </tbody>
    </table
    <div class="text-center ml "><br><br><br><br><br><br></div>
    <table width="100%" class="text-center">  
        <tr>            
            <td>_____________________________________<br><strong>Preparado y Revisado por:</strong></td>
            <td>_____________________________________<br><strong>Autorizado por:</strong> </td>
        </tr>
        <tr>
            <td><strong>JEFE DE TURNO</strong> </td>
            <td><strong>Sebastian Pinell</strong></td>
        </tr>
        <tr>
            <td><strong></strong> </td>
            <td><strong>INTENDENTE DE PLANTA</strong></td>
        </tr>
    </table>
@endsection