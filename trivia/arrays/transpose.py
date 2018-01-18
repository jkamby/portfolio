# -----------------------------------------------------------------------
# transpose.py
# -----------------------------------------------------------------------

import stdio
import sys

# Transposing a two-dimensional array (of ints).

# This program is designed to prompt for input
stdio.writeln('Prepare to enter the original matrix.')
stdio.write('How many rows? ')
n = stdio.readInt()
stdio.write('How many columns? ')
m = stdio.readInt()

original = [[stdio.readInt() for i in range(m)] for j in range(n)]

# stdio.writeln(original) - debugging code
transposed = [[row[x] for row in original] for x in range(m)]

stdio.writeln(transposed)
