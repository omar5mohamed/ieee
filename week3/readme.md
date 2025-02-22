# portswigger access control labs
![access control](https://github.com/user-attachments/assets/efc3d333-726d-4de3-b8c2-b17a119ed8fb)
# THM Broken Access Control
![image](https://github.com/user-attachments/assets/d7094e00-0dcb-46e1-adb0-0cc86beb6155)

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
  
## Lab: Password brute-force via password change
the change password function is vuln which we can brute force it and change username parameter to carlos until we found the error code don't tell us that password is not correct like we can put confirmation pasword wrong to wait to get the massage say the confirmation password is worng not the current password
