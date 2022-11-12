ALTER TABLE Author AUTO_INCREMENT = 1;
ALTER TABLE Review AUTO_INCREMENT = 1;
ALTER TABLE Publisher AUTO_INCREMENT = 1;
ALTER TABLE PurchaseOf AUTO_INCREMENT = 1;

INSERT INTO 
    Author(FName, LName)
VALUES
    ("Ernest", "Hemingway"),
    ("Kurt", "Vonnegut"),
    ("Oscar", "Wilde");

INSERT INTO 
    Book
VALUES
    ("A123", 15.99, "Fiction", "The Old Man and the Sea", 1),
    ("B123", 16.99, "Fiction", "Cat's Cradle", 2),
    ("C123", 17.99, "Fiction", " The Picture of Dorian Gray", 3);
    
INSERT INTO
	Review(ReviewText, ISBN)
VALUES
	("Good book innit", "A123"),
    ("This is a good book too I guess", "B123"),
    ("I had to read this in AP Lit and it scarred me", "C123");

INSERT INTO 
    Publisher(PublisherName)
VALUES
    ("PublisherOne"),
    ("PublisherTwo"),
    ("PublisherThree");

INSERT INTO 
    PublishedBy
VALUES
    (2000, "1", "A123"),
    (2001, "2", "B123"),
    (2002, "3", "C123");

INSERT INTO 
    CreditCard
VALUES
    ("ABC123", "Amex", '2026-03-03'),
    ("EFG456", "Chase", '2027-04-04'),
    ("HIJ789", "Ally", '2028-05-05');

INSERT INTO 
    Customer
VALUES
    ("JohnCustomer", "LegitPIN1", "111 Street Boulevard", "Detroit", "Michigan", "27203", "John", "Customer", "ABC123"),
    ("JaneCustomer", "LegitPIN2", "112 Street Boulevard", "Atlanta", "Georgia", "67841", "Jane", "Customer", "EFG456"),
    ("BookBuyer123", "LegitPIN3", "113 Street Boulevard", "New York City", "New York", "92124", "Joe", "Smith", "HIJ789");

INSERT INTO 
    PurchaseOf(Username)
VALUES
    ("JohnCustomer"),
    ("JaneCustomer"),
    ("BookBuyer123");

INSERT INTO 
    InPurchase
VALUES
    (1, "A123", 1),
    (1, "B123", 2),
    (2, "C123", 3);

INSERT INTO 
    Admin
VALUES
    ("SuperAdmin", "PIN123"),
    ("OmegaAdmin", "PIN456"),
    ("GigaAdmin", "PIN789");