
--Inserccion Clientes
execute add_cliente(w_tlf_cliente=>'661823587',w_nombre_cliente=>'Juan',w_apellidos_cliente=>'Perez');
execute add_cliente(w_tlf_cliente=>'625402497',w_nombre_cliente=>'Jose',w_apellidos_cliente=>'Aguilar');
execute add_cliente(w_tlf_cliente=>'644914211',w_nombre_cliente=>'Laura',w_apellidos_cliente=>'Martin');
execute add_cliente(w_tlf_cliente=>'718518710',w_nombre_cliente=>'Maria',w_apellidos_cliente=>'Moreno');
execute add_cliente(w_tlf_cliente=>'719518710',w_nombre_cliente=>'Manuel',w_apellidos_cliente=>'Velero');

--Inserccion Carta
execute add_producto_carta(w_nombre_producto=>'Filetes de pollo',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Solomillo',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Abanico Iberico',w_fechainicio=>NULL,w_fechafin=>NULL);

execute add_producto_carta(w_nombre_producto=>'Filete de emperador',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Merluza',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Lenguado',w_fechainicio=>NULL,w_fechafin=>NULL);

execute add_producto_carta(w_nombre_producto=>'Helado de vainilla',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Flan Casero',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Tarta de queso',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Natillas',w_fechainicio=>NULL,w_fechafin=>NULL);

execute add_producto_carta(w_nombre_producto=>'Coca-Cola',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Fanta Limon',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Fanta Naranja',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'7Up',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Caña',w_fechainicio=>NULL,w_fechafin=>NULL);

execute add_producto_carta(w_nombre_producto=>'Calamares',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Chipirones',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Croquetas',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Empanadillas',w_fechainicio=>NULL,w_fechafin=>NULL);

execute add_producto_carta(w_nombre_producto=>'Combinado1',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Combinado2',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Combinado3',w_fechainicio=>NULL,w_fechafin=>NULL);
execute add_producto_carta(w_nombre_producto=>'Combinado4',w_fechainicio=>NULL,w_fechafin=>NULL);

--Inserccion Productos
execute add_producto(w_nombre=>'Filetes de pollo',w_precio_producto=>5,w_descripcion=>'Carne',w_cantidad=>8);
execute add_producto(w_nombre=>'Solomillo',w_precio_producto=>8,w_descripcion=>'Carne',w_cantidad=>8);
execute add_producto(w_nombre=>'Abanico Iberico',w_precio_producto=>7,w_descripcion=>'Carne',w_cantidad=>11);

execute add_producto(w_nombre=>'Coca-Cola',w_precio_producto=>1,w_descripcion=>'Bebida',w_cantidad=>26);
execute add_producto(w_nombre=>'Fanta Limon',w_precio_producto=>1,w_descripcion=>'Bebida',w_cantidad=>30);
execute add_producto(w_nombre=>'Fanta Naranja',w_precio_producto=>1,w_descripcion=>'Bebida',w_cantidad=>21);
execute add_producto(w_nombre=>'7Up',w_precio_producto=>1,w_descripcion=>'Bebida',w_cantidad=>12);

execute add_producto(w_nombre=>'Calamares',w_precio_producto=>4,w_descripcion=>'Media',w_cantidad=>12);
execute add_producto(w_nombre=>'Chipirones',w_precio_producto=>4,w_descripcion=>'Media',w_cantidad=>9);
execute add_producto(w_nombre=>'Croquetas',w_precio_producto=>3,w_descripcion=>'Media',w_cantidad=>20);
execute add_producto(w_nombre=>'Empanadillas',w_precio_producto=>5,w_descripcion=>'Media',w_cantidad=>10);

execute add_producto(w_nombre=>'Helado de vainilla',w_precio_producto=>2,w_descripcion=>'Postre',w_cantidad=>19);
execute add_producto(w_nombre=>'Flan Casero',w_precio_producto=>3,w_descripcion=>'Postre',w_cantidad=>10);
execute add_producto(w_nombre=>'Tarta de queso',w_precio_producto=>3,w_descripcion=>'Postre',w_cantidad=>13);
execute add_producto(w_nombre=>'Natillas',w_precio_producto=>2,w_descripcion=>'Postre',w_cantidad=>8);

execute add_producto(w_nombre=>'Combinado1',w_precio_producto=>2,w_descripcion=>'Combinado',w_cantidad=>8);
execute add_producto(w_nombre=>'Combinado2',w_precio_producto=>2,w_descripcion=>'Combinado',w_cantidad=>8);
execute add_producto(w_nombre=>'Combinado3',w_precio_producto=>2,w_descripcion=>'Combinado',w_cantidad=>8);
execute add_producto(w_nombre=>'Combinado4',w_precio_producto=>2,w_descripcion=>'Combinado',w_cantidad=>8);

execute add_producto(w_nombre=>'Merluza',w_precio_producto=>2,w_descripcion=>'Pescado',w_cantidad=>11);
execute add_producto(w_nombre=>'Filete de emperador',w_precio_producto=>2,w_descripcion=>'Pescado',w_cantidad=>9);
execute add_producto(w_nombre=>'Lenguado',w_precio_producto=>2,w_descripcion=>'Pescado',w_cantidad=>11);

--Insertar empleados

execute add_empleado(w_dni=>'12345678A',w_nombreemp=>'Paco',w_apellidoemp=>'De Novales',w_telefono=>'123456789',w_poblacion=>'Sevilla',w_codigopostal=>41000,w_fechaalta=>TO_DATE('2017-02-25', 'YYYY-MM-DD'),w_fechabaja=>TO_DATE('2024-01-20','YYYY-MM-DD'),w_hashcontraseña=>'Hola12345',w_saltcontraseña=>'Hola12345',w_categoria=>'CAMARERO');

BEGIN
add_empleado(w_dni=>'11345678A',w_nombreemp=>'Lucia',w_apellidoemp=>'Robles',w_telefono=>'113456789',
w_poblacion=>'Sevilla',w_codigopostal=>41100,w_fechaalta=>TO_DATE('2018-02-25', 'YYYY-MM-DD'),
w_fechabaja=>TO_DATE('2021-01-20','YYYY-MM-DD'),w_hashcontraseña=>'Hola12345',w_saltcontraseña=>'Hola12345',w_categoria=>'CAMARERO');
END;

BEGIN
add_empleado(w_dni=>'22245678A',w_nombreemp=>'Marcos',w_apellidoemp=>'Lanos',w_telefono=>'222456789',
w_poblacion=>'Sevilla',w_codigopostal=>42100,w_fechaalta=>TO_DATE('2019-02-25', 'YYYY-MM-DD'),
w_fechabaja=>TO_DATE('2021-01-20','YYYY-MM-DD'),w_hashcontraseña=>'Hola12345',w_saltcontraseña=>'Hola12345',w_categoria=>'COCINERO');
END;

--Insertar mesas

execute add_mesa(w_tipo_mesa=>'INTERIOR',w_capacidad=>4,w_dni_empleado1=>'11345678A');
execute add_mesa(w_tipo_mesa=>'INTERIOR',w_capacidad=>4,w_dni_empleado1=>'11345678A');
execute add_mesa(w_tipo_mesa=>'INTERIOR',w_capacidad=>6,w_dni_empleado1=>'11345678A');
execute add_mesa(w_tipo_mesa=>'INTERIOR',w_capacidad=>8,w_dni_empleado1=>'11345678A');
execute add_mesa(w_tipo_mesa=>'INTERIOR',w_capacidad=>6,w_dni_empleado1=>'11345678A');
execute add_mesa(w_tipo_mesa=>'EXTERIOR',w_capacidad=>4,w_dni_empleado1=>'12345678A');
execute add_mesa(w_tipo_mesa=>'EXTERIOR',w_capacidad=>4,w_dni_empleado1=>'12345678A');
execute add_mesa(w_tipo_mesa=>'EXTERIOR',w_capacidad=>6,w_dni_empleado1=>'12345678A');
execute add_mesa(w_tipo_mesa=>'EXTERIOR',w_capacidad=>4,w_dni_empleado1=>'12345678A');
execute add_mesa(w_tipo_mesa=>'EXTERIOR',w_capacidad=>4,w_dni_empleado1=>'12345678A');

--Insertar reservas

BEGIN
add_reserva(w_horaentrada_reserva=> TO_DATE('2020-06-24 16:00','YYYY-MM-DD HH24:MI'),w_horasalida_reserva=>TO_DATE('2020-06-24 17:00','YYYY-MM-DD HH24:MI'),w_id_cliente1=>41,w_id_mesa1=>22);
END;

BEGIN
add_reserva(w_horaentrada_reserva=> TO_DATE('2020-06-24 16:00','YYYY-MM-DD
HH24:MI'),w_horasalida_reserva=>TO_DATE('2020-06-24 17:00','YYYY-MM-DD HH24:MI'),
w_id_cliente1=>42,w_id_mesa1=>23);
END;

BEGIN
add_reserva(w_horaentrada_reserva=> TO_DATE('2020-06-24 14:00','YYYY-MM-DD
HH24:MI'),w_horasalida_reserva=>TO_DATE('2020-06-24 15:00','YYYY-MM-DD HH24:MI'),
w_id_cliente1=>44,w_id_mesa1=>24);
END;

BEGIN
add_reserva(w_horaentrada_reserva=> TO_DATE('2020-05-27 14:00','YYYY-MM-DD
HH24:MI'),w_horasalida_reserva=>TO_DATE('2020-05-27 15:00','YYYY-MM-DD HH24:MI'),
w_id_cliente1=>45,w_id_mesa1=>27);
END;


--Insertar empleados
execute add_pedido(w_id_mesa2=>21);

execute add_pedido(w_id_mesa2=>22);
execute add_pedido(w_id_mesa2=>27);

execute add_lineapedido(w_id_pedido1=>26,w_nombre_producto2=>'Natillas',w_cantidad_pedido=>2);
execute add_lineapedido(w_id_pedido1=>26,w_nombre_producto2=>'Merluza',w_cantidad_pedido=>2);
execute add_lineapedido(w_id_pedido1=>26,w_nombre_producto2=>'Filetes de pollo',w_cantidad_pedido=>2);
