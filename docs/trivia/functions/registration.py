# ---------------------------------------------------------------------
# registration.py
# ---------------------------------------------------------------------

import stdio
import sys
import csv

# Routine that loads data from a CSV file.
members = {}

if len(sys.argv) == 2:
    file_sid = 0
    with open(sys.argv[1], 'rb') as csvfile:
        records = csv.reader(csvfile, delimiter=",")
        for record in records:
            file_sid += 1
            members[file_sid] = {}
            members[file_sid]['fname'] = record[0]
            members[file_sid]['lname'] = record[1]
            members[file_sid]['gender'] = record[2]
            members[file_sid]['email'] = record[3]
            members[file_sid]['enrolled'] = int(record[4])
            members[file_sid]['level'] = record[5]


def level0():
    stdio.writeln()
    stdio.writeln(" Welcome to the XYZ Program registry.")
    stdio.writeln(" ------------------------------------")
    stdio.writeln(" 1. View")
    stdio.writeln(" 2. Edit")
    stdio.writeln(" 3. Quit")
    stdio.writeln(" -------")
    stdio.write(" Make a choice (1, 2 or 3): ")


def level01():
    stdio.writeln()
    stdio.writeln(" Choose your view: ")
    stdio.writeln(" ----------------- ")
    stdio.writeln(" 1. Summary")
    stdio.writeln(" 2. Details")
    stdio.writeln(" 3. Go Back")
    stdio.writeln(" -------------")
    stdio.write(" Make a choice (1, 2 or 3): ")


def level012():
    stdio.writeln()
    stdio.writeln(" Do you wish to sort the registry by: ")
    stdio.writeln(" ------------------------------------")
    stdio.writeln(" 1. Last Name")
    stdio.writeln(" 2. Gender")
    stdio.writeln(" 3. Enrolled")
    stdio.writeln(" 4. Level")
    stdio.writeln(" 5. None of these")
    stdio.writeln(" ----------------")
    stdio.write(" Make a choice (1, 2, 3, 4 or 5): ")


def level02():
    stdio.writeln()
    stdio.writeln(" Choose from the following menu:")
    stdio.writeln(" -------------------------------")
    stdio.writeln(" 1. Add")
    stdio.writeln(" 2. Delete")
    stdio.writeln(" 3. Change")
    stdio.writeln(" 4. Go Back")
    stdio.writeln(" -------------")
    stdio.write(" Make a choice (1, 2, 3 or 4): ")


def level023(sid):
    stdio.writeln()
    stdio.writeln(" Which part of " + members[sid]['fname'] +
                  "'s record do you  wish to change?")
    stdio.writeln(" -----------------------------------------------------")
    stdio.writeln(" 1. First Name")
    stdio.writeln(" 2. Last Name")
    stdio.writeln(" 3. Email")
    stdio.writeln(" 4. Level")
    stdio.writeln(" 5. Go Back")
    stdio.writeln(" -------------")
    stdio.write(" Make a choice (1, 2, 3 or 4): ")


