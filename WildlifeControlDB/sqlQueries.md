

#### The following view is used to make information about visits more accessible to users.
#### This view allows the user to see what employee visited which customers, what service was
#### offered, and gives a description of the visit as well as notes for future visits to the
#### property. Without thisview, users would have a hard time cross referencing all of the 
#### different ID's on the separate tables.

	CREATE VIEW EmployeeVisits AS
	SELECT  
		CONCAT(employees.firstName, " ", employees.lastName) AS "Employee Name",  
		visitId AS "Visit ID",  
		servName AS "Service Offered",  
		visitDesc AS "Visit Description",  
		futureNotes AS "Notes for future visits",  
		CONCAT(customers.firstName, " ", customers.lastName) AS "Customer Name"  
	FROM visits  
	LEFT JOIN  
		employees  
		on employees.employeeId = visits.employeeId  
	LEFT JOIN   
		customers  
		on customers.customerId = visits.customerId  
	LEFT JOIN  
		services  
		on services.serviceId - visits.serviceId;  

#### The following view was also created to make information more accessible to users.
#### The customer transaction view shows services offered, customer name, payment method,
#### total price, as well as email and the dates the service was offered. Without this
#### view, users would have a hard time cross referencing all of the different ID's on the
#### separate tables.

	CREATE VIEW CustomerTransactions AS  
		select 
			concat(customers.firstName," ",customers.lastName) AS "Customer Name",
			services.servName AS "Service Offered",
			purchases.totalPrice AS "Total Price",
			customers.paymentInfo AS "Payment Method",
			customers.email AS "Customer Email",
			purchases.dateBegin AS "Service Start Date",
			purchases.dateEnd AS "Service End Date"
		from purchases
		left join 
			customers 
			on customers.customerId = purchases.customerId 
		left join 
			services
			on purchases.serviceId = services.serviceId;

#### This trigger is meant to automatically update the visit count on each purchase when
#### a new visit is added to a purchase. This is to keep track of how much work was needed to
#### be done before a job could be completed.

	CREATE TRIGGER update_vist_count  
		AFTER INSERT ON visits  
	FOR EACH ROW  
	BEGIN  
	SELECT COUNT(*) AS numVisits   
	FROM visits  
	WHERE visits.purchaseId = NEW.purchaseId  
		IF(numVisits > purchases.numVisits)  
		THEN  
	END;  



#### This query shows what customers purchased which services and how much they paid for them.

	SELECT  
		CONCAT(firstName, " ", lastName) AS "Customer Name",  
		purchaseId,  
		servName as "service offered",  
		totalPrice  
	FROM purchases  
	LEFT JOIN  
		services  
		on services.serviceId = purchases.serviceId  
	LEFT JOIN  
		customers  
		on customers.customerId = purchases.customerId;	  


#### This query shows what service specialty each employee has.

	SELECT  
		CONCAT(firstName, " ", lastName) AS "Employee Name",  
		servName AS "Service Specialty"  
    	FROM  
		employees  
   	LEFT JOIN  
		services  
		on services.serviceId = employees.servSpec;  


#### this query shows what the most expensive purchase was

	SELECT MAX(totalPrice)  
	FROM purchases;  

#### this query shows the average number of visits made per purchase.

	SELECT AVG(numVisits)  
   	FROM purchases;  

#### This query returns purchases which cost more than 120$ and had fewer than 3 visits.

	SELECT  
		purchaseId,  
		servName,  
		numVisits,  
		totalPrice  
	FROM  
		purchases  
	LEFT JOIN  
		services  
		on purchases.serviceId = services.serviceId  
	WHERE  
		totalPrice > 120 AND numVisits < 3  

#### This query shows all purchases which dealt with skunk removal

	SELECT *  
	FROM purchases  
	LEFT JOIN services  
		ON purchases.serviceId = services.serviceId  
	WHERE servName like "Skunk Removal"  


#### This query selects all of the unique services that have been performed in the visits table
	
	SELECT  
		DISTINCT purchaseId,  
		CONCAT(firstName, " ", lastName) AS "Employee Name",  
		servName  
	FROM visits  
	LEFT JOIN  
		employees  
		ON employees.employeeId = visits.employeeId  
	LEFT JOIN  
		services  
		ON services.serviceId = visits.serviceId  



#### This query will show all of the information from the EmployeeVisits table which is relevant to the jobs that
#### are complete.

	SELECT *  
	FROM 'EmployeeVisits'  
	WHERE 'Notes for future visits' = 'Job Complete'  


#### This query shows all of the information relevant to visits which dealt with skunk removal.

	SELECT *  
	FROM 'EmployeeVisits'  
	WHERE 'Service Offered' = "Skunk Removal"  
 

	
