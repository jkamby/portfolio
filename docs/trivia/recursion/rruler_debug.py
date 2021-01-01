# -*- coding: cp1252 -*-
# -----------------------------------------------------------------------
# rruler.py
# -----------------------------------------------------------------------

import stdio
import sys
import my_stdarray

# Write to standard output the relative lengths of the subdivisions on
# a ruler. The nth line of output is the relative lengths of the marks
# on a ruler subdivided in intervals of 1/2^n of an inch.  For example,
# the fourth line of output gives the relative lengths of the marks
# that indicate intervals of one-sixteenth of an inch on a ruler.

# n = sys.argv[1]

def ruler(n):
    """
    Recursively generate the ruler output of n.
    """
    if n == 1:
        result = '1'
    else:
        result = ruler(n-1) + str(n) + ruler(n-1)
    # stdio.writeln(result)
    # my_stdarray.to3D(result)
    return result

def to3D(numString):
    dDNA = map(int, numString)
    stdio.write("The double-dna strand is: ")
    stdio.writeln(dDNA)
    strand = len(numString)
    o = strand/2
    dna = dDNA[o:]
    m = len(dna)
    stdio.write("The dna strand is: ")
    stdio.writeln(dna)
    cube = my_stdarray.create3D(strand, strand, strand, 0)

    for k in range(m):
        for j in range(m):
            for i in range(m):
                if(i+j+k <= o):
                    cube[o+i][o+j][o+k] = dna[i+j+k]
                    cube[o-i][o-j][o-k] = dna[i+j+k]
                    cube[o+i][o-j][o+k] = dna[i+j+k]
                    cube[o-i][o+j][o-k] = dna[i+j+k]
                    cube[o+i][o+j][o-k] = dna[i+j+k]
                    cube[o-i][o-j][o+k] = dna[i+j+k]
    stdio.write("The 3D array is: ")
    stdio.writeln(cube)
    return cube

def _main():
    """
    For testing.
    """
    x = stdio.readInt()
    
    stdio.writeln(ruler(x))
    my_stdarray.write3D(to3D(ruler(x)))
    
if __name__ == '__main__':
    _main()