def displayDetailedRegistry():
    global members
    count = 0
    limit = 10
    stdio.write(" Do you wish to view [10, 25 or 50] records at a time? ")
    desired = stdio.readInt()
    if desired not in (10, 25, 50):
        limit = 10
    else:
        limit = desired
    sorted_members = sorted(members.iterkeys())
    level012()
    choice = stdio.readInt()
    if choice == 1:
        sorted_members = [k for (v, k) in sorted(
            [(v['lname'], k) for (k, v) in members.items()])]
    elif choice == 2:
        sorted_members = [k for (v, k) in sorted(
            [(v['gender'], k) for (k, v) in members.items()])]
    elif choice == 3:
        sorted_members = [k for (v, k) in sorted(
            [(v['enrolled'], k) for (k, v) in members.items()])]
    elif choice == 4:
        sorted_members = [k for (v, k) in sorted(
            [(v['level'], k) for (k, v) in members.items()])]
    elif choice == 5:
        stdio.writeln(" Defaulting to sorting by Student ID.")
    else:
        stdio.writeln(" Unrecognized selection." +
                      " Defaulting to sorting by Student ID.")

    if not sorted_members:
        stdio.writeln(" The are no registered members.")
    else:
        stdio.writeln()
        stdio.write(" Student ID" + "\t" + "First Name" + "\t" + "Last Name ")
        stdio.write("\t" + "Gender" + "\t" + "Email     " + "\t" + "Enrolled")
        stdio.writeln("\t" + "Level")
        stdio.write(" ----------" + "\t" + "----------" + "\t" + "----------")
        stdio.write("\t" + "------" + "\t" + "----------" + "\t" + "--------")
        stdio.writeln("\t" + "-----")
        for sid in sorted_members:
            stdio.writef("%s%04d", "   ", sid)
            stdio.write("\t\t")
            stdio.writef("%s%-8s", "  ", members[sid]['fname'])
            stdio.write("\t")
            stdio.writef("%s%-8s", "  ", members[sid]['lname'])
            stdio.write("\t")
            stdio.writef("%4s", members[sid]['gender'])
            stdio.write("\t")
            stdio.writef("%8s", members[sid]['email'])
            stdio.write("\t")
            stdio.writef("%4d", members[sid]['enrolled'])
            stdio.write("\t\t")
            stdio.writef("%5s", members[sid]['level'])
            stdio.writeln()

            count += 1
            if count % limit == 0:
                stdio.write(" Do you wish to view the next " + str(limit) +
                            " records? (y/n): ")
                if stdio.readString().startswith('y'):
                    continue
                else:
                    break


def displaySummarizedRegistry():
    global members
    count = 0
    if not members:
        stdio.writeln(" The are no registered members.")
    else:
        stdio.writeln()
        stdio.writeln(" First Name" + "\t" + "Last Name " + "\t" + "Gender" +
                      "\t" + "Email     ")
        stdio.writeln(" ----------" + "\t" + "----------" + "\t" + "------" +
                      "\t" + "----------")
        for sid in members:
            stdio.writef(" %8s", members[sid]['fname'])
            stdio.write("\t")
            stdio.writef("%8s", members[sid]['lname'])
            stdio.write("\t")
            stdio.writef("%4s", members[sid]['gender'])
            stdio.write("\t")
            stdio.writef("%8s", members[sid]['email'])
            stdio.writeln()

            count += 1
            if count % 10 == 0:
                stdio.write(" Do you wish to view the next 10? (y/n): ")
                if stdio.readString().startswith('y'):
                    continue
                else:
                    break


def addRecord():
    global members
    chances = 0
    sid = len(members) + 1
    stdio.write(" The new member's ID is: ")
    stdio.writef("%4d", sid)
    stdio.writeln()
    details = {}
    stdio.write(" Please enter their First Name: ")
    details['fname'] = stdio.readString()
    stdio.write(" Please enter their Last Name: ")
    details['lname'] = stdio.readString()
    while True:
        stdio.write(" Please enter their Gender (M/F/Other): ")
        details['gender'] = stdio.readString()
        if details['gender'] not in ('M', 'F', 'Other'):
            chances += 1
            if chances == 3:
                stdio.writeln(" Sorry you have to start afresh.")
                # Or return without adding record...
                exit()
            else:
                stdio.writeln(" You have " + str(3 - chances) +
                              " chance(s) left to enter a valid Gender.")
        else:
            chances = 0
            break
    stdio.write(" Please enter their Email address: ")
    details['email'] = stdio.readString()
    while True:
        stdio.write(" lease enter their Year of Enrolment (YYYY): ")
        details['enrolled'] = stdio.readInt()
        if details['enrolled'] not in range(1950, 2018):
            chances += 1
            if chances == 3:
                stdio.writeln(" Sorry you have to start afresh.")
                break
            else:
                stdio.writeln(" You have " + str(3 - chances) +
                              " more chance(s) to enter a valid " +
                              "Year of Enrolment.")
        else:
            chances = 0
            break
    while True:
        stdio.write(" Please enter their Level (Grad/Ugrad): ")
        details['level'] = stdio.readString()
        if details['level'] not in ('Grad', 'Ugrad'):
            chances += 1
            if chances == 3:
                stdio.writeln(" Sorry you have to start afresh.")
                break
            else:
                stdio.writeln(" You have " + str(3 - chances) +
                              " chance(s) left to enter a valid Level.")
        else:
            chances = 0
            break
    members[sid] = details
    stdio.writeln(" Successfully registered: " + members[sid]['fname'] +
                  " " + members[sid]['lname'] + " (" + str(sid) + ")")


