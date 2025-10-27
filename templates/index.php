<?php require_once __DIR__ . '/../src/entity/imagen.class.php';
require_once __DIR__ . '/../src/entity/Asociado.class.php';

$imagenesIndex = [new Imagen ('1.jpg','descripción imagen 1',1,456,610,130),
                    new Imagen ('2.jpg','descripción imagen 2',1, 345, 110, 98),
                    new Imagen ('3.jpg','descripción imagen 3',1,6786,2344,1223),
                    new Imagen ('4.jpg','descripción imagen 4',1,9354,2365,950),
                    new Imagen ('5.jpg','descripción imagen 5',2,174,137,11),
                    new Imagen ('6.jpg','descripción imagen 6',2,9864,1122,123),
                    new Imagen ('7.jpg','descripción imagen 7',2,9764,9274,36),
                    new Imagen ('8.jpg','descripción imagen 8',2,361,123,9823),
                    new Imagen ('9.jpg','descripción imagen 9',3,234,2342,1236),
                    new Imagen ('10.jpg','descripción imagen 10',3,123,346,83),
                    new Imagen ('11.jpg','descripción imagen 11',3,174,123,136),
                    new Imagen ('12.jpg','descripción imagen 12',3,854,234,1865),
    ];

$asociadosIndex = [new Asociado('First partner name', 'log1.jpg', "Partner number one"),
                    new Asociado('Second partner name', 'log2.jpg', "Partner number two"),
                    new Asociado('Third partner name', 'log3.jpg', "Partner number three"),
                    new Asociado('Fourth partner name', 'log1.jpg', "Partner number four"),
                    new Asociado('Fifth partner name', 'log2.jpg', "Partner number five"),
                    new Asociado('Sixth partner name', 'log3.jpg', "Partner number six")];
require_once __DIR__ . '/views/index.view.php';
