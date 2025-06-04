/*

Enter custom T-SQL here that would run after SQL Server has started up. 

*/

CREATE DATABASE TestDB;
GO

USE TestDB;
CREATE TABLE Inventory
(
    id INT,
    name NVARCHAR (50),
    quantity INT
);

GO

INSERT INTO Inventory
VALUES (1, 'banana', 150);

INSERT INTO Inventory
VALUES (2, 'orange', 354);

GO
