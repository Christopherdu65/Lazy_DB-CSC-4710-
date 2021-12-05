# Lazy_DB-CSC-4710
This is a project developed for CSC 4710 at gsu
## ER Diagram
We decided to mock a chain of online stores that sells a variety of products notably in the food industry. 
We have a total of 10 stores each in different stores each in different cities around the world. Each product is identified by its upc, and different stores have different inventory and price for a specefic products. Some products are also part of a promotion, so if bought, consumner will see a reduction of price when they decide to checkout. 

phpMyAdmin is used as a web interface for handling the database administration and queries. By this, backend acess to lazy_DN is made possible for fetching, updating and analyzing data on the database sever. Our consumers need to register with an account before being able to order anything in our store. After successful registration. A consumer can order many products under one specific order and get added to order_item list.

https://github.com/Christopherdu65/Lazy_DB-CSC-4710-/blob/main/E-R%20Diagram.png

## SQL DDL

{Insert create table}
{Insert insert statements}

## Data Generation

Data was generated using [filldb](http://filldb.info/dummy). FillDb is a free web tool for generating database data. Our design schema was passed in as input with customized entries to generate data for our tables - with foreign and primary keys identified - in order to fit in with our database model. We updated some of the tables columns value for more realistic data after first generation with data from [mockaroo](https://www.mockaroo.com/) with the ***update.php*** script
all run on a sql server. All the generated data have been commited here as excel files.


## Queries Run

## Video Presentation
