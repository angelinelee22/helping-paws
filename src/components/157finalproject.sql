CREATE TABLE Breed (
	BreedID		INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	FurType		VARCHAR(16),
	BreedName 	VARCHAR(32),
	PRIMARY KEY (BreedID)
);
INSERT INTO Breed (FurType, BreedName) VALUES ("Fur", "Golden Retriever");
INSERT INTO Breed (FurType, BreedName) VALUES ("Hair", "Morkie Poo");
INSERT INTO Breed (FurType, BreedName) VALUES ("Hair", "Sheepadoodle");

CREATE TABLE Employees (
	EmployeeID	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	FirstName	VARCHAR(32),
	LastName 	VARCHAR(32),
    Username VARCHAR(64),
    Password VARCHAR(64),
	Age		INTEGER,
	PhoneNumber	VARCHAR(32),
	EmailAddress	VARCHAR(64),
	PRIMARY KEY (EmployeeID)
);

INSERT INTO Employees (FirstName, LastName, Username, Password, Age, PhoneNumber, EmailAddress) VALUES ("Angeline", "Lee", "Angeline5Foot7", "IAmActually5Foot3", 21, "220-304-3840", "angeline.lee@yahoo.com");
INSERT INTO Employees (FirstName, LastName, Username, Password, Age, PhoneNumber, EmailAddress) VALUES ("Risha", "Ray", "DocRay", "IAmBestVet1010", 37, "220-102-3340", "doctor.risharay@gmail.com");
INSERT INTO Employees (FirstName, LastName, Username, Password, Age, PhoneNumber, EmailAddress) VALUES ("Chris", "Tom", "SomeInternChris", "WishIWorkedAtCostco1", 18, "220-306-3800", "chris.tom@comcast.net");

CREATE TABLE Employment (
	EmploymentID 		INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	EmployeeID			INTEGER,
	Occupation	  		VARCHAR(64),
	Pay 		  		DECIMAL,
	TimeWorking	  		INTEGER,
	EmploymentStatus  	VARCHAR(32),
    PRIMARY KEY (EmploymentID),
	FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID)
);
INSERT INTO Employment (EmployeeID, Occupation, Pay, TimeWorking, EmploymentStatus) VALUES (1, "Manager", 30.00, 500, "Active");
INSERT INTO Employment (EmployeeID, Occupation, Pay, TimeWorking, EmploymentStatus) VALUES (2, "Veterinarian", 50.00, 800, "Active");
INSERT INTO Employment (EmployeeID, Occupation, Pay, TimeWorking, EmploymentStatus) VALUES (3, "Cashier", 17.0, 20, "Active");

CREATE TABLE Customer (
	CustomerID	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	Username 	VARCHAR(64) NOT NULL,
    Password 	VARCHAR(64) NOT NULL,
	FirstName	VARCHAR(32),
	LastName 	VARCHAR(32),
	Age			INTEGER,
	Email		VARCHAR(64) NOT NULL,
	PhoneNumber	VARCHAR(32),
	PRIMARY KEY (CustomerID)
);

INSERT INTO Customer (Username, Password, FirstName, LastName, Age, Email, PhoneNumber) VALUES ("CrazyCat11", "HatePetsLol01", "Conrad", "Victor", 37, "ConVicto@gmail.com", "551-578-1100");
INSERT INTO Customer (Username, Password, FirstName, LastName, Age, Email, PhoneNumber) VALUES ("DanaPeters", "ImSoExcited00", "Dana", "Peters", 50, "ILoveDogs@gmail.com", "525-908-2910");
INSERT INTO Customer (Username, Password, FirstName, LastName, Age, Email, PhoneNumber) VALUES ("GetItJeff", "JeffSretam1", "Jeffrey", "Masters", 37, "JeffMasters@yahoo.com", "201-934-9483");

