<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orden</title>
</head>

<body>
    <!--HEADER-->
    <table class="div-1Header">
        <tr>
            <td class="logotd">
                <img id="" src="{{ storage_path('app/public/logo/logo_politecnica.png')}}" alt="logo">
            </td>
            <td class="datos-grales-td">
                <table class="table_h_factura">
                    <thead>
                        <th class="headerDatosh titulos">Universidad Politécnica - UNVES</th>
                    </thead>
                    <tr>
                        <td>
                            <p>
                                MATERIA: <span>{{ $alumnos->materia->nombre }}</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>CLASE: <span>{{ $alumnos->codigo}}</span> </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>PROFESOR/A: <span>
                            {{ $alumnos->docente->persona->nombre}} 
                            {{ $alumnos->docente->persona->apellido}}
                            </span> </p>
                        </td>
                    </tr>
                     <tr>
                        <td>
                            <p>FECHA: <span>{{ $currentDate }}</span> </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--DATOS-->
    <!--MATERIAL/PRODUCTO-->
    <table class="table_materiales">
        <thead>
            <tr>
                <td>Número</td>
                <td>Alumno</td>
                <td>Cédula</td>
                <td>Correo</td>
                <td>Teléfono</td>
                <td>Dirección</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumnos->alumnos as $index => $alumno)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $alumno->persona->nombre }} {{ $alumno->persona->apellido }}</td> 
                <td>{{ $alumno->persona->ci_numero }}</td> 
                <td>{{ $alumno->user->email }}</td> 
                <td>{{ $alumno->persona->telefono }}</td> 
                <td>{{ $alumno->persona->ciudade->nombre }}</td> 
            </tr>
        @endforeach
        </tbody>
    </table>
     <!--DATOS FINALES-->

    <!--FIRMA-->
    <div class="firma">
        Firma
    </div>
    <!--FOOTER-->
    <footer>
        <p>Impreso por {{ $userEmail }} en fecha {{ $currentDate }} </p>
    </footer>
</body>

</html>
<style>
    /*ESTILOS GRALES*/
* {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
}

.titulos {
    font-size: 15px;
    text-transform: uppercase;
}

    /*HEADER*/
.div-1Header, .div-1Datos {
    width: 100%;
}

.logotd {
    width: 20%;
    height: 50px;
    overflow: hidden;
}

.logotd img {
    max-width: 100%;
    max-height: 100%;
    display: block;
    object-fit: cover; 
}

    .datos-grales-td, .receptor{
        width: 50%;
    }

    .table_h_factura{
        width: 50%;
        height: 150px;
        background-color: #FFF;
        width: 100%;
        margin: 0px;
        padding: 0px;
    }
    .headerDatosh {
        text-align: right;
        color: #FFF;
        padding: 5px;
        background-color: rgb(24, 140, 207);
    }

    .table_h_factura tr td p {
        margin: 0px;
        padding: 2px;
        text-align: right;
        padding-right: 5px;
        
    }
    /*DATOS*/
    .table_receptor, .table_datos {
        width: 42%;
        height: 100px;
        background-color: rgba(243, 243, 243, 0.521);
        width: 100%;
        margin: 0px;
        padding: 10px;
        border-radius: 5px;
    }
    .table_receptor tr td p{
        margin: 0px;
        padding: 2px;
        text-align: left;
    }
    .tituloRec{
        color: rgb(24, 140, 207);
    }
    .table_datos tr td p{
        margin: 0px;
        padding: 2px;
        text-align: left;
    }
    /*MATERIALES*/
    .table_materiales{
        width: 100%;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .table_materiales thead tr{
        background-color:rgb(24, 140, 207);
        color: #FFF;
    }
    .table_materiales thead tr td{
        padding: 5px;
        text-align: center;
        font-size: 14px;
    }
    .table_materiales tr td{
        text-align: center;
        padding: 5px;
        border-bottom: 1px solid rgba(20, 20, 20, 0.096);
    }
    /*DATOS FINALES*/
    .table_datosFtxt{
        width: 70%;
        height: 100px;
        width: 100%;
        margin: 0px;
    }
    .datosFinales{
        width: 30%;
    }
    .datosFinales .table_datosfinales{
        width: 42%;
        height: 100px;
        width: 100%;
        margin: 0px;
        padding: 10px;
        border: 1px solid rgba(20, 20, 20, 0.096);
    }
    .datosFinales .table_datosfinales tr td p{
        margin: 0px;
        padding: 2px;
        text-align: left;
    }
    /*FIRMA*/
    .firma{
        border-top: 1px solid rgba(20, 20, 20, 0.5);
        text-align: center;
        width: 30%;
        margin-left: 70%;
        margin-top: 80px;
        padding-top:5px;
    }
    /*FOOTER*/
    footer{
        width: 100%;
        text-align: center;
        position: absolute;
        bottom: 0px;
    }
</style>