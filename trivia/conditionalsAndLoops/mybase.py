# ----------------------------------------------------------------------
# mybase.py
# ----------------------------------------------------------------------

import sys
import stdio

# Accept integers i and k as a command-line arguments.
# Converts i (base 10) to base k and prints to this to standard output.

# Limitation: Does not handle negative integers or bases > 16.

i = int(sys.argv[1])
k = int(sys.argv[2])

q = i
r = []

while (q > 0):
    r += [q % k]
    q //= k

j = len(r) - 1

while (j >= 0):
    m = r[j]
    if m > 9:
        f = m - 9
        if f == 1:
            stdio.write('A')
        elif f == 2:
            stdio.write('B')
        elif f == 3:
            stdio.write('C')
        elif f == 4:
            stdio.write('D')
        elif f == 5:
            stdio.write('E')
        else:
            stdio.write('F')
    else:
        stdio.write(m)

    j -= 1
