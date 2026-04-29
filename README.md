# El Faro

Sitio web de periodico digital desarrollado en PHP para la Actividad Sumativa Unidad 03 - A del Instituto Profesional AIEP.

## Informacion del trabajo

- Institucion: Instituto Profesional AIEP (Educacion Online)
- Actividad: Sitio en PHP
- Unidad: 01 - A
- Semana de realizacion: 06
- Tipo de actividad: Grupal
- Estudiante: Ruth Barrera Toloza
- Proyecto: el-faro

## Descripcion general

Este proyecto representa la migracion de un periodico local al formato web. El sitio presenta portada, menu de navegacion y secciones de noticias para contenido general, deporte y negocios, incorporando recursos multimedia (video y audio) y renderizado dinamico con PHP.

## Objetivo academico

Aplicar PHP en la construccion de un sitio web, considerando estructura del documento, navegacion por secciones, patrones basicos de MVC y presentacion de contenido informativo.

## Requerimientos del instituto cubiertos en el sitio

1. Portada con titulo del periodico y logotipo.
2. Menu con las opciones Inicio, Deporte y Negocios.
3. Seccion de noticias generales con al menos 3 articulos.
4. Inclusion de un video y un audio dentro del sitio.
5. Seccion de Deporte con al menos 3 noticias.
6. Seccion de Negocios con al menos 3 noticias de negocios/emprendimientos.

## Estructura del proyecto

- el-faro/
	- index.php
	- README.md
	- assets/
		- css/
			- style.css
		- js/
			- site.js
		- media/
	- controllers/
		- ContactoController.php
		- HomeController.php
		- UsuarioController.php
	- models/
		- Articulo.php
		- Contacto.php
		- Usuario.php
	- views/
		- contacto.php
		- home.php
		- registro.php
		- resultado_contacto.php
		- resultado_registro.php
		- layout/
			- footer.php
			- header.php

## Formato esperado para los articulos

Cada articulo presenta:

- Titulo
- Categoria
- Texto descriptivo


## Vista del proyecto

Para revisar el sitio, ejecutar el proyecto con un servidor local (por ejemplo XAMPP) y abrir `http://localhost/el-faro-php/`.