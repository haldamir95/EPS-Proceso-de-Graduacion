# Plantilla-Symfony-Portal

Código que contiene el manejo básico de sesión, conexión a Base de Datos e integra la plantilla de Ubold que contiene todos los componentes visuales necesarios para un sitio web. 

Incluye comunicacion dinamica con el SSO.

## Primeros Pasos

Estas instrucciones te daran acceso a una copia del proyecto para correrlo en tu maquina local.

### Prerrequisitos

Debes instalar lo siguiente en tu maquina local:

* Vagrant
* Composer
* Symfony 4.1
* PHP 7.2
* Git

### CORRER DE FORMA LOCAL

* En la carpeta 'Portal Ingenieria' escribir el comando "Symfony server:start"


### CORRER CON VAGRANT

* En la / donde esta el Vagrantfile escribir el comando vagrant up
* $vagrant ssh
* $ip address
* Buscar la IP y logear


### Puesta a punto

Es necesario realizar modificaciones para colocar el nombre especifico del proyecto sobre los siguientes archivos:

* Vagrantfile
* plantilla_portal.conf

Variables de sesión asignadas por el Dashboard Académico:
* carnet
* nombre-estudiante
* apellido-estudiante
* carrera
