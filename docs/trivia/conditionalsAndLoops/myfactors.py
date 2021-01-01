#-----------------------------------------------------------------------
# myfactors.py
#-----------------------------------------------------------------------

import stdio
import sys

# Accept integer n as a command-line argument. Write to standard
# output the prime factors of n without duplication.

n = int(sys.argv[1])

factor = 2
factors = [] # an array to store the factors
while factor*factor <= n:
    while n % factor == 0:
        # Cast out and store factor.
        n //= factor
        factors += [factor] # storing factors, including duplicates
    factor += 1
    # Any factors of n are greater than or equal to factor.

if n > 1:
    factors += [n] # storing the last factor
    
for member in set(factors): # converting to a set eliminates duplicates
    stdio.write(str(member) + ' ')

stdio.writeln()
