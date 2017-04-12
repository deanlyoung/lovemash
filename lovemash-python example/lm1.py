#!/usr/bin/env python

from flask import Flask, request, session, render_template, redirect, url_for, escape
from random import choice
import MySQLdb
import sqlite3



#
#
#
#
#
# Can we abstract out
"""
    conn = sqlite3.connect('lm.db')
    conn.text_factory = str
    c = conn.cursor()
"""

# UP NEXT:
# record labelings
# look-up or calculate INTERESTED IN
# hone matches accordingly

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

# people = dict()

"""
people = dict()
dudes = dict()
gals = dict()
"""



app = Flask(__name__)

def gender(name, gend):
    return people[name][1] == gend

def isMale(name):
    return gender(name, "male")

def isFemale(name):
    return gender(name, "female")



def randomTwoPeople():
    conn = sqlite3.connect('lm.db')
    conn.text_factory = str
    c = conn.cursor()
    c.execute("SELECT fullname, fbid, gender, uid from people JOIN (SELECT friendid AS f FROM friends WHERE userid = ?) ON people.uid = f;", (session['usernum'],))
    people = c.fetchall()
    p1 = choice(people)
    p2 = choice(people)
    return (p1, p2)


# 550, 3128

def twoParticularPeople(uid1, uid2):
    conn = sqlite3.connect('lm.db')
    conn.text_factory = str
    c = conn.cursor()
    c.execute("SELECT fullname, fbid, gender, uid FROM people WHERE uid = ?;", (uid1,))
    p1 = c.fetchone()
    c.execute("SELECT fullname, fbid, gender, uid FROM people WHERE uid = ?;", (uid2,))
    p2 = c.fetchone()
    return (p1, p2)

"""
def randomMFPair():
    return (choice(session['dudes']), choice(session['gals']))
"""

"""
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

@app.route("/roster")
def roster():
    return str(session['practice']) + " | " + session['test']
    if 'people' in session:
        return '<br>'.join(list(session['people']))
    else:
        return '"people" not in session.'
"""

# set the secret key.  keep this really secret:
app.secret_key = 'A0Zr98j/3yX R~XHH!jmN]LWX/,?RTfdjsafl;fjads'

@app.route("/")
def index():
    if 'usernum' not in session:
        return "Login in first."
    pair = randomTwoPeople()
    nextpair = randomTwoPeople()
    return rendermatch2(pair[0], pair[1], "unlocked", nextpair[0][3], nextpair[0][3])

@app.route("/whitepages/<name>")
def whitepages(name):
    conn = sqlite3.connect('lm.db')
    conn.text_factory = str
    c = conn.cursor()
    c.execute("SELECT uid FROM people WHERE fullname = ?", (name,))
    return str(c.fetchall())

@app.route("/loginAs/<num>")
def loginAs(num):
    session['usernum'] = num
    return redirect(url_for('index'))
    #return "Logged in as user #" + str(session['usernum']) + '.'
    #popPeeps(num)

def rendermatch(n1, n2, lockstate):
    return render_template('match.html', name1=n1, name2=n2, lock_state1=lockstate, lock_state2="unlocked", fb_id1=100, fb_id2=100) #fb_id1=people[n1][0], fb_id2=people[n2][0])

def rendermatch2(n1, n2, lockstate, nn1, nn2):
    lmode = ""
    if lockstate == "locked":
        lmode = "l/"
    return render_template('match.html', name1=n1[0], name2=n2[0], lock_state1=lockstate, lock_state2="unlocked", fb_id1=n1[1], fb_id2=n2[1], uid1=n1[3], uid2=n2[3], nn1uid=nn1, nn2uid=nn2, mode=lmode) #fb_id1=people[n1][0], fb_id2=people[n2][0])

@app.route("/write_test", methods=['GET', 'POST'])
def write_test():
    sn = request.form['name']
    conn = sqlite3.connect('lm.db')
    conn.text_factory = str
    c = conn.cursor()
    c.execute('INSERT INTO test VALUES(?);', (sn, ))
    conn.commit()
    return "Recorded"

@app.route("/insert_vote", methods=['POST'])
def insert_vote():
    conn = sqlite3.connect('lm.db')
    conn.text_factory = str
    c = conn.cursor()
    c.execute('INSERT INTO votes VALUES(?,?,?);', (request.form['uid1'], request.form['uid2'], request.form['val']))
    conn.commit()
    return "DONEZO!"

@app.route("/match/<n1>/<n2>")
def match(n1, n2):
    pair = twoParticularPeople(n1, n2)
    nextpair = randomTwoPeople()
    return rendermatch2(pair[0], pair[1], "unlocked", nextpair[0][3], nextpair[1][3])

@app.route("/match/l/<n1>/<n2>")
def matchl(n1, n2):
    pair = twoParticularPeople(n1, n2)
    nextpair = randomTwoPeople()
    # return str(nextpair)
    return rendermatch2(pair[0], pair[1], "locked", pair[0][3], nextpair[1][3])

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
