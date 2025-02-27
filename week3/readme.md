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
the attacker can confirm employee account from partner confirmation link in the same shop
1. Create a store account and invite an employee.
2. Accept the employee invite (maybe not necessary I didn't test).
3. Login to or create a partner account as the attacker.
4. Go to your partner settings page https://partners.shopify.com/[ID]/settings and change your email to something you own.
5. Check your email and grab the confirmation link, but don't visit it yet.
6. Go back to your partner account and change your email to that of the store employee from step 2, but intercept the request to not let it through yet.
7. Now the tricky part. The "change email" takes anywhere from 1,100 - 2,500 ms to load so you need to take that into account. But let the request go through, wait
for some milliseconds, then in another tab visit that email confirmation link from step 5.
If done correctly you will now have confirmed an email you do not own.
Visit https://partners.shopify.com/[ID]/managed_stores, add the store, and you now have access.

## report #1861487
this vuln is in admin approval for jop requests which the user after offering a job the admin need to approve it we can change the statusr to active which we can scam many offers


## report #172545
this shop site every user can add products 
vulnerability is in endpoint we can  call list or product we don't have by id parameter 
1. Log in as User A
2. Create a listing
3. Using a proxy like burp, note the calls and look for /api/listing/YOURID/product_bundle
4. Repeat the call to your /api/listing/YOURID/product_bundle but change the id to 65905 - my unlisted product. You will receive the product details.
1. In employer mode, create a new job offer
2. Fill in the required fields
3. After the creation, the offer will appear as "Pending Approval"
4. In Burp Proxy, send the last "UpdateVacancyStatus" request to Repeater, modifying "status":"ACTIVE"


## report #305056
this file sharing site which we can upload files and request a link to share it to others 
the vulnerability here is in if someone send me file we can access another file in the same path 
1. user send something.png to a friend 
2. the friend change the (path) parameter in the url to foo
3.  the url will return file 
 start with foo like footer or else

## report #501081
this vulnerability is in bot have permissions that normal user don't have we can add script to the bot to change role of normal user to admin

1. Login Guest user
2. Determine own users _id from browser traffic
3. Escalate to bot group
4. Create malicious script have user id to promote to admin
5. The arbitrary ad will now show up as "Active", it will have been verified and published. All users will be able to see it.


## report #1448550
this vulnerability is make user remove user from any group by intercept removing user from his group by chabthe user id and the user in group id by the group and user he want go remove 

## report #1424291
this vulnerability make user have access for private content with change in header and user id and picture id while sending it to endpoint 
1. An attacker could send a request with Accept: application/json to the endpoint /users/{user-id}/pictures/{pic-id}.
2. The server would return private content without proper access checks.
3. The attack required knowing the asset's ID beforehand.

 ## report #1546726
 A vulnerability in the Payment Status function allows unauthorized access without authentication. Attackers can check the payment status of any transaction by making a direct request, exposing sensitive transaction details.

# summary of Authentication reports from HackerOne

## report #921780
this vulnerability is on snap chat log out function which when you logout with victim userid the site sent otp code by mistakenly 

1. Normally, when you log out, Snapchat expects your own user_id in the logout request.
2. The attacker replaces their user_id with the victim’s user_id in the logout request.
3. Snapchat mistakenly sends back an OTP token (a one-time password token) for the victim's account, thinking the victim is logging in.
4. The attacker then uses this OTP token to log in as the victim.

## report #770504

this vulnerability is in twitter when you change email or phone number the site asks for password and sent flow_token with status is it true or false and redirect it

1. Go to Settings and Privacy -> Accounts.
2. Click on Email -> Update email address.
3. Enter any random password and click 'Next'.
4. Intercept the request and copy the flow token.
5. Modify the server's response to indicate a successful authentication.
6. Forward the modified response to bypass the password screen.

## report #1490470
the attacker can login as admin by signing in with user name admin and password and 
the res will back with status false
change it to true and fowrard it back 

## report #1709881
this report is ato the attacker can sign in on any acoount with changing in response value parameter from false to true 

## report #128085
this vulnerability make anyone have in his account to 2fa to access any account have also 2fa
1. by creating a request for otp
2. intercept it
3. add to the req log in header to the request
4. add valid otp code to the header from attacker account 

## report #970157
this vulnerability in change password where no limit which we can brute force password list to know the right password if it's easy

## report #1879549
the victim send private group invite to attacker 
the attacker can see the victim email in invite link 
It looks like :- /remote.php/dav/calendars/ha.ckitbharat3@gmail.com/app-generated--deck--board-5269/
the attacker try to login to account with the email he get from the invite
the attacker can intercept the req and see that username and password is base64 encoded
we can now brute force many passwords with the email we have and ecode them base 64 untill we found valid password

## report #2414707

this report is about we can access a site which we are not authorized to acces by visit other site then visit it which it gives us a session we can acces this unauthorized site 

## report #2293343
this  vulnerability make the attacker can take over any account by email
1. Go to "Forgot Your Password?" link
2. Enter the victim's email and intercept the submit request via Burp Suite
3. Convert to content-type JSON
4. Now replace this converted JSON line "user[email]":"victim@gmail.com", to
   "user" {
     "email" [
              "victim@gmail.com"
              "attacker@gmail.com"
       ]
 },
5. Forward the requests and you should get an email containing the reset link that was send to both emails (victim@gmail.com and attacker@gmail.com) .
6. Click on the reset link, change the password and done, you can now login as the victim using the new password.
