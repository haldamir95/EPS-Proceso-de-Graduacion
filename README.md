# Plantilla-Symfony-Portal

Código que contiene el manejo básico de sesión, conexión a Base de Datos e integra la plantilla de Ubold que contiene todos los componentes visuales necesarios para un sitio web. 

Incluye comunicacion dinamica con el SSO.

## Primeros Pasos

Estas instrucciones te daran acceso a una copia del proyecto para correrlo en tu maquina local.

### Prerrequisitos

Debes instalar lo siguiente en tu maquina local:

* Vagrant
* Composer
* PHP 7.2
* Git

### Puesta a punto

Es necesario realizar modificaciones para colocar el nombre especifico del proyecto sobre los siguientes archivos:

* Vagrantfile
* plantilla_portal.conf

Variables de sesión asignadas por el Dashboard Académico:
* carnet
* nombre-estudiante
* apellido-estudiante
* carrera