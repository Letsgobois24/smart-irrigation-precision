from database.mariadb.mariadb_client import createConnection


def createDependency():
    conn = createConnection()
    try:
        yield conn
    finally:
        conn.close()

def getConfiguration(conn):
    with conn.cursor() as cursor:
        # Read a single record
        sql = "SELECT * FROM `configurations` WHERE `id`=1"
        cursor.execute(sql)
        return cursor.fetchone()
    
def toggleSystem(conn, is_active: bool):
    with conn.cursor() as cursor:
        # Read a single record
        sql = "UPDATE `configurations` SET is_active=%s WHERE `id`=1"
        cursor.execute(sql, (1 if is_active else 0, ))
    conn.commit()