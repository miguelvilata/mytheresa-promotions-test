Todo:
- eliminar no necesario de docker
- probar aplicación desde otro sistema para comprobar que arranca y cumple especificaciones
- revisar uso del .env/.env.local
- revisar makefile
- swager doc
- clases finales
- es necesario el encolamiento de messenter?
- uso interfaces, no debería inyectar ProductRepository sino una interfac genérica
ok - ojo check resultados api (sin el data)
- soltar excepcion en priceResutl?
- limpiar make
- la interface generica de Repo, debería tener al menos 3 funciones, save, find y ?
ok - test priceCalculator
ok - se pueden hacer test mejores sobre el caculador, teniendo en cuenta precios menores que zero
- pasar el filtro para PSR
- instrucciones readme
- ojo revisar .env, no se deben meter en el repo las credenciales
- imagen del resultado alojada en github


Requisitos
- instalar make
- docker & docker-compose (link instalación)

Mejoras
Podría haber hecho un tratamiento de las excepciones
Separación en el handler del listado, de la capa de la vista
ok Hacer el cálculo de precio simplificaría el tratamiento posterior en listados, no tiene sentido pero entiendo que no se busca eso en la prueba
ok esto permitiría hacer un test más limpio del hander, ya que no sería necesario inyectar el priceCalculator
generar una bd de tests, no he creído que el contexto de la prueba fuera necesario


## Table of Contents
1. [General Info](#general-info)
2. [Technologies](#technologies)
3. [Prerequisites](#prerequisites)
4. [Installation](#Installation)
5. [Test](#Test)
6. [Observations](#Observations)
### General Info
***
Working code to pass the technical test "mytheresa Promotions Test" proposed by Capitole Consulting for the position of Backend Developer .
### Screenshot
![Image text](https://www.united-internet.de/fileadmin/user_upload/Brands/Downloads/Logo_IONOS_by.jpg)

## Technologies
***
I used symfony to resolve the test, but I considered using golang because it has less bootstrap and a more easy installation:
* [https://symfony.com/](https://symfony.com/): Symfony


## Prerequisites
***
The project will heard for request at port 80, please check no other software is using this port before run it.

The application is encapsulated using docker virtualization and uses Make to automate test launch and installation.

Here you have some links to install these commands in Ubuntu. 

Instructions to install docker & docker-compose:
* [docker && docker-compose](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-22-04)

Make: 
* [Make](#): sudo apt-get -y install make

## Installation
***
The installation will do:
* clone the repo at local
* start containers
* initialize de project installing vendors, creating database and executing migrations.

To install execute:
```
$ git clone git@github.com:miguelvilata/mytheresa-promotions-test.git && cd mytheresa-promotions-test && make init
```

After that the project should be running in your localhost.

Then you can try:

Get all products
```
$ curl --location --request GET 'localhost/api/products'
```

Get products from boots category
```
$ curl --location --request GET 'localhost/api/products?category=boots'
```

Get product from boots category with price < 71001
```
$ curl --location --request GET 'localhost/api/products?category=boots&price_lt=71001'
```

## Test
***

```
$ make test
```

## Observations
***

* I didn't create a separate bd for testing I think it does not add value in the context of the proof.
* And improvement to the software will saving producto with its final price and recalculate when necessary. This could help to simplify
list processes not needing inject PriceCalculator and allowing to a better separation for the view model.

This:
```
        foreach ($products as $product) {
            $priceResult = $this->priceCalculator->calculate($product);
            $productResult = (new ProductView($product, $priceResult))->render();
            $result[] = $productResult;
        }

        return $result;
```

Becomes this:

```
        return $this->listProductViewBuilder->build($products);
```

 


