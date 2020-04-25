<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Carta</title>
</head>
<body>
    <div>
        <?php
            include_once("Header.html");
        ?>
    </div>

    <div class="tab_carta_inicio">
        <button class="carta_button" onclick="openCarta(event, 'Medias')">
            Medias
        </button>
        <button class="carta_button" onclick="openCarta(event, 'Combinados')">
            Combinados
        </button>
        <button class="carta_button" onclick="openCarta(event, 'Carnes')">
            Carnes
        </button>
        <button class="carta_button" onclick="openCarta(event, 'Pescados')">
            Pescados
        </button>
        <button class="carta_button" onclick="openCarta(event, 'Bebidas')">
            Bebidas
        </button>
        <button class="carta_button" onclick="openCarta(event, 'Postres')">
            Postres
        </button>
    </div>

    <div id="Medias" class="tab_carta_cont">
        <h3>Medias</h3>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
        </table>
    </div>

    <div id="Combinados" class="tab_carta_cont">
        <h3>Cambinados</h3>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
        </table>
    </div>

    <div id="Carnes" class="tab_carta_cont">
        <h3>Carnes</h3>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
        </table>
    </div>

    <div id="Pescados" class="tab_carta_cont">
        <h3>Pescados</h3>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
        </table>
    </div>

    <div id="Bebidas" class="tab_carta_cont">
        <h3>Bebidas</h3>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
        </table>
    </div>

    <div id="Postres" class="tab_carta_cont">
        <h3>Postres</h3>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Stock</th>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
            <tr>
                <td>Ejemplo</td>
                <td>999</td>
                <td>999</td>
            </tr>
        </table>
    </div>

    <script>
        function openCarta(evt, tablaProducto) {
            var i, tab_cart_cont, carta_button;

            tab_cart_cont = document.getElementsByClassName("tab_cart_cont");
            for (i = 0; i < tab_cart_cont.length; i++){
                tab_cart_cont[i].style.display = "none";
            }

            carta_button = document.getElementsByClassName("carta_button");
            for (i = 0; i < tab_cart_cont.length; i++){
                carta_button[i].className = carta_button[i].className.replace(" active","")
            }

            document.getElementById(tablaProducto).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</body>
</html>