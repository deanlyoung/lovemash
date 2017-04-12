#!/usr/bin/env python

from flask import Flask, request, session, render_template, redirect, url_for, escape
from random import choice
import MySQLdb
import sqlite3

"""
# people = {'Dean Young':'223993', 'Katie Milliken':'213585', 'Molly Havard':'223745', 'Robin Lopez':'224180'}
db = MySQLdb.connect(host="66.147.244.133",
                     user="thisnort_aaron",
                     passwd="UJ6}0n=&Wf,.",
                     db="thisnort_lovemash")

# you must create a Cursor object. It will let
#  you execute all the query you need
cur = db.cursor()

# Use all the SQL you like
cur.execute('SELECT friend_name, friend_fb_id, gender FROM newmember_friends WHERE user_fb_id = "535682154";')
people = {row[0]:(row[1], row[2]) for row in cur.fetchall()}
"""

conn = sqlite3.connect('lm.db')
conn.text_factory = str
c = conn.cursor()

# people = dict()

people = dict()
dudes = dict()
gals = dict()

def gender(name, gend):
    return people[name][1] == gend

def isMale(name):
    return gender(name, "male")

def isFemale(name):
    return gender(name, "female")

def popPeeps(num):
    global people;
    global dudes;
    global gals;
    c.execute("SELECT fullname, fbid, gender from people JOIN (SELECT friendid AS f FROM friends WHERE userid = ?) ON people.uid = f;", (num,))
    people = {row[0]:(row[1], row[2]) for row in c.fetchall()}
    dudes = filter(isMale, [name for name in people.keys()])
    gals = filter(isFemale, [name for name in people.keys()])

popPeeps(2)


def randomMFPair():
    return (choice(dudes), choice(gals))

app = Flask(__name__)

@app.route('/session')
def sesh():
    if 'username' in session:
        return 'Logged in as %s' % escape(session['username']) + '. <a href="' + url_for('sessionLogout') + '"> Logout</a>.'
    return 'You are not logged in. Log in <a href="' + url_for('sessionLogin') + '">here</a>.'

@app.route('/sessionLogin', methods=['GET', 'POST'])
def sessionLogin():
    if request.method == 'POST':
        session['username'] = request.form['username']
        return redirect(url_for('sesh'))
    return '''
        <form action="" method="post">
            <p><input type=text name=username>
            <p><input type=submit value=Login>
        </form>
'''

@app.route('/sessionLogout')
def sessionLogout():
    # remove the username from the session if it's there
    session.pop('username', None)
    return redirect(url_for('sesh'))

# set the secret key.  keep this really secret:
app.secret_key = 'A0Zr98j/3yX R~XHH!jmN]LWX/,?RT'

@app.route("/")
def index():
    pair = randomMFPair()
    return rendermatch(pair[0], pair[1], "unlocked")

@app.route("/loginAs/<num>")
def loginAs(num):
    popPeeps(num)

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
