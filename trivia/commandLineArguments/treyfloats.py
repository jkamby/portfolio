# -----------------------------------------------------------------------
# treyfloats.py
# -----------------------------------------------------------------------

import stdio
import sys

# Accept three floats as command-line arguments. Writes 'True' if they
# are in ascending or descending order and 'False' otherwise.

a = float(sys.argv[1])
b = float(sys.argv[2])
c = float(sys.argv[3])

stdio.write((a < b < c) or (a > b > c))
