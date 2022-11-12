Todo:
- eliminar no necesario de docker
- probar aplicación desde otro sistema para comprobar que arranca y cumple especificaciones
- revisar uso del .env/.env.local
- revisar makefile
- swager doc
- clases finales
- es necesario el encolamiento de messenter?
- uso interfaces, no debería inyectar ProductRepository sino una interfac genérica
- ojo check resultados api (sin el data)
- soltar excepcion en priceResutl?
- limpiar make
- la interface generica de Repo, debería tener al menos 3 funciones, save, find y ?
- test priceCalculator
- se pueden hacer test mejores sobre el caculador, teniendo en cuenta precios menores que zero
- pasar el filtro para PSR


Mejoras
Podría haber hecho un tratamiento de las excepciones
Separación en el handler del listado, de la capa de la vista
Hacer el cálculo de precio simplificaría el tratamiento posterior en listados, no tiene sentido pero entiendo que no se busca eso en la prueba
esto permitiría hacer un test más limpio del hander, ya que no sería necesario inyectar el priceCalculator
generar una bd de tests, no he creído que el contexto de la prueba fuera necesario
## Table of Contents
1. [General Info](#general-info)
2. [Technologies](#technologies)
3. [Installation](#installation)
4. [Collaboration](#collaboration)
5. [FAQs](#faqs)
### General Info
***
Code test that solves the problem proposed by Company as part of the selection process for the position of Backend Developer .
### Screenshot
![Image text](https://www.united-internet.de/fileadmin/user_upload/Brands/Downloads/Logo_IONOS_by.jpg)
## Technologies
***
A list of technologies used within the project:
* [Technology name](https://example.com): Version 12.3
* [Technology name](https://example.com): Version 2.34
* [Library name](https://example.com): Version 1234
## Installation
***
A little intro about the installation.
```
$ git clone https://example.com
$ cd ../path/to/the/file
$ npm install
$ npm start
```
Side information: To use the application in a special environment use ```lorem ipsum``` to start
## Collaboration
***
Give instructions on how to collaborate with your project.
> Maybe you want to write a quote in this part.
> Should it encompass several lines?
> This is how you do it.
## FAQs
***
A list of frequently asked questions
1. **This is a question in bold**
   Answer to the first question with _italic words_.
2. __Second question in bold__
   To answer this question, we use an unordered list:
* First point
* Second Point
* Third point
3. **Third question in bold**
   Answer to the third question with *italic words*.
4. **Fourth question in bold**
   | Headline 1 in the tablehead | Headline 2 in the tablehead | Headline 3 in the tablehead |
   |:--------------|:-------------:|--------------:|
   | text-align left | text-align center | text-align right |