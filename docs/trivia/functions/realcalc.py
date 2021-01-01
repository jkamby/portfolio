import sys
import stdio


def add(x, y):
    """
    Returns the addition of two floats
    """
    return float(x) + float(y)


def sub(x, y):
    """
    Returns the subtraction of two floats
    """
    return float(x) - float(y)


def mul(x, y):
    """
    Returns the multiplication of two floats
    """
    return float(x) * float(y)


def div(x, y):
    """
    Returns the division of two floats
    """
    if(float(y) == 0):
        stdio.writeln("The divisor must not be zero.")
        return
    else:
        return float(x) / float(y)


def mod(x, y):
    """
    Returns the modulo of two ints
    """
    if(int(y) == 0):
        stdio.writeln("The mudulo operand may not be zero.")
        return
    else:
        return int(x) % int(y)


def exp(x, y):
    """
    Returns the result of one float raised to the power of the other
    """
    return float(x) ** float(y)


def main():
    a = sys.argv[1]
    b = sys.argv[2]
    stdio.writeln("Addition: " + str(add(a, b)))
    stdio.writeln("Subtraction: " + str(sub(a, b)))
    stdio.writeln("Multiplication: " + str(mul(a, b)))
    stdio.writeln("Division: " + str(div(a, b)))
    stdio.writeln("Modulo: " + str(mod(a, b)))
    stdio.writeln("Exponentiation: " + str(exp(a, b)))

if __name__ == '__main__':
    main()