def changeRecord():
    global members
    stdio.write(" Please enter the student's ID: ")
    sid = stdio.readInt()
    if sid in members:
        level023(sid)
        choice = stdio.readInt()
        if choice == 1:
            stdio.write(" Please enter the new First Name: ")
            members[sid]['fname'] = stdio.readString()
        elif choice == 2:
            stdio.write(" Please enter the new Last Name: ")
            members[sid]['lname'] = stdio.readString()
        elif choice == 3:
            stdio.write(" Please enter the new Email address: ")
            members[sid]['email'] = stdio.readString()
        elif choice == 4:
            chances = 0
            while True:
                stdio.write(" Please enter the new Level (Grad/Ugrad): ")
                temp = stdio.readString()
                if temp not in ('Grad', 'Ugrad'):
                    chances += 1
                    if chances == 2:
                        stdio.writeln(" Sorry you have to start afresh.")
                        break
                    else:
                        stdio.writeln(" You have " + str(3 - chances) +
                                      "chance(s) to enter a valid Level.")
                else:
                    chances = 0
                    members[sid]['level'] = temp
                    break

        elif choice == 5:
            stdio.writeln(" Did nothing.")     # do nothing
        else:
            stdio.writeln(" You did not enter a valid choice.")

    else:
        stdio.writeln(" No record was found matching that student ID.")


def deleteRecord():
    global members
    stdio.write(" Please enter the student's ID you wish to delete: ")
    sid = stdio.readInt()
    if sid in members:
        stdio.writeln(" You are set to delete " + members[sid]['fname'] +
                      " " + members[sid]['lname'] + " from the registry.")
        stdio.write(" Are you sure you want to do this? ")
        if(stdio.readString().startswith('y')):
            stdio.write(" Enter the student's ID to confirm your action:")
            sid2 = stdio.readInt()
            if sid == sid2:
                del members[sid]
                stdio.writeln(" Record deleted from registry.")
            else:
                stdio.writeln(" There was a mismatch. Record not deleted.")
    else:
        stdio.writeln(" No record was found matching that student ID.")


def main():
    while(True):
        level0()
        try:
            x = int(raw_input())  # Unbuffered input, else try/exception fails
        except ValueError:
            stdio.writeln()
            stdio.writeln(" Invalid input. Try again.")
        else:
            if(x == 1):
                level01()
                try:
                    y = int(raw_input())
                except ValueError:
                    stdio.writeln()
                    stdio.writeln(" Invalid input. Try again.")
                else:
                    if(y == 1):
                        displaySummarizedRegistry()
                    elif(y == 2):
                        displayDetailedRegistry()
            elif(x == 2):
                level02()
                try:
                    y = int(raw_input())
                except ValueError:
                    stdio.writeln()
                    stdio.writeln(" Invalid input. Try again.")
                else:
                    if(y == 1):
                        addRecord()
                    elif(y == 2):
                        deleteRecord()
                    elif(y == 3):
                        changeRecord()
            elif(x == 3):
                stdio.writeln()
                stdio.writeln(" Thank you. Goodbye.")
                break
            else:
                stdio.writeln()
                stdio.writeln(" Unknown command. Please try again.")


if __name__ == '__main__':
    main()