CREATE TABLE Dog (
	DogID		INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    BreedID 	INTEGER,
	Name		VARCHAR(32),
	Image 		varchar(256),
	Personality	VARCHAR(64),
	Color		VARCHAR(32),
	Weight		DECIMAL,
	DateArrived	DATE,
	DateLeft	VARCHAR(128),
	Owner		VARCHAR(64),
	AssignedVet	VARCHAR(64),
	Age			INTEGER,
	Trained		VARCHAR(32),
	Sex			VARCHAR(16),
	PRIMARY KEY (DogID),
	FOREIGN KEY (BreedID) REFERENCES Breed(BreedID)
);

INSERT INTO Dog (BreedID, Name, Image, Personality, Color, Weight, DateArrived, DateLeft, Owner, AssignedVet, Age, Trained, Sex) VALUES (1, "Daisy", "daisy.jpg", "Very polite and kind", "Brown/Blonde", 36.7, "2020-10-21", "2020-11-17", "Angeline Lee", "Dr. Matthew Klein", 12, "Trained in disability assistance", "Female");
INSERT INTO Dog (BreedID, Name, Image, Personality, Color, Weight, DateArrived, DateLeft, Owner, AssignedVet, Age, Trained, Sex) VALUES (2, "Scout", "scout.jpg", "Likes to bite as a show of love", "Pale White/Blonde", 25.5, "2019-11-02", "Has not been adopted", "Helping Paws", "Dr. Katie Veters", 10, "None", "Female");
INSERT INTO Dog (BreedID, Name, Image, Personality, Color, Weight, DateArrived, DateLeft, Owner, AssignedVet, Age, Trained, Sex) VALUES (3, "Teddy", "teddy.jpg", "Very timid but likes to bark a lot", "White ", 13.6, "2007-02-16", "2007-02-17", "Kramer Krimson", "Dr. Ronaldo Craster", 7, "Potty-Trained", "Male");

CREATE TABLE CriminalRecord (
	CriminalRecordID	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	CustomerID			INTEGER, 
	CriminalRecordName	VARCHAR(64),
	PRIMARY KEY (CriminalRecordID),
	FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)
);
INSERT INTO CriminalRecord (CustomerID, CriminalRecordName) VALUES (1, "Charged With Animal Abuse on December 7th");
INSERT INTO CriminalRecord (CustomerID, CriminalRecordName) VALUES (2, "NO PRIOR RECORD");
INSERT INTO CriminalRecord (CustomerID, CriminalRecordName) VALUES (3, "NO PRIOR RECORD");

CREATE TABLE PastHistory (
	HistoryID			INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	DogID				INTEGER,
	PastOrganization	VARCHAR(128),
	PastOwner 			VARCHAR(64),
	PRIMARY KEY (HistoryID),
	FOREIGN KEY (DogID) REFERENCES Dog(DogID)
);

INSERT INTO PastHistory (DogID, PastOrganization, PastOwner) VALUES (1, "San Jose Medical Center", "James Patterson");
INSERT INTO PastHistory (DogID, PastOrganization, PastOwner) VALUES (2, "FIRST TIME IN ADOPTION SYSTEM", "NONE");
INSERT INTO PastHistory (DogID, PastOrganization, PastOwner) VALUES (3, "San Diego PetSmart Center", "Key Anu Reeves");

CREATE TABLE MedicalHistory (
	MedicalHistoryID	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	DogID				INTEGER,
	NeuteredStatus		VARCHAR(16),
	PRIMARY KEY (MedicalHistoryID),
	FOREIGN KEY (DogID) REFERENCES Dog(DogID)
);

INSERT INTO MedicalHistory (DogID, NeuteredStatus) VALUES (1, "Neutered");
INSERT INTO MedicalHistory (DogID, NeuteredStatus) VALUES (2, "Spayed");
INSERT INTO MedicalHistory (DogID, NeuteredStatus) VALUES (3, "Neutered");

CREATE TABLE Vaccination (
	VaccinationID		INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	MedicalHistoryID 	INTEGER,
	VaccinationName		VARCHAR(256),
	PRIMARY KEY (VaccinationID),
	FOREIGN KEY (MedicalHistoryID) REFERENCES MedicalHistory(MedicalHistoryID)
);

