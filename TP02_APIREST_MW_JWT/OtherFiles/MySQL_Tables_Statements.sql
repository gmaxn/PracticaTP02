CREATE DATABASE el_restaurante CHARACTER SET UTF8 collate utf8_spanish_ci;


CREATE TABLE Orders ( 
OrderCode varchar(255) NOT NULL,
CustomerCode varchar(255) NOT NULL,
OrderDate datetime,
DeliveryTime datetime,
OrderStatus varchar(255),
PRIMARY KEY (OrderCode)
);


INSERT INTO Orders
VALUES
('G5DFD','HX67F','2019-6-1 18:14:55', '2019-6-1 19:00:00', 'in progress')




CREATE TABLE Summary (
OrderCode varchar(255) NOT NULL,
ArticleCode varchar(255) NOT NULL,
Quantity int,
Status varchar(255)
);

INSERT INTO Summary
VALUES
('G5DFD','I2K2H',4,'in progress')
('G5DFD','ZO2YR',3,'in progress')
('G5DFD','HNC5H',4,'in progress')
('G5DFD','4RY83',1,'in progress')
('G5DFD','6RNEL',1,'ready')
('G5DFD','A78TW',1,'ready')


CREATE TABLE Article ( 
Code varchar(255) NOT NULL,
Section varchar(255),
Description varchar(255),
Price decimal(7,2),
Stock int,
PRIMARY KEY (Code)
);


INSERT INTO Article
VALUES ('HNC5H','Empanadas','Jamon y Queso',34, 10),
('ZO2YR','Empanadas','Queso y Cebolla',34, 10),
('I2K2H','Empanadas','Pollo',34, 10),
('4RY83','Empanadas','Carne Picante',34, 10),
('H1CIA','Pizzas','Napolitana',250, 10),
('K0O1I','Pizzas','Jamon y Morrones',250, 10),
('1KAJA','Pizzas','Muzzarella',210, 10),
('6RNEL','Bebidas','Coca-Cola',85, 00),
('C8VLA','Bebidas','Schweppes',85, 00),
('Z84NP','Bodega','Octava Bassa Malbec',765, 10),
('U2LSU','Bodega','Alandes Paradoux Blend',1286, 10),
('VVWF4','Cervezas','Quilmes',85, 10),
('A78TW','Cervezas','Heineken',95, 10),
('25YZ0','Cervezas','Budweiser',95, 10)


CREATE TABLE Persons ( 
PersonID int NOT NULL AUTO_INCREMENT,
FirstName varchar(255),
LastName varchar(255) NOT NULL,
Email varchar(255) NOT NULL,
User varchar(255) NOT NULL,
Pass varchar(255) NOT NULL,
Rol varchar(255) NOT NULL
PRIMARY KEY (PersonID)
);


INSERT INTO table_name (FirstName, LastName, Email, User, Pass, Rol)
VALUES
('Marlena','Harrington','mharrington3@1und1.de','mharrington3','cbYlF5qQ12K','administrador')
('Benson','Coldham','bcoldham6@cocolog-nifty.com','bcoldham6','Uimu3q4kj9','mozo')
('Julia','Slograve','jslograve1@facebook.com','jslograve1','AA4EwID','bartender_tragos')
('Armand','Frend','afrend0@1688.com','afrend0','95J5HYyYquxX','bartender_cervecero')
('Reine','Wedon','rwedon2@taobao.com','rwedon2','DrYeEo','cliente')
('Analise','Grelik','agrelik8@liveinternet.ru','agrelik8','X737JjEDJL76','cliente')
('Constancia','Tilzey','ctilzey7@unc.edu','ctilzey7','j0HsnajMtfo','cliente')
('Cordula','Antrim','cantrimb@blinklist.com','cantrimb','ueZi42ZQxSb','cocinero_gral')
('Lief','Bendig','lbendigc@linkedin.com','lbendigc','S04EKOn1','cocinero_gral')
('Ashlin','Paddon','apaddond@addtoany.com','apaddond','4JurXXR','cocinero_candy')


