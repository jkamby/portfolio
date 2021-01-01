# -----------------------------------------------------------------------
# trivialcalc.py
# -----------------------------------------------------------------------

import stdio
import sys

# A simple CLI calculator that performs six (6) basic arithmetic operations:
# addition (add), subtraction (sub), multiplication (mul), division (div),
# modulo (mod)and exponentiation (exp).
#
# usage:
#
# $ python trivialcalc.py <operator> <operand1> <operand2>

op = str(sys.argv[1])
x = sys.argv[2]
y = sys.argv[3]

# converts all operands to float except modulo, which is tricky for floats.

if op == "add":
    stdio.writef('%.3f', float(x) + float(y))
elif op == "sub":
    stdio.writef('%.3f', float(x) - float(y))
elif op == "mul":
    stdio.writef('%.3f', float(x) * float(y))
elif op == "div":
    stdio.writef('%.3f', float(x) / float(y))
elif op == "mod":
    stdio.writef('%d', int(x) % int(y))
elif op == "exp":
    stdio.writef('%.3f', float(x) ** float(y))
else:
    stdio.write('Unrecognized operator!')
