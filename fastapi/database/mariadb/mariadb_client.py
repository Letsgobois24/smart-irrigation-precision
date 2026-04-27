import pymysql.cursors
import os

def createConnection():
    return pymysql.connect(
        host=os.getenv('MARIADB_HOST'), 
        user=os.getenv('MARIADB_USERNAME'), 
        password=os.getenv('MARIADB_PASSWORD'), 
        database=os.getenv('MARIADB_DATABASE'), 
        cursorclass=pymysql.cursors.DictCursor,
        autocommit=False)