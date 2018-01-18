"""
my_stdarray.py

The stdarray module defines functions related to creating, reading,
and writing three-dimensional arrays. (Adopted from/inspired by
stdarray.py from Introduction to Programming in Python by
Robert Sedgewick, Kevin Wayne, and Robert Dondero.
"""

import stdio

# ======================================================================
# Array creation function
# ======================================================================


def create3D(hCount, wCount, bCount, value=None):
    """
    Create and return a 3D array having hCount rows and wCount
    columns and bCount depth, with each element initialized to value.
    """
    a = [None] * hCount
    for row in range(hCount):
        a[row] = [value] * wCount
        for col in range(wCount):
            a[row][col] = [value] * bCount
    return a

# ======================================================================
# Array writing function
# ======================================================================


def write3D(a):
    """
    Write three-dimensional array a to sys.stdout.  First write its
    dimensions. bool objects are written as F and T, not False and True.
    """
    hCount = len(a)
    wCount = len(a[0])
    bCount = len(a[0][0])
    stdio.writeln(str(hCount) + ' ' + str(wCount) + ' ' + str(bCount))
    for row in range(hCount):
        for deep in range(bCount):
            stdio.write('  ' * deep)
            for col in range(wCount):
                element = a[row][col][deep]
                if isinstance(element, bool):
                    if element:
                        stdio.write('T')
                    else:
                        stdio.write('F')
                else:
                    stdio.write(element)
                stdio.write('  ' * (bCount - 1))
            stdio.writeln()

# ======================================================================
# Array reading functions
# ======================================================================


def readInt3D():
    """
    Read from sys.stdin and return a three-dimensional array of integers.
    Three integers at the beginning of sys.stdin define the array's
    dimensions.
    """
    rowCount = stdio.readInt()
    colCount = stdio.readInt()
    depthCount = stdio.readInt()
    a = create3D(hCount, wCount, bCount, 0)
    for deep in range(bCount):
        for row in range(hCount):
            for col in range(wCount):
                a[row][col][deep] = stdio.readInt()
    return a

# ----------------------------------------------------------------------


def readFloat3D():
    """
    Read from sys.stdin and return a three-dimensional array of floats.
    Three integers at the beginning of sys.stdin define the array's
    dimensions.
    """
    hCount = stdio.readInt()
    wCount = stdio.readInt()
    bCount = stdio.readInt()
    a = create3D(hCount, wCount, bCount, 0.0)
    for deep in range(bCount):
        for row in range(hCount):
            for col in range(wCount):
                a[row][col][deep] = stdio.readFloat()
    return a

# ----------------------------------------------------------------------


def readBool3D():
    """
    Read from sys.stdin and return a three-dimensional array of booleans.
    Three integers at the beginning of sys.stdin define the array's
    dimensions.
    """
    hCount = stdio.readInt()
    wCount = stdio.readInt()
    bCount = stdio.readInt()
    a = create3D(hCount, wCount, bCount, False)
    for deep in range(bCount):
        for row in range(hCount):
            for col in range(wCount):
                a[row][col][deep] = stdio.readBool()
    return a

# ======================================================================


def _main():
    """
    For testing.
    """
    write3D(readFloat3D())
    write3D(readBool3D())

if __name__ == '__main__':
    _main()
