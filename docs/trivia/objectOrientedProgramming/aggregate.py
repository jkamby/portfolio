# -----------------------------------------------------------------------
# aggregate.py
# -----------------------------------------------------------------------

import sys
import stdio

# ----------------------------------------------------------------------


class Aggregate:

    # Construct self with scores for homework, hw, projects, pj,
    # exams, ex and attendance, at. Plus default scale upper and lower
    # bounds, 100.00 and 60.00, respectively.
    def __init__(self, hw, pj, ex, at):
        self._hw = hw  # amalgamated homework % score
        self._pj = pj  # amalgamated projects % score
        self._ex = ex  # consolidated exams % score
        self._at = at  # consolidated attendance % score
        self._upp = 100.00
        self._low = 60.00

    # Recalibrate the grading scale.
    def scale(self, low, upp):
        self._upp = upp
        self._low = low

    # Return a string representation of a grade.
    def __str__(self):
        wgtAvg = 0.15 * self._hw + 0.3 * self._pj + 0.5 * self._ex + \
                 0.05 * self._at
        quart = (self._upp - self._low)/4.0
        if (wgtAvg > self._upp - quart):
            return 'A'
        elif (wgtAvg > self._upp - quart * 1.2):
            return 'A-'
        elif (wgtAvg > self._upp - quart * 2):
            return 'B'
        elif (wgtAvg > self._upp - quart * 2.2):
            return 'B-'
        elif (wgtAvg > self._upp - quart * 3):
            return 'C'
        elif (wgtAvg > self._upp - quart * 4):
            return 'D'
        else:
            return 'F'


# ----------------------------------------------------------------------

# For testing.
# Accept floats l and u as command-line arguments. Create an Aggregate
# object with hard-coded homework, projects exam and attendance scores.
# Apply a new grading scale. Compare the output from the different scales.

def _main():
    l = float(sys.argv[1])
    u = float(sys.argv[2])
    g = Aggregate(90, 80, 90, 100)
    stdio.writeln("Testing with hw=90, pj=80, ex=90 and at=100")
    stdio.writeln("In the old scale, the grade is: " + str(g))
    g.scale(l, u)
    stdio.writeln("With a new scale applied, the grade is: " + str(g))

if __name__ == '__main__':
    _main()

# -------------------------------------------------------------------
