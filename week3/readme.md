# THM labs
## Enumeration & Brute Force
![image](https://github.com/user-attachments/assets/d4a6c025-6154-432a-9471-6d75ea42d64b)

## OWASP Broken Access Control

![image](https://github.com/user-attachments/assets/e7523b7e-cfc2-45f0-a35c-88337cd87250)

# portswigger access control labs
![access control](https://github.com/user-attachments/assets/efc3d333-726d-4de3-b8c2-b17a119ed8fb)
# the main idea of portswigger authentication labs

## Lab: Username enumeration via different responses
brute force username until we find different response code then to do with password again
## Lab: 2FA simple bypass
brute force username until we find different error code then brute force again with passwords to find different response code
## Lab: Username enumeration via response timing
brute force username with changeing X-Forwarded-For header until we find different response length or response timing then brute force again with passwords 
## Lab: Broken brute-force protection, IP block
brute force user names but after 2 req send 1 correct req to don't get blocked 
## Lab: Username enumeration via account lock
brute force usernames many times untill we find that he blooks us when the usenname is correct and the username is not then bruteforce
the passwords bruteforce all passwords but the aite has a logical error when the password was correct the response came back less than every time
## Lab: 2FA simple bypass
skip entering 2FA code and go to my-account page 
## Lab: 2FA broken logic
we need to change (verify) parameter to carlos user to make the site send carlos 2FA code then bruteforce the mfa code
## Lab: Brute-forcing a stay-logged-in cookie
the site recognize the user from stay-logged-in parameter 
  the prameter format is base64(username:md5(hash))
## Lab: Password reset broken logic
this lab is vuln at forget-password function which the function compare the forget password token to work which we can change it to any thing and change the username
## Lab: Password reset poisoning via middleware
in this lab we need victim token to use it in forget password req which we can add X-Forwarded-Host header with our sever to steal his token 
## Lab: Password brute-force via password change
the change password function is vuln which we can brute force it and change username parameter to carlos until we found the error code don't tell us that password is not correct like we can put confirmation pasword wrong to wait to get the massage say the confirmation password is worng not the current password
## Lab: Broken brute-force protection, multiple credentials per request
the function of log is vulnerable which is accept data as json format which we can add many passwords and it's accept the right password


# summary of Authorization Bypass reports from HackerOne

## report #791775
this report for account take over by changing email
1. create account => (hacker@gmail.com)
2. go to change email and put vicitm email => (victim@gmail.com)
3. the confirmation email will send to hacker@gmailcom which is not logical
4. now you have access to victim account

## report #322985
The attacker was able to send a password reset link to an arbitrary email by sending an array of email addresses instead of a single email address.
1. go to reset password page
2. the input field accept data as JSON format
3. put in the input more than one email you want to reset in JSON format
   {"email_address":["admin@breadcrumb.com","attacker@evil.com"]}
5. now you have reset password of all emails you send for them 
   
## report #300305
Create a store account and invite an employee.
Accept the employee invite (maybe not necessary I didn't test).
Login to or create a partner account as the attacker.
Go to your partner settings page https://partners.shopify.com/[ID]/settings and change your email to something you own.
Check your email and grab the confirmation link, but don't visit it yet.
Go back to your partner account and change your email to that of the store employee from step 2, but intercept the request to not let it through yet.
Now the tricky part. The "change email" takes anywhere from 1,100 - 2,500 ms to load so you need to take that into account. But let the request go through, wait for some milliseconds, then in another tab visit that email confirmation link from step 5.
If done correctly you will now have confirmed an email you do not own.
Visit https://partners.shopify.com/[ID]/managed_stores, add the store, and you now have access.
