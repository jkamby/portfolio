# -----------------------------------------------------------------------
# my_tree.py
# (Adopted from/inspired by tree.py from Introduction to Programming in
# Python by Robert Sedgewick, Kevin Wayne, and Robert Dondero)
# -----------------------------------------------------------------------

import stddraw
import sys
import math
import color

# -----------------------------------------------------------------------

BEND_ANGLE = math.radians(15)
BRANCH_ANGLE = math.radians(37)
BRANCH_RATIO = .65

ROOT_ANGLE = math.radians(4.71)
ROOT_RIGHT = math.radians(5.5)
ROOT_LEFT = math.radians(3.5)
ROOT_RATIO = .4

# -----------------------------------------------------------------------

# Draw a fractal tree of order n rooted at (x, y) at angle a having
# branch radius branchRadius.
leaves = False


def tree(n, x, y, a, branchRadius):
    global leaves
    if n >= 8:
        leaves = True
    cx = x + math.cos(a) * branchRadius
    cy = y + math.sin(a) * branchRadius

    if leaves and (n < 3):
        stddraw.setPenRadius(.001 * (n ** 1.5))
        stddraw.setPenColor(color.Color(0, 255, 0))
    else:
        stddraw.setPenRadius(.001 * (n ** 1.3))
        stddraw.setPenColor(color.Color(160, 82, 45))

    stddraw.line(x, y, cx, cy)
    stddraw.show(0.0)
    if (n == 0):
        return

    tree(n-1, cx, cy, a + BEND_ANGLE - BRANCH_ANGLE,
         branchRadius * BRANCH_RATIO)
    tree(n-1, cx, cy, a + BEND_ANGLE + BRANCH_ANGLE,
         branchRadius * BRANCH_RATIO)
    tree(n-1, cx, cy, a + BEND_ANGLE,
         branchRadius * (1 - BRANCH_RATIO))


def root(n, x, y, a, rootRadius):  # incomplete
    rx = x + math.cos(a) * rootRadius
    ry = y + math.sin(a) * rootRadius
    stddraw.setPenRadius(.001 * (n ** 1.2))
    stddraw.setPenColor(color.Color(101, 67, 33))

    stddraw.line(x, y, rx, ry)
    stddraw.show(0.0)
    if (n == 0):
        return

    root(n-2, rx, ry, a + ROOT_ANGLE - ROOT_RIGHT,
         rootRadius * ROOT_RATIO)
    root(n-2, rx, ry, a + ROOT_ANGLE - ROOT_LEFT,
         rootRadius * ROOT_RATIO)
    root(n-2, rx, ry, a + ROOT_ANGLE,
         rootRadius * (1 - ROOT_RATIO))

# -----------------------------------------------------------------------

# Accept integer command-line argument n. Draw a fractal tree of
# order n.


def main():
    n = int(sys.argv[1])
    tree(n, .5, 0.25, math.pi/2, .3)
    stddraw.setPenColor(color.Color(101, 67, 33))
    stddraw.line(0, 0.25, 1, 0.25)
    # root(n, .5, 0.25, 3*math.pi/2, .075)
    stddraw.show()

if __name__ == '__main__':
    main()

# -----------------------------------------------------------------------
