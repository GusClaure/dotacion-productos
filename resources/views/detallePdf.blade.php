<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? '' }}</title>
    <style>
    h1 {
        text-align: center;
        text-transform: uppercase;
    }


    .beneficiario {
        background-color: #9BF8ED;
        text-align: center;
        width: 100%;
        padding-top: 5px;
        padding-bottom: 5px;
        border-top: 1px solid;
        border-left: 1px solid;
        border-right: 1px solid;
    }

    .text-beneficiario {
        width: 100%;
        text-align: justify;
        border-bottom: 1px solid;
        border-left: 1px solid;
        border-right: 1px solid;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    table tr th {
        background-color: #9BF8ED;
        padding: 3px;
        border: 1px solid;
        /* font-size: 13px; */
    }

    table tr td {
        text-align: center;
        border: 1px solid;
        font-size: 14px;
    }
    </style>
</head>

<body>

    <div style="position: relative;">
        <img style="position: absolute; left: 0px;" src="data:image/png;base64,{{ $image }}" alt="Logo" height="75px">
        {{-- <img style="position: absolute; right: 0px;" src="data:image/png;base64,{{ $image }}" alt="Logo" height="75px"> --}}
    </div>

    <div style="text-align: center;">
        <h3><u>FORMULARIO DE ENTREGA DE INSUMOS AGROPECUARIOS</u></h3>
        <p style="position:relative; top:-18px">DOTACIÓN EXCEPCIONAL DE INSUMOS AGROPECUARIOS A PRODUCTORES
            AGROPECUARIOS DEL MUNICIPIO</p>
    </div>
    <hr style="position:relative; top:-28px">
    <div class="contenido">
        <div style="position:relative; left: 40px;">
            <input type="text" value="N.º" style="width: 35px; text-align: center;">
            <input type="text" value="{{ $data_person[0]->nro_formulario ?? '' }}" style="width: 100px; position:relative; left:-10px; text-align: center;">
        </div>
        <div style="position:relative; top:-34px; left: 400px;">
            <input type="text" value="Nro. Cel." style="width: 100px; text-align: center;">
            <input type="text" value="{{ $data_person[0]->nro_cel ?? '' }}"
                style="width: 150px; position:relative; left:-10px; text-align: center;">
        </div>
        <!-- panel -->
        <div style="text-align: center;">
            <div class="beneficiario">
                <b>BENEFICIARIO(A)</b>
            </div>
            <div class="text-beneficiario">
                <p style="padding-right: 15px; padding-left: 15px; position:relative; top:-10px;">Yo
                    <b>{{ $name_person ?? '' }}</b>,
                    con C.I. <b>{{ $data_person[0]->ci ?? '' }}</b>, declaro recibir <b>DOTACIÓN EXCEPCIONAL DE INSUMOS
                        AGROPECUARIOS</b>, del
                    Gobierno Autónomo Municipal de Cochabamba, en cumplimiento a la Ley Municipal Nro. 727/2020 de fecha
                    2 de Octubre del 2020 y la ley N.º 1307 del 29 de Junio del 2020 con el objetivo de reactivar el
                    aparato productivo local (Agropecuario), fortalecer a los productores del Municipio, de acuerdo al
                    siguiente detalle:</p>
            </div>
        </div>

        <!-- lista de productos entregados -->
        <div style="padding-top: 30px;">
            <!-- border="1" -->
            <table style="width: 100%;" CELLSPACING="0">
                <tr>
                    <th>Nro.</th>
                    <th>NOMBRE DEL PRODUCTO/INSUMO</th>
                    <th>PRESENTACION-UNIDAD</th>
                    <th>CANTIDAD</th>
                    <th>FECHA</th>
                </tr>

                @for ($i = 1; $i <= 5; $i++) <tr>
                    <td>{{ $i }}</td>
                    <td style="text-align: left !important;"><b>{{ $data_person[($i - 1)]->nombre_producto ?? '' }}</b></td>
                    <td>{{ $data_person[($i - 1)]->unidad ?? '' }}</td>
                    <td>{{ $data_person[($i - 1)]->cantidad_producto_entregado ?? ''}}</td>
                    @if(isset($data_person[($i - 1)]->fecha_entrega))
                    <td>{{ date("d/m/Y", strtotime($data_person[($i - 1)]->fecha_entrega ?? '')) }}</td>  
                    @else
                    <td></td>
                    @endif
                    </tr>
                @endfor


            </table>
        </div>

        <!-- texto pie de pagina -->
        <div style="text-align: justify;">
            <p>El presente formulario se constituye en una declaración jurada, en caso de comprobarse que los datos
                consignados sean falsos, el Gobierno Autónomo Municipal de Cochabamba podrá ejercer las acciones legales
                que corresponda a efectos de determinar responsabilidad administrativa, civil y/o penal, así como
                proceder al
                resarcimiento del daño económico.</p>
        </div>

        <div>
            <!-- firma beneficiario left-->
            <div style="position:left; padding-top:80px;">
                <p>_______________________________________</p>
                <p style="position:relative; left: 130px; top: -15px;">FIRMA</p>
                <p style="position:relative; left: 100px; top: -30px;"><b>BENEFICIARIO</b></p>
                <p style="position:relative; left: 80px; top: -45px;"><b>RECIBI CONFORME</b></p>
            </div>

            <!-- firma responsable rigth -->
            <div style="position:relative; top: -155px; left: 400px;">
                <p>_______________________________________</p>
            </div>
            <div style="position:relative; top: -185px; left: 400px;">
                <p style="position: absolute; left: 90px;">FIRMA Y SELLO</p>
                <p style="position: absolute; left: 10px; top: 17px; "><b>FUNCIONARIO RESPONSABLE GAMC</b></p>
                <p style="position: absolute; left: 55px; top: 34px;"><b>ENTREGUE CONFORME</b></p>
            </div>
        </div>

        <div>
            <a title="Verificacion" target="_blank" href="{{ $url ?? '' }}"><img style="position: absolute; left: 42%; top: 83%;" src="data:image/png;base64,{{ $qr_image ?? ''}}" alt="Logo"
                height="120px"></a>
        </div>

        <div style="position:relative;"> 
            <p style="position: absolute; left: 240px; top: 10px;">Cochabamba {{ date('d') }} de {{ $mes ?? '' }} del {{ date('Y') }}</p>
        </div>
        <div style="position:relative;"> 
            <p style="position: absolute; left:550px; top: 10px; font-size: 10px;">Hora de Impresion: {{ date('h:i:s') }}</p>
        </div>
    </div>
</body>

</html>