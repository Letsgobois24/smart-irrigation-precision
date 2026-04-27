from database.mariadb.mariadb_client import createConnection

conn = createConnection()

def getConfiguration():
    with conn.cursor() as cursor:
        # Read a single record
        sql = "SELECT * FROM `configurations` WHERE `id`=1"
        cursor.execute(sql)
        return cursor.fetchone()