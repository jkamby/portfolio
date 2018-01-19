# -----------------------------------------------------------------------
# mega_banner.py
# -----------------------------------------------------------------------

import stdio
import stddraw
import sys
from datetime import datetime, timedelta

# Accept input from a text file and capture the slogan, drctn, spd, font
# and color. Draw slogan, scroll it up/down/left/right/bl-tr/tl-br,
# fast/normal/slow in different fonts and colors depending on the supplied
# arguments wrapping around when it reaches the border.

campaign = []  # Captures the entire campaign as a 2D matrix.
while (stdio.hasNextLine()):
    slogan = stdio.readLine()  # The campaign slogan.
    drctn = stdio.readString()  # Scrolling direction. Defaults to right.
    pace = stdio.readString()  # Scrolling speed. Defaults to normal.
    speed = {'slow': 90.0, 'normal': 60.0, 'fast': 30.0}
    if pace in speed:
        spd = speed[pace]
    else:
        stdio.writeln('Unknown speed input. Defaulting to normal.')
        spd = speed['normal']
    font = stdio.readString()  # Text font.
    ink = stdio.readString()  # Text color. Defaults to black.
    penColor = {'red': stddraw.RED, 'blue': stddraw.BLUE,
                'orange': stddraw.ORANGE, 'green': stddraw.GREEN,
                'yellow': stddraw.YELLOW, 'gray': stddraw.GRAY,
                'violet': stddraw.VIOLET}
    if ink in penColor:
        pen = penColor[ink]
    else:
        stdio.writeln('Unknown color input. Defaulting to black.')
        pen = stddraw.BLACK
    job = [slogan, drctn, spd, font, pen]  # Represents each campaign.
    campaign += [job]
    blank = stdio.readLine()  # Here to help with the text file's format.

# Remove the 5% border.
stddraw.setXscale(1.0/22.0, 21.0/22.0)
stddraw.setYscale(1.0/22.0, 21.0/22.0)

for j in range(len(campaign)):
    # Set the font and color.
    stddraw.setFontFamily(campaign[j][3])
    stddraw.setFontSize(60)
    stddraw.setPenColor(campaign[j][4])
    
    i = 0.0
    t = datetime.now() + timedelta(seconds=10)  # 10 sec. display/banner.
    while datetime.now() < t:
        stddraw.clear()
        if (campaign[j][1] in ('down', 'up')):
            stddraw.text(0.5, (i % 1.0), campaign[j][0])
            stddraw.text(0.5, (i % 1.0) - 1.0, campaign[j][0])
            stddraw.text(0.5, (i % 1.0) + 1.0, campaign[j][0])
            stddraw.show(campaign[j][2])
            if (campaign[j][1] == 'up'):
                i += 0.01
            else:
                i -= 0.01
        elif (campaign[j][1] in ('bl-tr', 'tl-br')):
            if (campaign[j][1] == 'bl-tr'):
                stddraw.text((i % 1.0), (i % 1.0), campaign[j][0])
            else:
                stddraw.text((i % 1.0), 1.0 - (i % 1.0), campaign[j][0])
            stddraw.text((i % 1.0) + 1.0, (i % 1.0) + 1.0, campaign[j][0])
            stddraw.show(60.0)
            i += 0.01
        else:
            if (campaign[j][1] not in ('left', 'right')):
                stdio.writeln('Unknown direction input. Defaulting to right.')
                drctn = 'right'
            stddraw.text((i % 1.0), 0.5, campaign[j][0])
            stddraw.text((i % 1.0) - 1.0, 0.5, campaign[j][0])
            stddraw.text((i % 1.0) + 1.0, 0.5, campaign[j][0])
            stddraw.show(campaign[j][2])
            if (campaign[j][1] == 'left'):
                i -= 0.01
            else:
                i += 0.01
