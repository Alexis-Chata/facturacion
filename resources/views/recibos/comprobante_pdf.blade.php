<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Impact;
        }
        .w-15{
            width: 15%;
        }
        .w-20{
            width: 20%;
        }
        h1,h2,h3,h4,h5 {
            margin: 0px;
            font-weight: 500;
        }
        .color-naranja {
            color : #c65911;
        }
        .bg-naranja {
            color : #c65911;
        }
        .color-gris {
            color : #757171;
        }
        .color-white{
            color: white;
        }
        .bg-gris {
            color : #757171;
        }
        .color-azul {
            color : #2f75b5;
        }
        .bg-azul {
            background-color : #2f75b5;
        }
        .text-right{
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .fw-500 {
            font-weight: 500;
        }
        .fw-300 {
            font-weight: 300;
        }

        .align-top {
            vertical-align: top;
        }
        .p-2 {
            padding: 3px;
        }
        .mt-5{
            margin-top: 5px
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr class="align-top">
                <th class="w-15"><img src="{{asset('imagenes/logo.jpeg')}}" alt="" width="100%"></th>
                <th>
                    <h1 class="color-naranja">ESPACIO ARQUITECTURA</h1>
                    <h3 class="color-gris">José Otoniel Calderón Avila, Nit: 3487448-8</h3>
                    <h5 class="color-gris">5a. Avenida y 1a. Calle 5-50, Zona 6, Huehueteanngo</h5>
                    <h5 class="color-gris">Móvil : 4729 6758</h5>
                </th>
                <th class="w-15">
                    <img src="{{asset('imagenes/qr.png')}}" alt="" width="100%">
                    <div class="text-right color-azul fw-500">RECIBO</div>
                </th>
            </tr>
        </thead>
    </table>
    <table width="100%" class="mt-5">
        <tbody>
            <tr>
                <td class="bg-azul color-white p-2 fw-300">DATOS DEL CLIENTE</td>
                <td class="w-20 p-2"></td>
                <td class="bg-azul color-white p-2 fw-300 text-center">N° DE RECIBO</td>
                <td class="bg-azul color-white p-2 fw-300 text-center">FECHA</td>
            </tr>
            <tr>
                <td class="p-2 fw-300">LUIS PEDRO DE LEON</td>
                <td class="w-20 p-2"></td>
                <td class="p-2 fw-300 text-center">8</td>
                <td class="p-2 fw-300 text-center">1/03/2022</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
