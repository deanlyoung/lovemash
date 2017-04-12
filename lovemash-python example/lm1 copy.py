#!/usr/bin/env python

from flask import Flask, request, session, render_template
from random import choice
import MySQLdb


# people = {'Dean Young':'223993', 'Katie Milliken':'213585', 'Molly Havard':'223745', 'Robin Lopez':'224180'}
db = MySQLdb.connect(host="66.147.244.133",
                     user="thisnort_aaron",
                     passwd="UJ6}0n=&Wf,.",
                     db="thisnort_lovemash")
# """

# you must create a Cursor object. It will let
#  you execute all the query you need
cur = db.cursor()

# Use all the SQL you like
cur.execute('SELECT friend_name, friend_fb_id, gender FROM newmember_friends WHERE user_fb_id = "535682154";')
people = {row[0]:(row[1], row[2]) for row in cur.fetchall()}
def gender(name, gend):
    return people[name][1] == gend

def isMale(name):
    return gender(name, "male")

def isFemale(name):
    return gender(name, "female")

dudes = filter(isMale, [name for name in people.keys()])
gals = filter(isFemale, [name for name in people.keys()])


def randomMFPair():
    return (choice(dudes), choice(gals))
    


app = Flask(__name__)

@app.route("/")
def index():
    pair = randomMFPair()
    return rendermatch(pair[0], pair[1], "unlocked")

@app.route("/roster")
def roster():
    return '<br>'.join(gals)

def rendermatch(n1, n2, lockstate):
    return render_template('match.html', name1=n1, name2=n2, lock_state1=lockstate, lock_state2="unlocked", fb_id1=people[n1][0], fb_id2=people[n2][0])

@app.route("/match/<n1>/<n2>")
def match(n1, n2):
    return rendermatch(n1, n2, "unlocked")

@app.route("/match/l/<n1>/<n2>")
def matchl(n1, n2):
    return rendermatch(n1, n2, "locked")

@app.route("/login")
def login():
    return "[Login here]"

@app.route("/logout")
def logout():
    return "You are logged out. Come back soon..."

@app.route("/yes")
def yes():
    return "Your 'Yes' vote has been recorded. Thank you, come again!"

@app.route("/no")
def no():
	return "Your 'No' vote has been recorded. Thank you, come again!"

if __name__ == "__main__":
    app.run(debug = True)
