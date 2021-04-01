import flask
import mysql.connector
import json

app = flask.Flask(__name__)

MYSQL_USERNAME=""
MYSQL_PASSWORD=""
MYSQL_HOST=""
MYSQL_DB=""

mydb = mysql.connector.connect(
    host=MYSQL_HOST,
    user=MYSQL_USERNAME,
    password=MYSQL_PASSWORD,
    database=MYSQL_DB
)

@app.route("/validateTamakoCredentials/")
def doTamakoValidate():
    cursor = mydb.cursor()



    val = (flask.request.args.get('svcid'),flask.request.args.get('svcsecret'),flask.request.args.get('prvid'))
    cursor.execute("SELECT * FROM appservices WHERE serviceid=%s AND servicesecret=%s AND provisionid=%s",val)
    result = cursor.fetchall()

    status = {}

    if len(result) == 1:
        status = {

            "code": "200",
            "auth": "valid"

        }
    else:
        status = {

            "code": "403",
            "auth": "invalid"

        }
    return json.dumps(status)