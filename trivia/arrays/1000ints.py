#-----------------------------------------------------------------------
# 1000ints.py
#-----------------------------------------------------------------------

import stdarray
import stdio

# Create a 1000 int array then access the "1000th" element.

a = stdarray.create1D(1000, value=5)
stdio.writeln(a[1000])