INSERT INTO Vaccination (MedicalHistoryID, VaccinationName) VALUES (1, "Influenza on 03/04/2020");
INSERT INTO Vaccination (MedicalHistoryID, VaccinationName) VALUES (2, "WormBeGone on 07/09/2016");
INSERT INTO Vaccination (MedicalHistoryID, VaccinationName) VALUES (2, "Influenza on 07/09/2016");
INSERT INTO Vaccination (MedicalHistoryID, VaccinationName) VALUES (3, "None");

CREATE TABLE Ailment (
	AilmentID	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	AilmentName	VARCHAR(128),
	MedicalHistoryID INTEGER,
	PRIMARY KEY (AilmentID),
	FOREIGN KEY (MedicalHistoryID) REFERENCES MedicalHistory(MedicalHistoryID)
);
INSERT INTO Ailment (AilmentName, MedicalHistoryID) VALUES ("Dog Flu", 1);
INSERT INTO Ailment (AilmentName, MedicalHistoryID) VALUES ("TapeWorm", 2);
INSERT INTO Ailment (AilmentName, MedicalHistoryID) VALUES ("NONE", 3);

CREATE TABLE CustomerInterests (
	InterestID		INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    BreedID 		INTEGER,
	CustomerID		INTEGER,
	TimeCommitment	VARCHAR(256),
	PRIMARY KEY (InterestID),
	FOREIGN KEY (BreedID) REFERENCES Breed(BreedID)
);

INSERT INTO CustomerInterests (BreedID, CustomerID, TimeCommitment) VALUES (1, 1, "Not That Much Time");
INSERT INTO CustomerInterests (BreedID, CustomerID, TimeCommitment) VALUES (2, 2, "I have a job but right now it is work at home. I would say 17 hours a day.");
INSERT INTO CustomerInterests (BreedID, CustomerID, TimeCommitment) VALUES (3, 3, "24/7 but on occasion both me and my wife will leave the house");

CREATE TABLE CustomerBackground (
	BackgroundID	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
    CriminalRecordID INTEGER,
	CustomerID		INTEGER,
	Salary			DECIMAL,
	NumPeopleHousehold INTEGER,
	NumKids 		INTEGER,
	NumCurrPets		INTEGER,
	BUDGET			DECIMAL,
	PRIMARY KEY (BackgroundID),
	FOREIGN KEY (CriminalRecordID) REFERENCES CriminalRecord(CriminalRecordID),
	FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)

);

INSERT INTO CustomerBackground (CriminalRecordID, CustomerID, Salary, NumPeopleHousehold, NumKids, NumCurrPets, BUDGET) VALUES (1, 1, 0.0, 1, 0, 10, 20.0);
INSERT INTO CustomerBackground (CriminalRecordID, CustomerID, Salary, NumPeopleHousehold, NumKids, NumCurrPets, BUDGET) VALUES (2, 2, 67000.50, 4, 6, 2, 150.0);
INSERT INTO CustomerBackground (CriminalRecordID, CustomerID, Salary, NumPeopleHousehold, NumKids, NumCurrPets, BUDGET) VALUES (3, 3, 200000.00, 3, 1, 0, 600.0);

CREATE TABLE Address (
	AddressID	INTEGER NOT NULL AUTO_INCREMENT UNIQUE,
	CustomerID	INTEGER,
    Street 		VARCHAR(128),
	City		VARCHAR(32),
	State		VARCHAR(16),
	Country 	VARCHAR(64),
	ZipCode		INTEGER,
	PRIMARY KEY (AddressID),
	FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)
);

INSERT INTO Address (CustomerID, Street, City, State, Country, ZipCode) VALUES (1, "17 East San Carlos Street", "San Jose", "CA", "United States", 95122);
INSERT INTO Address (CustomerID, Street, City, State, Country, ZipCode) VALUES (2, "180 Chester Road", "Los Angeles", "CA", "United States", 90005);
INSERT INTO Address (CustomerID, Street, City, State, Country, ZipCode) VALUES (3, "811 Rich Road", "Beverly Hills", "CA", "United States", 18000);
