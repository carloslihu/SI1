# sip
practicas de SI
pareja 15
1401_Gomez_Li.zip

# TOASK:
	apartado e)
		cuando dice de incorporar la tabla resultante de la busqueda a la pagina principal de bienvenida, como lo mostramos?
		De imprimir los datos de la tabla, no entendemos que interes puede tener el usuario en ver el numero de ventas. Ademas, tendría sentido que
		pudiera ir a la pagina asociada a ese producto al hacer click y por tanto la funcion getTopVentas deberia devolver, en la tabla, el id
		de la pelicula (dato necesario para el href)

	En la base de datos:
		1)	En la tabla customers se guardan las contraseñas sin md5. Respetar esto y no guardar nuevas contraseñas con md5? o actualizar la tabla para que todas las contraseñas esten
			en md5?

			¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡¡ATENCION!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				en actualiza.sql las contraseñas anteriores ya las he pasado a md5
				supongo que falta hacer que sean MD5 a partir de ahora al registrarse
			
		2)	En la tabla customers, que campo de los existentes representa el saldo de los usuarios?

# TODO:
	carrito (cuando hace login debo ver si existe ya carrito empezado y cargarlo en sesion)
	añadir y quitar pelis al carrito
	arreglar login

	actualizar diagrama ER
	a lo mejor quitar users repetidos

# CRITERIOS

Este es un conjunto de criterios que han sido consensuados para la corrección de la práctica 3. Estos criterios son orientativos y es potestad del profesor tanto asignar la puntuación que estime oportuna en cada apartado, como el establecer criterios propios respecto a lo que considera "imprescindible" en la entrega de la práctica.

[1pto]  Diagrama entidad relación
 [1,25p] Discusión del diseño de la BD y actualiza.sql
 [0,75p] Apartado b) modificar tablas con atributos multivaluados
 [0,75p] Apartado c) setPrice
 [0,75p] Apartado d) setOrderAmount
 [0,75p] Apartado e) getTopVentas
 [0,75p] Apartado f) getTopMonths
 [0,75p] Apartado g) updOrders
 [0,75p] Apartado h) updInventory
 [1pto]  Apartado i) Login
 [1,5p]  Apartado j) Carrito


