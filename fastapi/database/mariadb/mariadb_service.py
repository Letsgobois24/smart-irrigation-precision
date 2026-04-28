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
        cursor.execute(sql, (is_active, ))
    conn.commit()

def sendNotification(conn, data):
    with conn.cursor() as cursor:
        sql = "INSERT INTO notifications (title, message, recomendation, source_type,sensor_type, severity, value, threshold,node_id, tree_id, is_active, is_read,created_at, updated_at) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
        values = (
                data['title'],
                data['message'],
                data['recomendation'],
                data['source_type'],
                data['sensor_type'],
                data['severity'],
                data['value'],
                data['threshold'],
                data['node_id'],
                data['tree_id'],
                int(data['is_active']),
                int(data['is_read']),
                data['created_at'],
                data['updated_at']
            )
        
        print('SQL: ', sql)
        print('Values: ', values)

        cursor.execute(sql, values)
    conn.commit()