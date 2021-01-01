# -----------------------------------------------------------------------
# twoints.py
# -----------------------------------------------------------------------

import stdio
import sys

# Accept two +ve integers as command-line arguments. Writes 'Both' if
# they are mutually divisible, 'One' if one is divisible by the other but
# not the other by the first (or vice versa) and 'Neither' if neither is
# divisible by the other.

a = int(sys.argv[1])
b = int(sys.argv[2])

if ((a % b == 0) and (b % a == 0)):
    stdio.writeln('Both')
elif ((a % b == 0) or (b % a == 0)):
    stdio.writeln('One')   
else:
    stdio.writeln('Neither')
