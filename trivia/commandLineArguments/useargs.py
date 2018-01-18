# -----------------------------------------------------------------------
# useargs.py
# -----------------------------------------------------------------------

import stdio
import sys

# Accept three names as command-line arguments. Writes to starndard output
# pre-formatted text with the arguments included.

stdio.writeln('Dear ' + sys.argv[3] + ' ' + sys.argv[1][:1] \
              + '. ' + sys.argv[2] + ',')
stdio.writeln(
    '\tYour user home dir is:\t' + sys.argv[3][:1] +sys.argv[2] + '.')
stdio.writeln('\tYou must log off by:\t5 O\'clock.')


