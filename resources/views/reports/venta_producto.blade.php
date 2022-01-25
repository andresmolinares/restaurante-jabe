<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/estilo_pdf.css') }}">
   </head>
<body>
    <header>
        <br>
        <p><strong>Restaurant JABE</strong></p>
    </header>
    <main>
        <div class="container">
            <center><strong><h5><b>VENTAS POR PRODUCTO</b></h5></strong></center>



        <table class="table table-striped text-center">
            <thead class="thead-dark">
                <tr>
                    <th>PRODUCTO</th>
                    <th>UNIDADES VENDIDAS</th>
                    <th>PRECIO UNITARIO</th>
                    <th>TOTAL VENDIDO</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($carts as $cart)
                <tr>
                    <td>{{ $cart->producto }}</td>
                    <td>{{ $cart->unidades }}</td>
                    <td>${{ $cart->precio_unitario }} USD</td>
                    <td>${{ $cart->total_vendido }} USD</td>
                </tr>

                @endforeach
            </tbody>
        </table>

    </main>


</body>
</html>
