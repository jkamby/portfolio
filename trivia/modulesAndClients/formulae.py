# ---------------------------------------------------------------------
# formulae.py
# ---------------------------------------------------------------------

import sys
import stdio
import realcalc

a = int(sys.argv[1])
b = int(sys.argv[2])

if (((a < 1) or (a > 9)) or ((b < 1) or (b > 9))):
    stdio.writeln("Please supply command-line arguments between \
1 and 9, inclusive.")
else:
    c = realcalc.sub(realcalc.add
                 (realcalc.sub
                  (realcalc.exp(a, 3), realcalc.mul(realcalc.exp(a, 2),
                                                    realcalc.mul(2, b))),
                  realcalc.mul(realcalc.mul(4, a), realcalc.exp(b, 2))),
                 realcalc.exp(b, 3))

    d = realcalc.exp(realcalc.mod(a, b), realcalc.mul(a, b))

    e = realcalc.exp(realcalc.div(a, b), realcalc.div(1, 2))

    stdio.writeln("Equation i)   evaluates to : " + str(c))
    stdio.writeln("Equation ii)  evaluates to : " + str(d))
    stdio.writeln("Equation iii) evaluates to : " + str(e))
