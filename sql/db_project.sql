create database db_project;
use db_project;
#Customer table
CREATE TABLE IF NOT EXISTS `Customer` (
  `email` VARCHAR(50) NOT NULL,
  `f_name` VARCHAR(50) NOT NULL,
  `m_initial` VARCHAR(1) NULL DEFAULT NULL,
  `l_name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`email`));

#Employee table
CREATE TABLE IF NOT EXISTS `Employee` (
  `emp_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `f_name` VARCHAR(50) NOT NULL,
  `m_initial` VARCHAR(1) NULL DEFAULT NULL,
  `l_name` VARCHAR(50) NOT NULL,
  `passcode` VARCHAR(25),
  `salary` INT UNSIGNED NOT NULL DEFAULT 35000,
  PRIMARY KEY (`emp_id`));

#Cashier table
CREATE TABLE IF NOT EXISTS `Cashier` (
  `cash_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`cash_id`),
  CONSTRAINT `cash_id_fk`
    FOREIGN KEY (`cash_id`)
    REFERENCES `Employee` (`emp_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

#Manager table
CREATE TABLE IF NOT EXISTS `Manager` (
  `mgr_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`mgr_id`),
  CONSTRAINT `mgr_id_fk`
    FOREIGN KEY (`mgr_id`)
    REFERENCES `Employee` (`emp_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

#Supplier table
CREATE TABLE IF NOT EXISTS `Supplier` (
  `sup_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`sup_id`));

#Items table
CREATE TABLE IF NOT EXISTS `Items` (
  `item_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `stock` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`item_id`));

#Shipment table
CREATE TABLE IF NOT EXISTS `Shipment` (
  `ship_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `mgr_id` INT UNSIGNED NULL,
  `sup_id` INT UNSIGNED NULL,
  `date_placed` DATE NOT NULL,
  `status` VARCHAR(50) NOT NULL DEFAULT 'In Progress',
  PRIMARY KEY (`ship_id`),
  CONSTRAINT `ship_mgr_id_fk`
    FOREIGN KEY (`mgr_id`)
    REFERENCES `Manager` (`mgr_id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `ship_sup_id_fk`
    FOREIGN KEY (`sup_id`)
    REFERENCES `Supplier` (`sup_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE);

#Shipment_Items table
CREATE TABLE IF NOT EXISTS `Shipment_Items` (
  `ship_id` INT UNSIGNED NOT NULL,
  `item_id` INT UNSIGNED NOT NULL,
  `quantity` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`ship_id`, `item_id`),
  CONSTRAINT `ship_item_id_fk`
    FOREIGN KEY (`item_id`)
    REFERENCES `Items` (`item_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `ship_id_fk`
    FOREIGN KEY (`ship_id`)
    REFERENCES `Shipment` (`ship_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE);

#Transaction table
CREATE TABLE IF NOT EXISTS `Transaction` (
  `tran_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_email` VARCHAR(50) NULL DEFAULT NULL,
  `cash_id` INT UNSIGNED NULL,
  `date` DATE NOT NULL,
  PRIMARY KEY (`tran_id`),
  CONSTRAINT `tran_cust_email_fk`
    FOREIGN KEY (`customer_email`)
    REFERENCES `Customer` (`email`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `tran_cash_id_fk`
    FOREIGN KEY (`cash_id`)
    REFERENCES `Cashier` (`cash_id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE);

#Transaction_Items table
CREATE TABLE IF NOT EXISTS `Transaction_Items` (
  `tran_id` INT UNSIGNED NOT NULL,
  `item_id` INT UNSIGNED NOT NULL,
  `quantity` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`tran_id`, `item_id`),
  CONSTRAINT `tran_id_fk`
    FOREIGN KEY (`tran_id`)
    REFERENCES `Transaction` (`tran_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `tran_item_id_fk`
    FOREIGN KEY (`item_id`)
    REFERENCES `Items` (`item_id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE);
    
    #Insert Customer data
INSERT INTO `Customer`
VALUES
	ROW('ttt200006@utdallas.edu','Tony','T','Tran'),
	ROW('johnsmith@gmail.com','John','F','Smith'),
	ROW('bobmcgee@gmail.com','Bob','P','McGee'),
	ROW('emilymiller@gmail.com','Emily','J','Miller'),
	ROW('lilywilliams@gmail.com','Lily','S','Williams'),
	ROW('lalaland@gmail.com','Ahmed','H','mohammed'),
	ROW('tafison@gmail.com','Tafiso','N','Ahmed'),
	ROW('Zaisayed1@gmail.com','Zainab' ,'M','Sayed'),
	ROW('Kamala04@gmail.com','Kamal','B','Sana'),
	ROW('JBrown@yahoo.com','Jason',NULL,'Brown'),
	ROW('CatLady12@gmail.com','Amelia','M','Jones'),
	ROW('jacksoncharles76@aol.com','Charles','P','Jackson'),
	ROW('janedoe@outlook.com','Jane' ,'L','Doe'),
	ROW('waffleman000@gmail.com','Henry','B','Garcia');

#Insert Employee data
INSERT INTO `Employee`
VALUES
	ROW(1,'Jason','T','Brown'),
	ROW(2,'Aaron','M','Nguyen'),
	ROW(3,'Ben','E','King'),
	ROW(4,'Luna','R','Davis');
    
#Insert Cashier data
INSERT INTO `Cashier`
VALUES
	ROW(2),
    ROW(3);
    
#Insert Manager data
INSERT INTO `Manager`
VALUES
	ROW(1),
    ROW(4);

#Insert Supplier data
INSERT INTO `Supplier`
VALUES
	ROW(1,'Organic Fruit Co.'),
	ROW(2,'General Grocers');

#Insert Items data
INSERT INTO `Items`
VALUES
	ROW(1,'Banana',0),
	ROW(2,'Apple',0),
	ROW(3,'Chicken Breast',0),
	ROW(4,'Bread',0),
	ROW(5,'Milk',0),
	ROW(6,'Eggs',0),
	ROW(7,'Potato',0),
	ROW(8,'Cheese',0),
	ROW(9,'Rice',0),
	ROW(10,'Butter',0),
	ROW(11,'Chicken',0),
	ROW(12,'Tomato',0),
	ROW(13,'Lettuce',0),
	ROW(14,'Orange',0),
	ROW(15,'Carrot',0),
	ROW(16,'Onion',0),
	ROW(17,'Watermelon',0),
	ROW(18,'Pasta',0),
	ROW(19,'Salmon',0),
	ROW(20,'Avocado',0),
	ROW(21,'Broccoli',0),
	ROW(22,'Potato Chips',0),
	ROW(23,'Water Bottle Pack',0),
	ROW(24,'Cola',0),
	ROW(25,'Beef',0),
	ROW(26,'Beans',0),
	ROW(27,'Ice Cream',0),
	ROW(28,'Grapes',0),
	ROW(29,'Mango',0),
	ROW(30,'Canned Tuna',0),
	ROW(31,'Ketchup',0),
	ROW(32,'Mustard',0),
	ROW(33,'BBQ Sauce',0),
	ROW(34,'Peanut Butter',0),
	ROW(35,'Jelly',0),
	ROW(36,'Hershey Chocolate Bar',0),
	ROW(37,'Tropicana Orange Juice',0),
	ROW(38,'Wine',0),
	ROW(39,'Dole Apple Juice',0),
	ROW(40,'Oatmeal',0),
	ROW(41,'Chocolate Cake',0),
	ROW(42,'Organic Mushrooms',0),
	ROW(43,'Frozen Pizza',0),
	ROW(44,'Frozen Shrimp',0),
	ROW(45,'Cream Cheese',0),
	ROW(46,'Croissants',0),
	ROW(47,'Greek Yogurt',0),
	ROW(48,'All Purpose Flour',0),
	ROW(49,'Pancake Mix',0),
	ROW(50,'Maple Syrup',0);

#Insert Shipment data
INSERT INTO `Shipment`
VALUES
	ROW(1,1,1,'2024-01-01','In Progress'),
	ROW(2,4,2,'2024-01-05','In Progress');
    
#Insert Shipment_Items data
INSERT INTO `Shipment_Items`
VALUES
	ROW(1,1,200),
	ROW(1,2,500),
	ROW(1,14,300),
	ROW(1,17,120),
	ROW(1,28,400),
	ROW(1,29,240),
	ROW(2,48,300),
	ROW(2,16,125),
	ROW(2,3,150),
	ROW(2,5,200),
	ROW(2,26,150),
	ROW(2,19,175),
	ROW(2,25,300),
	ROW(2,20,200);

#Insert Transaction data
INSERT INTO `Transaction`
VALUES
	ROW(1,'ttt200006@utdallas.edu',2,'2024-04-04'),
	ROW(2,'johnsmith@gmail.com',2,'2024-04-03'),
	ROW(3,'bobmcgee@gmail.com',2,'2024-04-02'),
	ROW(4,'emilymiller@gmail.com',2,'2024-04-01'),
	ROW(5,'lilywilliams@gmail.com',2,'2024-03-31'),
	ROW(6,NULL,3,'2024-03-30'),
	ROW(7,'jacksoncharles76@aol.com',2,'2024-03-29'),
	ROW(8,'JBrown@yahoo.com',3,'2024-03-28'),
	ROW(9,'waffleman000@gmail.com',3,'2024-03-27'),
	ROW(10,'janedoe@outlook.com',2,'2024-03-26');

#Insert Transaction_Items data
INSERT INTO `Transaction_Items`
VALUES
	ROW(1,1,4),
	ROW(1,2,5),
	ROW(1,29,5),
	ROW(2,34,1),
	ROW(2,35,1),
	ROW(3,31,1),
	ROW(3,32,1),
	ROW(3,33,1),
	ROW(4,27,1),
	ROW(5,5,1),
	ROW(5,6,12),
	ROW(6,2,5),
	ROW(6,29,4),
	ROW(6,5,1),
	ROW(7,17,2),
	ROW(8,41,1),
	ROW(8,43,3),
	ROW(9,22,2),
	ROW(9,23,2),
	ROW(9,3,4),
	ROW(9,2,6),
	ROW(10,30,10),
	ROW(10,4,1),
	ROW(10,34,1);