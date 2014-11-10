-- PHP 5.4.30 (cli)
-- XAMPP for OS X 1.8.2 & 1.8.3
-- PHPMYADMIN Version information: 4.2.7.1
-- Apache/2.4.10 (Unix) OpenSSL/1.0.1i PHP/5.5.15 mod_perl/2.0.8-dev Perl/v5.16.3
-- Database client version: libmysql - mysqlnd 5.0.11-dev - 20120503 - $Id: 
-- Server: Localhost via UNIX socket
-- Server type: MySQL
-- Server version: 5.6.20 - Source distribution
-- Protocol version: 10
-- User: root@localhost
----------------------------------------------------------

--
-- Table Structure for Problem set 3 Q1 Sandwich
--
CREATE TABLE IF NOT EXISTS 'customer'(
	'phone' char(10) PRIMARY KEY,
	'building_num' int(5) default NULL, 
	'street' varchar(20) default NULL,
	'apartment' varchar(20) default NULL
);
---------------------------------------------------
CREATE TABLE IF NOT EXISTS 'sandwich'(
	'sname' varchar(20) PRIMARY KEY,
	'description' varchar(100) default NULL

);

INSERT INTO 'sandwich' ('sname', 'description') VALUES 
('peperoni','delicious sandwich in New York'),
('turkey','delicious turkey thanksgiving must have one'),
('turkey sausage', 'delicious turkey in New York');
--------------------------------------------------------------
CREATE TABLE IF NOT EXISTS 'menu'(
	'sname' varchar(20),
	'size' varchar(20),
	'price' decimal(4,2) NOT NULL,
	PRIMARY KEY ('sname','size'),
	FOREIGN KEY ('sname') REFERENCES 'sandwich'('sname')
);
INSERT INTO 'menu' ('sname','size','price') VALUES
('peperoni','small',1),
('peperoni','mediam',2),
('turkey','mediam',2),
('turkey','large',3),
('turkey sausage','small',2),
('turkey sausage','large',4);
------------------------------------------------------------
CREATE TABLE IF NOT EXISTS 'orders'(
	'phone' char(10),
	'sname' varchar(20),
	'size' varchar(20),
	'o_time' datetime,
	'quantity' int(5) NOT NULL,
	'status' varchar(10) NOT NULL,
	PRIMARY KEY ('phone','sname','size','o_time'),
	FOREIGN KEY ('phone') REFERENCES 'customer'('phone'),
	FOREIGN KEY ('sname','size') REFERENCES 'menu'('sname','size')

);
