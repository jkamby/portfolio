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


def ruler(n):
    """
    Recursively generate the ruler output of n.
    """
    if n == 1:  # the base case.
        result = '1'
    else:
        result = ruler(n-1) + str(n) + ruler(n-1)   # the recursion.
    return result


def to3D(numString):
    dDNA = map(int, numString)  # creating my DNA "double helix"
    strand = len(numString)     # the length of my "chromosome"
    o = strand/2
    dna = dDNA[o:]              # splitting the DNA "double helix"
    m = len(dna)
    cube = my_stdarray.create3D(strand, strand, strand, 0)
    for k in range(m):
        for j in range(m):
            for i in range(m):
                if(i+j+k <= o):  # creating cube from extracted DNA
                    cube[o+i][o+j][o+k] = dna[i+j+k]
                    cube[o+i][o+j][o-k] = dna[i+j+k]
                    cube[o+i][o-j][o+k] = dna[i+j+k]
                    cube[o+i][o-j][o-k] = dna[i+j+k]
                    cube[o-i][o+j][o+k] = dna[i+j+k]
                    cube[o-i][o+j][o-k] = dna[i+j+k]
                    cube[o-i][o-j][o+k] = dna[i+j+k]
                    cube[o-i][o-j][o-k] = dna[i+j+k]
    return cube


def main():
    x = int(sys.argv[1])

    rruler = ruler(x)
    rrule3D = to3D(rruler)

    stdio.writeln(rrule3D)  # minimum requirement of assignment
    stdio.writeln()
    stdio.writeln("A 3D depiction of this array is as follows:")
    stdio.writeln()
    my_stdarray.write3D(rrule3D)  # for extra credit on assignment

if __name__ == '__main__':
    main()
