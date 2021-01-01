# -----------------------------------------------------------------------
# my_banner.py
# -----------------------------------------------------------------------

import stdio
import stddraw
import sys

# Accept string command-line arguments txt and drctn. Draw txt, and
# move it top-left-to bottom-right or bottom-left-to-top-right depending
# on the supplied arguments wrapping around when it reaches the border.

txt = sys.argv[1]
drctn = sys.argv[2]

# Remove the 5% border.
stddraw.setXscale(1.0/22.0, 21.0/22.0)
stddraw.setYscale(1.0/22.0, 21.0/22.0)

# Set the font.
stddraw.setFontFamily('Arial')
stddraw.setFontSize(60)
stddraw.setPenColor(stddraw.BLACK)

i = 0.0
while True:
    stddraw.clear()
    if (drctn == 'bl-tr'):
        stddraw.text((i % 1.0), (i % 1.0), txt)
    elif (drctn == 'tl-br'):
        stddraw.text((i % 1.0), 1.0 - (i % 1.0), txt)
    else:
        stdio.writeln('Unknown direction specified.')
        break
    stddraw.text((i % 1.0) + 1.0, (i % 1.0) + 1.0, txt)
    stddraw.show(60.0)
    i += 0.01
