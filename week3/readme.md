# portswigger access control labs
![access control](https://github.com/user-attachments/assets/efc3d333-726d-4de3-b8c2-b17a119ed8fb)
# THM Broken Access Control
![image](https://github.com/user-attachments/assets/d7094e00-0dcb-46e1-adb0-0cc86beb6155)

# the main idea of portswigger labs

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
